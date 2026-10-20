<?php

namespace App\Console\Commands;

use App\Models\FcmAviso;
use App\Models\FcmToken;
use App\Services\FcmService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * Envio manual do aviso de artigo novo para todos os inscritos do site. Sem
 * endereço, pega o post mais recente do feed do blog. Os posts publicados depois
 * saem sozinhos (o blog chama /api/fcm/avisos); este comando é para o primeiro
 * envio ou para repetir um aviso.
 */
class FcmAvisarArtigoCommand extends Command
{
    protected $signature = 'fcm:avisar-artigo
        {url? : Endereço do post no blog (padrão: o mais recente do feed)}
        {--titulo= : Título do aviso (padrão: o do feed)}
        {--forcar : Envia mesmo que esse post já tenha sido avisado}';

    protected $description = 'Avisa os inscritos do site sobre um artigo do blog (padrão: o último publicado)';

    public function handle(FcmService $fcm): int
    {
        $url = $this->argument('url');
        $titulo = $this->option('titulo');

        if (! $url || ! $titulo) {
            $post = $this->ultimoPost();
            if (! $post) {
                $this->error('Não consegui ler o feed do blog.');

                return self::FAILURE;
            }
            $url ??= $post['url'];
            $titulo ??= $post['titulo'];
        }

        $aviso = FcmAviso::firstOrNew(['url' => $url]);
        if ($aviso->exists && ! $this->option('forcar')) {
            $this->warn("Esse post já foi avisado em {$aviso->created_at->format('d/m/Y H:i')}. Use --forcar para mandar de novo.");

            return self::SUCCESS;
        }
        $aviso->titulo = $titulo;
        $aviso->save();

        $inscritos = FcmToken::where('publico', FcmToken::SITE)->count();
        $this->line("Avisando {$inscritos} inscritos: \"{$titulo}\" ({$url})");

        $fcm->avisarArtigo($aviso);
        $aviso->refresh();

        if ($inscritos && ! $aviso->enviados && ! $aviso->falhas) {
            $this->error('Nada foi enviado: veja o motivo em storage/logs (conta de serviço do Firebase em '.config('services.fcm.credentials_path').'?).');

            return self::FAILURE;
        }
        $this->info("{$aviso->enviados} enviados, {$aviso->falhas} falharam.");

        return self::SUCCESS;
    }

    /** @return array{url: string, titulo: string}|null */
    private function ultimoPost(): ?array
    {
        $resposta = Http::timeout(20)->get('https://blog.cassiasouzaadvocacia.com.br/feed/');
        if ($resposta->failed()) {
            return null;
        }

        $feed = @simplexml_load_string($resposta->body());
        $item = $feed?->channel?->item[0] ?? null;
        if (! $item) {
            return null;
        }

        return ['url' => trim((string) $item->link), 'titulo' => html_entity_decode(trim((string) $item->title), ENT_QUOTES)];
    }
}
