<?php

namespace App\Http\Controllers;

use App\Models\SeoLocalidade;
use App\Models\SeoTermo;
use App\Services\PaginaSeo;

/**
 * Endereços de SEO e localidades:
 *   /{termo}/{localidade}       página de SEO (ex.: /advocacia-tributaria/suzano)
 *   /{termo}/{localidade}/{uf}  301 para o endereço sem UF (ou para o homônimo daquela UF)
 *   /{termo}                    página do termo com as cidades em destaque
 *   /{localidade}               página da cidade direta (tema novo, sem redirect 301 externo)
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
            // Localidade direta (ex.: /abdon-batista ou /bom-jesus/pi) sem redirect externo
            $slugLocal = $local && $uf ? $local.'-'.strtolower($uf) : ($local ? $termo.'-'.strtolower($local) : $termo);
            $localidade = SeoLocalidade::where('slug', $slugLocal)->first()
                ?? SeoLocalidade::where('slug', $termo)->first();

            abort_if(! $localidade, 404);

            $termoPadrao = $seo->termo('advocacia-tributaria') ?? SeoTermo::where('ativo', true)->firstOrFail();
            $dados = $seo->montar($termoPadrao, $localidade);
            $dados['canonical'] = url('/'.$localidade->slug);

            return view('novo.seo.pagina', $dados);
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
