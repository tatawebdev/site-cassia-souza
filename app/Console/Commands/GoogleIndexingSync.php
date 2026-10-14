<?php

namespace App\Console\Commands;

use App\Models\IndexedPage;
use App\Services\GoogleIndexingService;
use Illuminate\Console\Command;

class GoogleIndexingSync extends Command
{
    protected $signature = 'google:indexing-sync {--force : Reenvia mesmo as URLs já marcadas como indexadas}';

    protected $description = 'Envia para a Google Indexing API as URLs do site (páginas fixas e de serviço) ainda não indexadas, registrando o resultado em indexed_pages';

    public function handle(GoogleIndexingService $indexing): int
    {
        if (! config('services.google_indexing.enabled')) {
            $this->warn('Google Indexing desativado (GOOGLE_INDEXING_ENABLED=false). Nada enviado.');

            return Command::SUCCESS;
        }

        $urls = [
            route('inicio'),
            route('sobre'),
            route('servicos'),
            route('contato'),
            route('privacy'),
        ];

        // Uma página por serviço (config/servicos.php)
        foreach (config('servicos') as $servico) {
            $urls[] = route($servico['route']);
        }

        // Normaliza para a URL canônica de produção, para não duplicar linhas em indexed_pages
        $urls = array_unique(array_map(fn ($url) => $indexing->toProductionUrl($url), $urls));

        $force = (bool) $this->option('force');

        $this->info(sprintf(
            'Verificando %d URLs (%s)...',
            count($urls),
            $force ? 'reenviando todas' : 'só as ainda não indexadas'
        ));

        $ok = 0;
        $fail = 0;
        $skipped = 0;

        foreach ($urls as $url) {
            $page = IndexedPage::firstOrNew(['url' => $url]);

            if (! $force && $page->exists && $page->indexed_at) {
                $skipped++;
                $this->line("  SKIP {$url}");

                continue;
            }

            if ($indexing->notifyUrlUpdate($url)) {
                $page->fill(['indexed_at' => now(), 'last_error' => null])->save();
                $ok++;
                $this->line("  OK   {$url}");
            } else {
                $page->fill(['last_error' => 'Falha ao notificar o Google Indexing API — ver storage/logs/laravel.log'])->save();
                $fail++;
                $this->error(" FALHA {$url}");
            }
        }

        $this->newLine();
        $this->info("Concluído: {$ok} enviadas, {$skipped} já indexadas (puladas), {$fail} falharam.");

        return $fail > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
