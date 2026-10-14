<?php

namespace App\Console\Commands;

use App\Models\SeoBloco;
use App\Models\SeoTermo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Carrega no banco o conteúdo inicial das páginas de SEO (database/data/seo).
 * Só cria o que falta: textos já editados no banco não são sobrescritos.
 */
class SeoImportarCommand extends Command
{
    protected $signature = 'seo:importar
        {--termos : Regrava os termos e blocos a partir de database/data/seo/termos.php (perde edições feitas no banco)}';

    protected $description = 'Cria os termos, blocos e localidades das páginas de SEO /{termo}/{localidade}';

    public function handle(): int
    {
        $dados = require database_path('data/seo/termos.php');
        $regravar = (bool) $this->option('termos');

        $termos = 0;
        foreach ($dados['termos'] as $slug => $termo) {
            $existe = SeoTermo::where('slug', $slug)->exists();
            if (! $existe || $regravar) {
                SeoTermo::updateOrCreate(['slug' => $slug], $termo);
                $termos++;
            }
        }

        $blocos = 0;
        foreach ($dados['blocos'] as $chave => $conteudo) {
            $existe = SeoBloco::where('chave', $chave)->exists();
            if (! $existe || $regravar) {
                SeoBloco::updateOrCreate(['chave' => $chave], ['conteudo' => $conteudo]);
                $blocos++;
            }
        }

        // Localidades: inserção em lotes, ignorando as que já existem (slug único)
        $agora = now();
        $antes = DB::table('seo_localidades')->count();
        $linhas = json_decode(file_get_contents(database_path('data/seo/localidades.json')), true);
        foreach (array_chunk($linhas, 500) as $lote) {
            DB::table('seo_localidades')->insertOrIgnore(array_map(function ($l) use ($agora) {
                $l += ['created_at' => $agora, 'updated_at' => $agora];
                ksort($l);

                return $l;
            }, $lote));
        }
        $localidades = DB::table('seo_localidades')->count() - $antes;

        $this->info("Termos gravados: {$termos} · blocos: {$blocos} · localidades novas: {$localidades}.");

        return self::SUCCESS;
    }
}
