<?php

namespace App\Services;

use App\Models\SeoLocalidade;
use App\Models\SeoPagina;
use App\Models\SeoTermo;
use Illuminate\Support\Collection;

/**
 * Endereços que devem estar no Google: as páginas institucionais (também enviadas
 * pela Google Indexing API) e as páginas de SEO liberadas para indexar.
 */
class Sitemap
{
    /** Home, sobre, serviços, contato, privacidade e uma página por serviço */
    public static function institucionais(): array
    {
        $urls = [route('inicio'), route('sobre'), route('servicos'), route('contato'), route('privacy')];

        foreach (config('servicos') as $servico) {
            $urls[] = route($servico['route']);
        }

        return $urls;
    }

    /**
     * Páginas de SEO indexáveis, com a data da última mudança. Mesma regra de
     * PaginaSeo::montar(): seo_paginas.indexar manda; sem ele, termo principal
     * indexável × localidade indexável (homônimos nunca).
     *
     * @return Collection<int, array{url: string, lastmod: \Illuminate\Support\Carbon}>
     */
    public function paginasSeo(): Collection
    {
        $termos = SeoTermo::where('ativo', true)->whereNull('canonical')->get()->keyBy('id');
        $locais = SeoLocalidade::where('indexar', true)->where('tipo', '!=', 'homonimo')->get()->keyBy('id');
        $editadas = SeoPagina::whereIn('seo_termo_id', $termos->keys())->whereNotNull('indexar')->get();

        $paginas = collect();
        $item = fn ($termo, $local, $data) => [
            'url' => url('/'.$termo->slug.'/'.$local->slug),
            'lastmod' => max($termo->updated_at, $local->updated_at, $data ?? $termo->updated_at),
        ];

        foreach ($termos->where('indexar', true) as $termo) {
            $paginas->push(['url' => url('/'.$termo->slug), 'lastmod' => $termo->updated_at]);
            foreach ($locais as $local) {
                $paginas->put($termo->id.'-'.$local->id, $item($termo, $local, null));
            }
        }

        // Decisão por página: libera (mesmo fora da regra) ou tira do Google
        foreach ($editadas as $pagina) {
            $chave = $pagina->seo_termo_id.'-'.$pagina->seo_localidade_id;
            if (! $pagina->indexar) {
                $paginas->forget($chave);
            } elseif ($local = $locais[$pagina->seo_localidade_id] ?? SeoLocalidade::find($pagina->seo_localidade_id)) {
                if ($local->tipo !== 'homonimo') {
                    $paginas->put($chave, $item($termos[$pagina->seo_termo_id], $local, $pagina->updated_at));
                }
            }
        }

        return $paginas->values();
    }
}
