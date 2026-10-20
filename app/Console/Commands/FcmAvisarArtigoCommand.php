<?php

namespace App\Console\Commands;

use App\Models\FcmAviso;
use App\Models\FcmToken;
use App\Models\NewsletterSubscriber;
use App\Services\AvisoArtigo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * Envio manual do aviso de artigo novo: notificação no navegador e e-mail para a
 * newsletter. Sem endereço, pega o post mais recente do feed do blog. Os posts
 * publicados depois saem sozinhos (o blog chama /api/fcm/avisos); este comando é
 * para o primeiro envio, para repetir um aviso ou para testar o e-mail (--para).
 */
class FcmAvisarArtigoCommand extends Command
{
    protected $signature = 'fcm:avisar-artigo
        {url? : Endereço do post no blog (padrão: o mais recente do feed)}
        {--titulo= : Título do aviso (padrão: o do feed)}
        {--para= : Só testa o e-mail, mandando para este endereço (não avisa ninguém)}
        {--sem-email : Não manda e-mail para a newsletter}
        {--sem-navegador : Não manda notificação no navegador}
        {--forcar : Envia mesmo que esse post já tenha sido avisado}';

    protected $description = 'Avisa os inscritos (navegador e e-mail) sobre um artigo do blog (padrão: o último publicado)';

    public function handle(AvisoArtigo $avisoArtigo): int
    {
        $url = $this->argument('url');
        $post = ['titulo' => $this->option('titulo')];

        if (! $url || ! $post['titulo']) {
            $doFeed = $this->ultimoPost($url);
            if (! $doFeed) {
                $this->error('Não consegui achar o post no feed do blog.');

                return self::FAILURE;
            }
            $post = array_merge($doFeed, array_filter($post));
            $url ??= $doFeed['url'];
        }
        unset($post['url']);

        if ($para = $this->option('para')) {
            $aviso = (new FcmAviso)->forceFill(['url' => $url] + $post);
            $teste = new NewsletterSubscriber(['email' => $para]);
            $teste->id = 0;
            $ok = $avisoArtigo->enviarEmail($aviso, $teste);
            $ok ? $this->info("E-mail de teste enviado para {$para}.") : $this->error('Não enviou: veja storage/logs.');

            return $ok ? self::SUCCESS : self::FAILURE;
        }

        $aviso = FcmAviso::firstOrNew(['url' => $url]);
        if ($aviso->exists && ! $this->option('forcar')) {
            $this->warn("Esse post já foi avisado em {$aviso->created_at->format('d/m/Y H:i')}. Use --forcar para mandar de novo.");

            return self::SUCCESS;
        }
        $aviso->fill($post)->save();

        $navegador = ! $this->option('sem-navegador');
        $email = ! $this->option('sem-email');
        $inscritos = FcmToken::where('publico', FcmToken::SITE)->count();
        $this->line("Avisando: \"{$aviso->titulo}\" ({$url})");

        $avisoArtigo->enviar($aviso, $navegador, $email);
        $aviso->refresh();

        if ($navegador) {
            if ($inscritos && ! $aviso->enviados && ! $aviso->falhas) {
                $this->error('Navegador: nada foi enviado. Veja o motivo em storage/logs (conta de serviço do Firebase?).');
            } else {
                $this->info("Navegador: {$aviso->enviados} enviados, {$aviso->falhas} falharam ({$inscritos} inscritos).");
            }
        }
        if ($email) {
            $this->info("E-mail: {$aviso->emails_enviados} enviados, {$aviso->emails_falhas} falharam.");
        }

        return self::SUCCESS;
    }

    /**
     * Post do feed: o mais recente, ou o do endereço pedido (se estiver no feed).
     *
     * @return array{url: string, titulo: string, resumo: ?string, imagem: ?string, categoria: ?string}|null
     */
    private function ultimoPost(?string $url = null): ?array
    {
        $resposta = Http::timeout(20)->get('https://blog.cassiasouzaadvocacia.com.br/feed/');
        if ($resposta->failed()) {
            return null;
        }

        $feed = @simplexml_load_string($resposta->body());
        foreach ($feed?->channel?->item ?? [] as $item) {
            if ($url && trim((string) $item->link) !== $url) {
                continue;
            }

            $conteudo = (string) $item->children('content', true)->encoded;
            preg_match('/<img[^>]+src="([^"]+)"/', $conteudo, $imagem);
            $resumo = trim(html_entity_decode(strip_tags((string) $item->description), ENT_QUOTES));

            return [
                'url' => trim((string) $item->link),
                'titulo' => html_entity_decode(trim((string) $item->title), ENT_QUOTES),
                'resumo' => preg_replace('/\s*\[(…|&#8230;|\.\.\.)\]\s*$/u', '…', $resumo) ?: null,
                'imagem' => $imagem[1] ?? null,
                'categoria' => isset($item->category[0]) ? trim((string) $item->category[0]) : null,
            ];
        }

        return null;
    }
}
