<?php

namespace App\Http\Controllers;

use App\Models\SeoLocalidade;
use App\Services\PaginaSeo;

/**
 * Endereços herdados do site antigo:
 *   /{termo}/{localidade}       página de SEO (ex.: /advocacia-tributaria/suzano)
 *   /{termo}/{localidade}/{uf}  301 para o endereço sem UF (ou para o homônimo daquela UF)
 *   /{termo}                    página do termo com as cidades em destaque
 *   /{localidade}               301 para /advocacia-tributaria/{localidade}
 */
class PaginaSeoController extends Controller
{
    public function __invoke(PaginaSeo $seo, string $termo, ?string $local = null, ?string $uf = null)
    {
        // Endereços antigos com apóstrofo (alta-floresta-d'oeste) ou maiúsculas
        $normal = fn (?string $s) => $s === null ? null : strtolower(str_replace("'", '', $s));
        if ($normal($termo) !== $termo || $normal($local) !== $local) {
            return redirect('/'.implode('/', array_filter([$normal($termo), $normal($local), $uf ? strtolower($uf) : null])), 301);
        }

        $seoTermo = $seo->termo($termo);

        if (! $seoTermo) {
            // Um segmento só: localidade do sitemap antigo
            abort_if($local !== null || ! SeoLocalidade::where('slug', $termo)->exists(), 404);

            return redirect($seo->url('advocacia-tributaria', $termo), 301);
        }

        if ($local === null) {
            return view('novo.seo.termo', $seo->montarTermo($seoTermo));
        }

        if ($uf !== null) {
            // Homônimo com UF (bom-jesus/pi) vai direto para a cidade daquele estado
            $destino = SeoLocalidade::where('slug', $local.'-'.strtolower($uf))->value('slug') ?? $local;

            return redirect($seo->url($termo, $destino), 301);
        }

        $localidade = SeoLocalidade::where('slug', $local)->firstOrFail();

        return view('novo.seo.pagina', $seo->montar($seoTermo, $localidade));
    }
}
