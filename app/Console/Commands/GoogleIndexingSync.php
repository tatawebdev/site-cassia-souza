<?php

namespace App\Console\Commands;

use App\Models\IndexedPage;
use App\Services\IndexacaoGoogle;
use App\Services\Sitemap;
use Illuminate\Console\Command;

/**
 * Envia ao Google (Indexing API) as páginas do sitemap que ainda não foram enviadas,
 * até acabar a cota diária. Quando a cota acaba, para e pausa os envios por 36 h
 * (o site também respeita essa pausa); rodando de novo depois, continua de onde parou.
 */
class GoogleIndexingSync extends Command
{
    protected $signature = 'google:indexing-sync
        {--force : Reenvia mesmo as URLs já marcadas como indexadas}
        {--limite= : Envia no máximo esta quantidade nesta rodada}
        {--ignorar-pausa : Tenta mesmo durante a pausa do limite diário}';

    protected $description = 'Envia para a Google Indexing API as páginas do sitemap ainda não indexadas (até a cota diária), registrando o resultado em indexed_pages';

    public function handle(IndexacaoGoogle $indexacao, Sitemap $sitemap): int
    {
        if (! config('services.google_indexing.enabled')) {
            $this->warn('Google Indexing desativado (GOOGLE_INDEXING_ENABLED=false). Nada enviado.');

            return Command::SUCCESS;
        }

        if (($ate = $indexacao->pausadoAte()) && ! $this->option('ignorar-pausa')) {
            $this->warn("Limite diário do Google atingido. Envios pausados até {$ate->format('d/m/Y H:i')}. Rode de novo depois disso (ou use --ignorar-pausa).");

            return Command::SUCCESS;
        }
        if ($this->option('ignorar-pausa')) {
            $indexacao->liberarPausa();
        }

        // Mesma lista do sitemap: institucionais + páginas de SEO liberadas, no domínio de produção
        $urls = collect(Sitemap::institucionais())
            ->concat($sitemap->paginasSeo()->pluck('url'))
            ->map(fn ($url) => $indexacao->url($url))
            ->unique()->values();

        $force = (bool) $this->option('force');
        $feitas = $force ? collect() : IndexedPage::whereIn('url', $urls)->whereNotNull('indexed_at')->pluck('url');
        $pendentes = $urls->diff($feitas)->values();
        if ($limite = (int) $this->option('limite')) {
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
                $this->warn("Limite diário do Google atingido depois de {$ok} envios. Faltam {$restantes} páginas.");
                $this->warn('Envios pausados por '.IndexacaoGoogle::PAUSA_HORAS.' h ('.$indexacao->pausadoAte()?->format('d/m/Y H:i').'). Rode o comando de novo depois disso.');

                return Command::SUCCESS;
            }

            $falhas++;
            $this->error(" FALHA {$url}");
        }

        $this->newLine();
        $this->info("Concluído: {$ok} enviadas, {$falhas} falharam, {$feitas->count()} já tinham sido enviadas.");

        return $falhas > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
