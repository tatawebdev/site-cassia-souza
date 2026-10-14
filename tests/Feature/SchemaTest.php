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

        $this->assertSame(['@type' => 'City', 'name' => 'Suzano'], $servico['areaServed']);
    }
}
