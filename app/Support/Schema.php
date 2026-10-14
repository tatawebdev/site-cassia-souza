<?php

namespace App\Support;

/**
 * Dados estruturados (JSON-LD, schema.org) do tema novo. O layout sempre publica o
 * escritório, a Cassia e o site; cada página soma os seus nós (breadcrumb, serviço,
 * perguntas frequentes) pela prop "schema" de <x-novo.layout> / <x-novo.pagina>.
 *
 * Só fatos confirmados: sem endereço de rua (não publicado no site) e sem nota de
 * avaliações (o Google ignora nota publicada pela própria empresa).
 */
class Schema
{
    public static function id(string $fragmento): string
    {
        return url('/').'#'.$fragmento;
    }

    /** Escritório, advogada e site: os mesmos em todas as páginas */
    public static function base(): array
    {
        $redes = array_column(config('site.social_icons'), 'url');
        $telefone = '+55 '.preg_replace('/\D+/', ' ', trim(config('site.whatsapp')));

        return [
            [
                '@type' => 'LegalService',
                '@id' => self::id('escritorio'),
                'name' => 'Cassia Souza Advocacia Tributária',
                'url' => url('/'),
                'logo' => url('/assets/images/logo-acinzentado.png'),
                'image' => url('/assets/img/sobrenos.png'),
                'description' => 'Escritório de advocacia tributária para empresas: planejamento tributário, recuperação de PIS/COFINS, regularização de débitos na PGFN, consultoria tributária e assessoria para a Reforma Tributária.',
                'telephone' => trim(preg_replace('/\s+/', ' ', $telefone)),
                'email' => 'cassia_souza@adv.oabsp.org.br',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Suzano',
                    'addressRegion' => 'SP',
                    'addressCountry' => 'BR',
                ],
                'areaServed' => ['@type' => 'Country', 'name' => 'Brasil'],
                'openingHoursSpecification' => [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    'opens' => '09:00',
                    'closes' => '17:00',
                ],
                'knowsAbout' => ['Direito tributário', 'Planejamento tributário', 'Reforma Tributária', 'PIS/COFINS', 'Dívida Ativa da União'],
                'founder' => ['@id' => self::id('cassia')],
                'sameAs' => $redes,
            ],
            [
                '@type' => 'Person',
                '@id' => self::id('cassia'),
                'name' => 'Cassia Souza',
                'jobTitle' => 'Advogada tributarista',
                'description' => 'Advogada tributarista inscrita na OAB/SP, em Suzano (SP).',
                'image' => url('/assets/img/sobrenos.png'),
                'worksFor' => ['@id' => self::id('escritorio')],
                'knowsAbout' => ['Direito tributário', 'Planejamento tributário', 'Reforma Tributária'],
                'sameAs' => $redes,
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

    /** Página atual, com o breadcrumb quando houver */
    public static function pagina(string $titulo, ?string $descricao, string $url, array $breadcrumbs = [], string $tipo = 'WebPage'): array
    {
        $nos = [[
            '@type' => $tipo,
            '@id' => $url.'#pagina',
            'url' => $url,
            'name' => $titulo,
            'description' => $descricao,
            'inLanguage' => 'pt-BR',
            'isPartOf' => ['@id' => self::id('site')],
            'about' => ['@id' => self::id('escritorio')],
        ]];

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

    /** Serviço de config/servicos.php; nas páginas de cidade, com a área atendida */
    public static function servico(array $servico, ?string $area = null): array
    {
        return array_filter([
            '@type' => 'Service',
            'name' => $servico['title'],
            'serviceType' => $servico['title'],
            'description' => $servico['descricao'],
            'url' => route($servico['route']),
            'provider' => ['@id' => self::id('escritorio')],
            'areaServed' => $area ? ['@type' => 'City', 'name' => $area] : ['@type' => 'Country', 'name' => 'Brasil'],
        ]);
    }

    /** Perguntas frequentes visíveis na página (config/faqs.php) */
    public static function faq(array $faqs): ?array
    {
        if (! $faqs) {
            return null;
        }

        return [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
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
