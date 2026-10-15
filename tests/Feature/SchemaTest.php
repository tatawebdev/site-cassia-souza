<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchemaTest extends TestCase
{
    use RefreshDatabase;

    /** Tipos (@type) do JSON-LD da página, que precisa ser um JSON válido */
    private function tipos(string $url): array
    {
        $html = $this->get($url)->assertOk()->getContent();
        $this->assertSame(1, preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m));
        $dados = json_decode($m[1], true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame('https://schema.org', $dados['@context']);

        return array_column($dados['@graph'], '@type');
    }

    public function test_todas_as_paginas_tem_escritorio_advogada_e_site(): void
    {
        foreach (['/', '/sobre-nos', '/servicos', '/contato', '/politica-de-privacidade'] as $url) {
            $tipos = $this->tipos($url);
            foreach (['LegalService', 'Person', 'WebSite'] as $tipo) {
                $this->assertContains($tipo, $tipos, "$tipo faltando em $url");
            }
        }
    }

    public function test_tipos_por_pagina(): void
    {
        $this->assertContains('AboutPage', $this->tipos('/sobre-nos'));
        $this->assertContains('ContactPage', $this->tipos('/contato'));
        $this->assertContains('FAQPage', $this->tipos('/contato'));

        $servico = $this->tipos('/servicos/planejamento-tributario');
        $this->assertContains('Service', $servico);
        $this->assertContains('BreadcrumbList', $servico);
        $this->assertContains('FAQPage', $servico);
    }

    public function test_pagina_de_cidade_tem_servico_na_cidade(): void
    {
        $this->artisan('seo:importar')->assertSuccessful();
        $html = $this->get('/advocacia-tributaria/suzano')->getContent();
        preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
        $servico = collect(json_decode($m[1], true)['@graph'])->firstWhere('@type', 'Service');

        // O serviço da própria página, na cidade dentro do estado
        $this->assertSame('City', $servico['areaServed']['@type']);
        $this->assertSame('Suzano', $servico['areaServed']['name']);
        $this->assertSame('São Paulo', $servico['areaServed']['containedInPlace']['name']);
        $this->assertStringEndsWith('/advocacia-tributaria/suzano#servico', $servico['@id']);
    }

    /** JSON-LD da página já decodificado */
    private function grafo(string $url): array
    {
        $html = $this->get($url)->assertOk()->getContent();
        $this->assertSame(1, preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m));
        $this->assertStringNotContainsString('AggregateRating', $m[1], $url);
        $this->assertStringNotContainsString('"Review"', $m[1], $url);
        $this->assertStringNotContainsString('HowTo', $m[1], $url);
        $this->assertStringNotContainsString('—', $m[1], $url);

        return json_decode($m[1], true, flags: JSON_THROW_ON_ERROR)['@graph'];
    }

    public function test_referencias_resolvem_e_sem_avaliacao_propria(): void
    {
        $this->artisan('seo:importar')->assertSuccessful();

        foreach (['/', '/sobre-nos', '/servicos', '/contato', '/servicos/planejamento-tributario', '/advocacia-tributaria', '/advocacia-tributaria/suzano'] as $url) {
            $definidos = [];
            $referencias = [];
            $andar = function ($valor) use (&$andar, &$definidos, &$referencias) {
                if (! is_array($valor)) {
                    return;
                }
                if (isset($valor['@id'])) {
                    if (count($valor) > 1) {
                        $definidos[] = $valor['@id'];
                    } else {
                        $referencias[] = $valor['@id'];
                    }
                }
                foreach ($valor as $item) {
                    $andar($item);
                }
            };

            $grafo = $this->grafo($url);
            foreach ($grafo as $no) {
                $this->assertArrayNotHasKey(0, $no, "array dentro do @graph em $url");
                $andar($no);
            }

            // Nós do primeiro nível não se repetem
            $ids = array_filter(array_column($grafo, '@id'));
            $this->assertSame(array_values(array_unique($ids)), array_values($ids), "@id repetido em $url");
            $this->assertSame([], array_values(array_diff(array_unique($referencias), $definidos)), "referência sem nó em $url");
        }
    }

    public function test_catalogo_e_lista_de_servicos(): void
    {
        $grafo = collect($this->grafo('/servicos'));
        $total = count(config('servicos'));

        $escritorio = $grafo->firstWhere('@type', 'LegalService');
        $this->assertCount($total, $escritorio['hasOfferCatalog']['itemListElement']);
        $this->assertArrayNotHasKey('founder', $escritorio);

        $lista = $grafo->firstWhere('@type', 'ItemList');
        $this->assertSame($total, $lista['numberOfItems']);
        $this->assertCount($total, $lista['itemListElement']);
        $this->assertSame('CollectionPage', $grafo->firstWhere('@id', route('servicos').'#pagina')['@type']);
    }

    public function test_pagina_de_servico_liga_servico_base_legal_e_faq(): void
    {
        $url = route('servicos.planejamento.tributario');
        $grafo = collect($this->grafo('/servicos/planejamento-tributario'));

        $pagina = $grafo->firstWhere('@id', $url.'#pagina');
        $this->assertSame('Planejamento Tributário', $pagina['name']);
        $this->assertSame(['@id' => $url.'#servico'], $pagina['mainEntity']);
        $this->assertSame(['@id' => $url.'#faq'], $pagina['hasPart']);
        $this->assertNotEmpty($pagina['citation']);

        $this->assertNotNull($grafo->firstWhere('@id', $url.'#servico'));
        $faq = $grafo->firstWhere('@id', $url.'#faq');
        $this->assertSame('FAQPage', $faq['@type']);
    }

    public function test_cassia_com_credencial_e_perfis_pessoais(): void
    {
        $grafo = collect($this->grafo('/sobre-nos'));

        $cassia = $grafo->firstWhere('@type', 'Person');
        $this->assertSame('Cassia Souza', $cassia['name']);
        $this->assertSame(route('sobre'), $cassia['url']);
        $this->assertSame('EducationalOccupationalCredential', $cassia['hasCredential']['@type']);
        $this->assertContains('https://blog.cassiasouzaadvocacia.com.br/autor/cassia-souza/', $cassia['sameAs']);

        // Perfis pessoais na Cassia; o escritório tem só os dele (Facebook) e o CNPJ
        $escritorio = $grafo->firstWhere('@type', 'LegalService');
        $this->assertSame([config('site.facebook'), config('site.google_kgmid')], $escritorio['sameAs']);
        $this->assertNotContains(config('site.facebook'), $cassia['sameAs']);
        $this->assertSame('57.078.276/0001-00', $escritorio['taxID']);
        $this->assertSame('Sobre a Cassia Souza Advocacia Tributária', $grafo->firstWhere('@type', 'AboutPage')['name']);
    }

    public function test_faq_da_home_e_fixa_e_igual_ao_json(): void
    {
        preg_match_all('#<summary.*?</summary>#s', $this->get('/')->getContent(), $primeira);
        preg_match_all('#<summary.*?</summary>#s', $this->get('/')->getContent(), $segunda);
        $this->assertSame($primeira[0], $segunda[0]);

        // Uma pergunta no JSON para cada pergunta visível
        $faq = collect($this->grafo('/'))->firstWhere('@type', 'FAQPage');
        $this->assertCount(count($primeira[0]), $faq['mainEntity']);
    }
}
