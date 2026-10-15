<?php

namespace App\Http\Middleware;

use App\Services\IndexacaoGoogle;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Envia ao Google (Indexing API) cada página indexável na primeira vez que ela é
 * aberta. O envio acontece em terminate(), depois que a página já foi entregue ao
 * visitante. Quem decide se a página é indexável é o próprio HTML: meta robots
 * sem noindex e canonical igual ao endereço aberto. Registro do resultado em
 * App\Services\IndexacaoGoogle.
 */
class IndexarNoGoogle
{
    public function __construct(private IndexacaoGoogle $indexacao) {}

    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        // Só em produção (o .env local usa o banco de produção: navegar localmente não deve enviar nem gravar nada)
        if (! app()->environment(['production', 'testing']) || ! config('services.google_indexing.enabled')
            || ! $url = $this->urlIndexavel($request, $response)) {
            return;
        }

        // Cache evita ir ao banco a cada visita das páginas já enviadas
        $feito = 'google-indexing:feito:'.md5($url);
        if (Cache::has($feito)) {
            return;
        }

        if ($this->indexacao->jaIndexada($url)) {
            Cache::forever($feito, true);

            return;
        }

        // Uma tentativa por endereço a cada 6 h (visitas simultâneas ou erro passageiro)
        $tentativa = 'google-indexing:tentativa:'.md5($url);
        if (! Cache::add($tentativa, true, now()->addHours(6))) {
            return;
        }

        // Limite ou erro: a trava de 6 h acima evita repetir a cada visita; depois tenta de novo
        if ($this->indexacao->enviar($url) === IndexacaoGoogle::OK) {
            Cache::forever($feito, true);
        }
    }

    /** Endereço oficial da página, se ela deve ir para o Google; senão null */
    private function urlIndexavel(Request $request, Response $response): ?string
    {
        if (! $request->isMethod('GET') || $request->ajax() || $request->getQueryString()
            || $response->getStatusCode() !== 200
            || ! str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            return null;
        }

        $html = (string) $response->getContent();

        if (preg_match('#<meta name="robots" content="([^"]*)"#', $html, $robots) && str_contains($robots[1], 'noindex')) {
            return null;
        }
        if (! preg_match('#<link rel="canonical" href="([^"]*)"#', $html, $canonical)) {
            return null;
        }

        // Sinônimos e afins apontam o canonical para outra página: essa outra é que vai ao Google
        $oficial = html_entity_decode($canonical[1]);
        if (rtrim($oficial, '/') !== rtrim($request->url(), '/')) {
            return null;
        }

        return $this->indexacao->url($oficial);
    }
}
