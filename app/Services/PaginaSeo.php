<?php

namespace App\Services;

use App\Models\SeoBloco;
use App\Models\SeoLocalidade;
use App\Models\SeoPagina;
use App\Models\SeoTermo;
use Illuminate\Support\Collection;

/**
 * Monta as páginas de SEO /{termo}/{localidade}: texto do termo (modelo), blocos
 * compartilhados e, por cima, a página editada à mão (seo_paginas), quando existe.
 *
 * Indexação: a página entra no Google quando seo_paginas.indexar manda, ou, sem
 * essa decisão, quando o termo e a localidade estão marcados para indexar.
 * Termos sinônimos (canonical) apontam para a página do termo principal.
 */
class PaginaSeo
{
    /** Nome e preposição de cada UF ("ICMS do Paraná", "da Bahia", "de São Paulo") */
    public const ESTADOS = [
        'AC' => ['Acre', 'do'], 'AL' => ['Alagoas', 'de'], 'AP' => ['Amapá', 'do'], 'AM' => ['Amazonas', 'do'],
        'BA' => ['Bahia', 'da'], 'CE' => ['Ceará', 'do'], 'DF' => ['Distrito Federal', 'do'], 'ES' => ['Espírito Santo', 'do'],
        'GO' => ['Goiás', 'de'], 'MA' => ['Maranhão', 'do'], 'MT' => ['Mato Grosso', 'de'], 'MS' => ['Mato Grosso do Sul', 'de'],
        'MG' => ['Minas Gerais', 'de'], 'PA' => ['Pará', 'do'], 'PB' => ['Paraíba', 'da'], 'PR' => ['Paraná', 'do'],
        'PE' => ['Pernambuco', 'de'], 'PI' => ['Piauí', 'do'], 'RJ' => ['Rio de Janeiro', 'do'], 'RN' => ['Rio Grande do Norte', 'do'],
        'RS' => ['Rio Grande do Sul', 'do'], 'RO' => ['Rondônia', 'de'], 'RR' => ['Roraima', 'de'], 'SC' => ['Santa Catarina', 'de'],
        'SP' => ['São Paulo', 'de'], 'SE' => ['Sergipe', 'de'], 'TO' => ['Tocantins', 'do'],
    ];

    /** Termo ativo pelo slug */
    public function termo(string $slug): ?SeoTermo
    {
        return SeoTermo::where('slug', $slug)->where('ativo', true)->first();
    }

    public function url(string $termo, ?string $localidade = null): string
    {
        return url('/'.$termo.($localidade ? '/'.$localidade : ''));
    }

    /** Dados prontos para a view novo/seo/pagina */
    public function montar(SeoTermo $termo, SeoLocalidade $local): array
    {
        $pagina = SeoPagina::where('seo_termo_id', $termo->id)->where('seo_localidade_id', $local->id)->first();
        $trocar = fn ($texto) => $this->trocar($texto, $termo, $local);

        // Cada página usa sempre a mesma variação de abertura (pelo par termo + localidade)
        $variacoes = $termo->introducoes ?: [[]];
        $introducao = $pagina?->introducao ?: $variacoes[crc32($termo->slug.'|'.$local->slug) % count($variacoes)];

        $secoes = $pagina?->secoes ?: ($termo->secoes ?: SeoBloco::conteudo('secoes', []));
        // Texto próprio da localidade (pesquisa) vem antes das seções gerais
        $secoes = array_merge($local->secoes ?: [], $secoes);

        $atendimento = SeoBloco::conteudo($local->presencial ? 'atendimento_presencial' : 'atendimento_online', []);

        $canonicalTermo = $termo->canonical ?: $termo->slug;
        $indexar = $pagina?->indexar ?? ($termo->indexar && $local->indexar && $local->tipo !== 'homonimo');

        return [
            'termo' => $termo,
            'local' => $local,
            'pagina' => $pagina,
            'servico' => collect(config('servicos'))->firstWhere('slug', $termo->servico),
            'h1' => $trocar($pagina?->h1 ?: $termo->h1),
            'titulo_seo' => $trocar($pagina?->titulo_seo ?: $termo->titulo_seo),
            'descricao_seo' => $trocar($pagina?->descricao_seo ?: $termo->descricao_seo),
            'subtitulo' => $trocar($pagina?->subtitulo ?: $termo->subtitulo),
            'introducao' => array_map($trocar, $introducao),
            'secoes' => array_map(fn ($s) => [
                'titulo' => $trocar($s['titulo'] ?? ''),
                'paragrafos' => array_map($trocar, $s['paragrafos'] ?? []),
            ], $secoes),
            'atendimento' => [
                'titulo' => $trocar($atendimento['titulo'] ?? ''),
                'paragrafos' => array_map($trocar, $atendimento['paragrafos'] ?? []),
            ],
            'canonical' => $this->url($canonicalTermo, $local->slug),
            // Sinônimo: sem noindex, o canonical já consolida no termo principal
            'robots' => ($termo->canonical || $indexar) ? 'index, follow' : 'noindex, follow',
            'indexavel' => ! $termo->canonical && $indexar,
            'homonimos' => $local->tipo === 'homonimo' ? $this->homonimos($local) : collect(),
            'vizinhas' => $this->vizinhas($local),
        ];
    }

    /** Página do termo sem localidade (/advocacia-tributaria): cidades em destaque */
    public function montarTermo(SeoTermo $termo): array
    {
        $destaques = SeoLocalidade::where('tipo', 'municipio')
            ->where(fn ($q) => $q->where('presencial', true)->orWhere('capital', true)->orWhere('indexar', true))
            ->orderBy('nome')->get();

        return [
            'termo' => $termo,
            'servico' => collect(config('servicos'))->firstWhere('slug', $termo->servico),
            'canonical' => $this->url($termo->canonical ?: $termo->slug),
            'robots' => ($termo->canonical || $termo->indexar) ? 'index, follow' : 'noindex, follow',
            'grupos' => [
                'Alto Tietê' => $destaques->where('presencial', true),
                'Grande São Paulo' => $destaques->where('presencial', false)->where('uf', 'SP')->where('indexar', true),
                'Capitais' => $destaques->where('capital', true)->where('uf', '!=', 'SP')->sortBy('nome'),
            ],
        ];
    }

    /** Troca os marcadores {local}, {local_uf}, {estado}... pelo dado da localidade */
    public function trocar(string $texto, SeoTermo $termo, SeoLocalidade $local): string
    {
        [$estado, $prep] = self::ESTADOS[$local->uf] ?? [null, null];

        return strtr($texto, [
            '{local}' => $local->nome,
            '{local_uf}' => $local->uf ? "{$local->nome} ({$local->uf})" : $local->nome,
            '{estado}' => $estado ?? 'do estado',
            '{do_estado}' => $estado ? "{$prep} {$estado}" : 'do estado',
            '{regiao}' => $local->microrregiao ?? $local->nome,
            '{termo}' => $termo->nome,
        ]);
    }

    /** Cidades com o mesmo nome em outros estados (página de homônimo) */
    private function homonimos(SeoLocalidade $local): Collection
    {
        return SeoLocalidade::where('slug_base', $local->slug_base)->where('tipo', 'municipio')->orderBy('uf')->get();
    }

    /** Links para cidades próximas: mesma microrregião; bairros sem cidade conhecida, o Alto Tietê */
    private function vizinhas(SeoLocalidade $local): Collection
    {
        $consulta = SeoLocalidade::where('tipo', 'municipio')->where('id', '!=', $local->id);

        if ($local->microrregiao && $local->uf) {
            $consulta->where('uf', $local->uf)->where('microrregiao', $local->microrregiao);
        } elseif ($local->tipo === 'homonimo') {
            return collect();
        } else {
            $consulta->where('presencial', true);
        }

        return $consulta->orderByDesc('indexar')->orderBy('nome')->limit(12)->get();
    }
}
