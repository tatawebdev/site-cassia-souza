<?php

namespace App\Console\Commands;

use App\Models\IndexedPage;
use App\Models\SeoPagina;
use App\Services\IndexacaoGoogle;
use App\Services\Sitemap;
use Illuminate\Console\Command;

/**
 * Envia ao Google (Indexing API) as páginas do sitemap que ainda não foram enviadas,
 * até acabar a cota diária. Quando a cota acaba, para; sem pausa:
 * rodando de novo (ou no próximo deploy), tenta e continua de onde parou.
 *
 * Com --loop: quando não há mais páginas pendentes, libera um novo lote com
 * seo:liberar (Alto Tietê primeiro) e continua enviando, até a cota do dia acabar
 * ou não haver mais o que liberar.
 */
class GoogleIndexingSync extends Command
{
    protected $signature = 'google:indexing-sync
        {--force : Reenvia mesmo as URLs já marcadas como indexadas}
        {--limite= : Envia no máximo esta quantidade nesta rodada}
        {--loop : Libera novas páginas (seo:liberar) e continua enviando até acabar a cota do Google}
        {--lote=20 : No --loop, quantas páginas liberar por vez}';

    protected $description = 'Envia para a Google Indexing API as páginas do sitemap ainda não indexadas (até a cota diária), registrando o resultado em indexed_pages';

    public function handle(IndexacaoGoogle $indexacao, Sitemap $sitemap): int
    {
        if (! config('services.google_indexing.enabled')) {
            $this->warn('Google Indexing desativado (GOOGLE_INDEXING_ENABLED=false). Nada enviado.');

            return Command::SUCCESS;
        }

        if (! $this->option('loop')) {
            $r = $this->enviarPendentes($indexacao, $sitemap, (bool) $this->option('force'), (int) $this->option('limite'));

            return $r['falhas'] > 0 ? Command::FAILURE : Command::SUCCESS;
        }

        // --loop: envia, libera mais, envia de novo... até a cota acabar
        $lote = max(1, (int) $this->option('lote'));
        $enviadas = 0;
        $liberadas = 0;
        while (true) {
            $r = $this->enviarPendentes($indexacao, $sitemap, false, 0);
            $enviadas += $r['ok'];

            if ($r['limite']) {
                break;
            }
            // Só falhas (erro que não é a cota): para, para não repetir o erro sem fim
            if ($r['falhas'] > 0 && $r['ok'] === 0) {
                $this->error('Envios falharam sem ser pela cota; parando. Veja last_error em indexed_pages.');

                return Command::FAILURE;
            }

            $antes = SeoPagina::where('indexar', true)->count();
            $this->callSilently('seo:liberar', ['--quantidade' => $lote]);
            $novas = SeoPagina::where('indexar', true)->count() - $antes;
            if ($novas === 0) {
                $this->info('Não há mais páginas para liberar.');
                break;
            }
            $liberadas += $novas;
            $this->info("Liberadas mais {$novas} páginas (seo:liberar).");
        }

        $this->newLine();
        $this->info("Loop concluído: {$liberadas} páginas liberadas e {$enviadas} enviadas ao Google nesta execução.");

        return Command::SUCCESS;
    }

    /**
     * Envia as páginas do sitemap ainda não enviadas.
     *
     * @return array{ok: int, falhas: int, limite: bool}
     */
    private function enviarPendentes(IndexacaoGoogle $indexacao, Sitemap $sitemap, bool $force, int $limite): array
    {
        // Mesma lista do sitemap: institucionais + páginas de SEO liberadas, no domínio de produção
        $urls = collect(Sitemap::institucionais())
            ->concat($sitemap->paginasSeo()->pluck('url'))
            ->map(fn ($url) => $indexacao->url($url))
            ->unique()->values();

        $feitas = $force ? collect() : IndexedPage::whereIn('url', $urls)->whereNotNull('indexed_at')->pluck('url');
        $pendentes = $urls->diff($feitas)->values();
        if ($limite) {
            $pendentes = $pendentes->take($limite);
        }

        $this->info(sprintf('%d páginas no sitemap, %d já enviadas, %d para enviar agora.', $urls->count(), $feitas->count(), $pendentes->count()));

        $ok = 0;
        $falhas = 0;
        foreach ($pendentes as $url) {
            $resultado = $indexacao->enviar($url);

            if ($resultado === IndexacaoGoogle::OK) {
                $ok++;
                $this->line("  OK   {$url}");

                continue;
            }

            if ($resultado === IndexacaoGoogle::LIMITE) {
                $restantes = $urls->count() - $feitas->count() - $ok;
                $this->newLine();
                $this->warn("Limite diário do Google atingido depois de {$ok} envios. Faltam {$restantes} páginas; a próxima execução tenta de novo.");

                return ['ok' => $ok, 'falhas' => $falhas, 'limite' => true];
            }

            $falhas++;
            $this->error(" FALHA {$url}");
        }

        $this->newLine();
        $this->info("Concluído: {$ok} enviadas, {$falhas} falharam, {$feitas->count()} já tinham sido enviadas.");

        return ['ok' => $ok, 'falhas' => $falhas, 'limite' => false];
    }
}
