<?php

namespace App\Support;

use App\Models\SeoLocalidade;
use App\Services\PaginaSeo;

/**
 * Dados estruturados (JSON-LD, schema.org) do tema novo. O layout sempre publica o
 * escritório, a Cassia e o site; cada página soma os seus nós (breadcrumb, serviço,
 * perguntas frequentes) pela prop "schema" de <x-novo.layout> / <x-novo.pagina> e
 * completa o nó da própria página pela prop "paginaSchema".
 *
 * Só fatos confirmados: sem endereço de rua (não publicado), sem número da OAB (não
 * informado) e sem nota de avaliações (o Google não aceita avaliação publicada pela
 * própria empresa sobre ela mesma). Os @id (#escritorio, #cassia) também são usados
 * pelo blog (tema cassia-souza): não mudar.
 */
class Schema
{
    public static function id(string $fragmento): string
    {
        return url('/').'#'.$fragmento;
    }

    /** "(11) 99738-8186" => "+55 11 99738-8186" */
    public static function telefone(): string
    {
        $d = preg_replace('/\D+/', '', config('site.whatsapp'));

        return '+55 '.substr($d, 0, 2).' '.substr($d, 2, -4).'-'.substr($d, -4);
    }

    private static function horario(): array
    {
        return [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'opens' => '09:00',
            'closes' => '17:00',
        ];
    }

    /** Serviço de config/servicos.php em forma curta (catálogo, listas, isRelatedTo) */
    private static function servicoRef(array $servico): array
    {
        $url = route($servico['route']);

        return ['@type' => 'Service', '@id' => $url.'#servico', 'name' => $servico['title'], 'url' => $url];
    }

    /** Escritório, advogada e site: os mesmos em todas as páginas */
    public static function base(): array
    {
        $temas = [
            'Direito tributário', 'Planejamento tributário', 'Simples Nacional', 'Lucro Presumido',
            'PIS/COFINS monofásico', 'Transação tributária', 'Dívida Ativa da União', 'Reforma Tributária',
            'Equiparação hospitalar',
        ];

        return [
            [
                '@type' => 'LegalService',
                '@id' => self::id('escritorio'),
                'name' => 'Cassia Souza Advocacia Tributária',
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    '@id' => self::id('logo'),
                    'url' => url('/assets/images/logo-roxo.png'),
                    'width' => 558,
                    'height' => 297,
                    'caption' => 'Cassia Souza Advocacia Tributária',
                ],
                'image' => ['@id' => self::id('foto-cassia')],
                'description' => 'Escritório de advocacia tributária para empresas, da advogada tributarista Cassia Souza (OAB/SP), em Suzano (SP): planejamento tributário, recuperação de PIS/COFINS monofásicos, regularização de débitos na PGFN, consultoria tributária e assessoria para a Reforma Tributária. Atendimento online em todo o Brasil e presencial em Suzano e no Alto Tietê.',
                'slogan' => 'Eu simplifico a tributação.',
                'telephone' => self::telefone(),
                'email' => 'cassia_souza@adv.oabsp.org.br',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Suzano',
                    'addressRegion' => 'SP',
                    'addressCountry' => 'BR',
                ],
                'areaServed' => ['@type' => 'Country', 'name' => 'Brasil'],
                'openingHoursSpecification' => self::horario(),
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'contactType' => 'customer service',
                    'telephone' => self::telefone(),
                    'email' => 'cassia_souza@adv.oabsp.org.br',
                    'availableLanguage' => 'pt-BR',
                    'areaServed' => 'BR',
                    'hoursAvailable' => self::horario(),
                ],
                'knowsAbout' => $temas,
                // "employee" e não "founder": a fundação não foi confirmada
                'employee' => ['@id' => self::id('cassia')],
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog',
                    '@id' => self::id('servicos'),
                    'name' => 'Serviços de advocacia tributária',
                    'url' => route('servicos'),
                    'itemListElement' => array_map(
                        fn ($s) => ['@type' => 'Offer', 'itemOffered' => self::servicoRef($s)],
                        config('servicos')
                    ),
                ],
                // sameAs do escritório: só perfis do escritório (o do Google, quando o usuário informar).
                // Instagram, TikTok e LinkedIn são da Cassia e ficam na Person.
            ],
            [
                '@type' => 'Person',
                '@id' => self::id('cassia'),
                'name' => 'Cassia Souza',
                'jobTitle' => 'Advogada tributarista',
                'description' => 'Advogada tributarista inscrita na OAB/SP, responsável pela Cassia Souza Advocacia Tributária, em Suzano (SP).',
                'url' => route('sobre'),
                'image' => [
                    '@type' => 'ImageObject',
                    '@id' => self::id('foto-cassia'),
                    'url' => url('/assets/img/cassia-1080.webp'),
                    'width' => 1080,
                    'height' => 1080,
                    'caption' => 'Cassia Souza, advogada tributarista',
                ],
                'email' => 'cassia_souza@adv.oabsp.org.br',
                'worksFor' => ['@id' => self::id('escritorio')],
                'knowsAbout' => $temas,
                'hasCredential' => [
                    '@type' => 'EducationalOccupationalCredential',
                    'credentialCategory' => 'Inscrição profissional',
                    'name' => 'Inscrição na Ordem dos Advogados do Brasil, Seção de São Paulo (OAB/SP)',
                    'recognizedBy' => [
                        '@type' => 'Organization',
                        'name' => 'Ordem dos Advogados do Brasil, Seção de São Paulo',
                        'alternateName' => 'OAB SP',
                        'url' => 'https://www.oabsp.org.br',
                    ],
                    // Quando o usuário informar o número: 'identifier' => ['@type' => 'PropertyValue', 'propertyID' => 'OAB/SP', 'value' => '...'],
                ],
                'sameAs' => array_merge(
                    array_column(config('site.social_icons'), 'url'),
                    ['https://blog.cassiasouzaadvocacia.com.br/autor/cassia-souza/']
                ),
            ],
            [
                '@type' => 'WebSite',
                '@id' => self::id('site'),
                'name' => 'Cassia Souza Advocacia Tributária',
                'url' => url('/'),
                'inLanguage' => 'pt-BR',
                'publisher' => ['@id' => self::id('escritorio')],
            ],
        ];
    }

    /**
     * Página atual, com o breadcrumb quando houver. $extra completa o nó da página
     * (name = H1, about, mainEntity, hasPart, lastReviewed, citation...).
     */
    public static function pagina(string $titulo, ?string $descricao, string $url, array $breadcrumbs = [], string $tipo = 'WebPage', array $extra = []): array
    {
        $nos = [array_filter(array_merge([
            '@type' => $tipo,
            '@id' => $url.'#pagina',
            'url' => $url,
            'name' => $titulo,
            'description' => $descricao,
            'inLanguage' => 'pt-BR',
            'isPartOf' => ['@id' => self::id('site')],
            'about' => ['@id' => self::id('escritorio')],
        ], $extra))];

        if ($breadcrumbs) {
            $nos[0]['breadcrumb'] = ['@id' => $url.'#breadcrumb'];
            $nos[] = [
                '@type' => 'BreadcrumbList',
                '@id' => $url.'#breadcrumb',
                'itemListElement' => array_map(fn ($item, $i) => array_filter([
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'name' => $item['label'],
                    // O último item é a página atual
                    'item' => $item['url'] ?? $url,
                ]), $breadcrumbs, array_keys($breadcrumbs)),
            ];
        }

        return $nos;
    }

    /** Serviço de config/servicos.php (página /servicos/<slug>) */
    public static function servico(array $servico): array
    {
        $url = route($servico['route']);

        return [
            '@type' => 'Service',
            '@id' => $url.'#servico',
            'name' => $servico['title'],
            'serviceType' => $servico['title'],
            'description' => $servico['descricao'],
            'url' => $url,
            'image' => url('/assets/servicos/detalhes/'.$servico['image'].'/imagem1.jpg'),
            'provider' => ['@id' => self::id('escritorio')],
            'areaServed' => ['@type' => 'Country', 'name' => 'Brasil'],
            'audience' => ['@type' => 'BusinessAudience', 'audienceType' => $servico['publico'] ?? 'Empresas'],
        ];
    }

    /** Extras do nó da página de serviço: assunto, data de revisão, base legal e FAQ */
    public static function paginaServico(array $servico, bool $temFaq): array
    {
        $url = route($servico['route']);

        return array_filter([
            'about' => ['@id' => $url.'#servico'],
            'mainEntity' => ['@id' => $url.'#servico'],
            'lastReviewed' => $servico['atualizado'] ?? null,
            'citation' => array_map(
                fn ($f) => ['@type' => 'Legislation', 'name' => $f['nome'], 'url' => $f['url']],
                $servico['fontes'] ?? []
            ) ?: null,
            'hasPart' => $temFaq ? ['@id' => $url.'#faq'] : null,
        ]);
    }

    /** Página de termo ou de cidade: o serviço da própria página, ligado ao serviço do site */
    public static function servicoLocal(string $nome, string $tipoServico, ?string $descricao, string $url, ?array $servico, ?array $area): array
    {
        return array_filter([
            '@type' => 'Service',
            '@id' => $url.'#servico',
            'name' => $nome,
            'serviceType' => $tipoServico,
            'description' => $descricao,
            'url' => $url,
            'provider' => ['@id' => self::id('escritorio')],
            'areaServed' => $area ?? ['@type' => 'Country', 'name' => 'Brasil'],
            'audience' => ['@type' => 'BusinessAudience', 'audienceType' => 'Empresas'],
            'isRelatedTo' => $servico ? self::servicoRef($servico) : null,
        ]);
    }

    /** Área atendida de uma localidade (cidade, distrito ou bairro, dentro do estado e do país) */
    public static function area(SeoLocalidade $local): ?array
    {
        $estado = isset(PaginaSeo::ESTADOS[$local->uf]) ? [
            '@type' => 'State',
            'name' => PaginaSeo::ESTADOS[$local->uf][0],
            'containedInPlace' => ['@type' => 'Country', 'name' => 'Brasil'],
        ] : null;

        return match ($local->tipo) {
            'municipio' => array_filter(['@type' => 'City', 'name' => $local->nome, 'containedInPlace' => $estado]),
            'distrito', 'bairro' => array_filter([
                '@type' => 'Place',
                'name' => $local->nome,
                'containedInPlace' => $local->municipio
                    ? array_filter(['@type' => 'City', 'name' => $local->municipio, 'containedInPlace' => $estado])
                    : $estado,
            ]),
            default => null, // homônimo: a página ainda não sabe qual cidade é
        };
    }

    /** Lista dos serviços (página /servicos) */
    public static function listaServicos(): array
    {
        $servicos = array_values(config('servicos'));

        return [
            '@type' => 'ItemList',
            '@id' => route('servicos').'#lista',
            'name' => 'Serviços da Cassia Souza Advocacia Tributária',
            'numberOfItems' => count($servicos),
            'itemListElement' => array_map(fn ($s, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $s['title'],
                'url' => route($s['route']),
            ], $servicos, array_keys($servicos)),
        ];
    }

    /** Perguntas frequentes visíveis na página (config/faqs.php); $url é o canonical da página */
    public static function faq(array $faqs, string $url): ?array
    {
        if (! $faqs) {
            return null;
        }

        return [
            '@type' => 'FAQPage',
            '@id' => $url.'#faq',
            'url' => $url,
            'isPartOf' => ['@id' => self::id('site')],
            'mainEntity' => array_map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'],
                // O mesmo texto da página (o FAQ colapsa os espaços)
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => preg_replace('/\s+/u', ' ', $faq['answer'])],
            ], $faqs),
        ];
    }

    /** JSON-LD pronto para o <script>; JSON_HEX_TAG impede fechar a tag por dentro do texto */
    public static function json(array $nos): string
    {
        return json_encode(
            ['@context' => 'https://schema.org', '@graph' => array_values(array_filter($nos))],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG
        );
    }
}
