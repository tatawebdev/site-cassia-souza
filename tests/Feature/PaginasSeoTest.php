<?php

namespace Tests\Feature;

use App\Models\SeoLocalidade;
use App\Models\SeoPagina;
use App\Models\SeoTermo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginasSeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('seo:importar')->assertSuccessful();
    }

    public function test_importacao_cria_termos_e_localidades_sem_duplicar(): void
    {
        $this->assertSame(17, SeoTermo::count());
        $total = SeoLocalidade::count();
        $this->assertGreaterThan(6000, $total);

        $this->artisan('seo:importar')->assertSuccessful();
        $this->assertSame($total, SeoLocalidade::count());
    }

    public function test_reimportar_nao_apaga_texto_editado_no_banco(): void
    {
        SeoTermo::where('slug', 'advocacia-tributaria')->update(['h1' => 'Editado em {local}']);

        $this->artisan('seo:importar')->assertSuccessful();

        $this->assertSame('Editado em {local}', SeoTermo::where('slug', 'advocacia-tributaria')->value('h1'));
    }

    public function test_pagina_da_regiao_e_indexavel_com_atendimento_presencial(): void
    {
        $this->get('/advocacia-tributaria/suzano')
            ->assertOk()
            ->assertSee('Advocacia tributária em Suzano (SP)')
            ->assertSee('<meta name="robots" content="index, follow">', false)
            ->assertSee('<link rel="canonical" href="'.url('/advocacia-tributaria/suzano').'">', false)
            ->assertSee('Atendimento em Suzano e no Alto Tietê')
            ->assertSee('ICMS de São Paulo')
            ->assertSee('Mogi das Cruzes');
    }

    public function test_cidade_fora_da_regiao_fica_noindex_com_atendimento_online(): void
    {
        $this->get('/advocacia-tributaria/sete-lagoas')
            ->assertOk()
            ->assertSee('Sete Lagoas (MG)')
            ->assertSee('<meta name="robots" content="noindex, follow">', false)
            ->assertSee('Atendimento online para empresas de Sete Lagoas')
            ->assertSee('ICMS de Minas Gerais');
    }

    public function test_termo_sinonimo_aponta_para_o_principal(): void
    {
        $this->get('/escritorio-de-advocacia-tributaria/suzano')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.url('/escritorio-advocacia-tributaria/suzano').'">', false);
    }

    public function test_pagina_editada_substitui_o_modelo_e_decide_a_indexacao(): void
    {
        SeoPagina::create([
            'seo_termo_id' => SeoTermo::where('slug', 'advocacia-tributaria')->value('id'),
            'seo_localidade_id' => SeoLocalidade::where('slug', 'sete-lagoas')->value('id'),
            'h1' => 'Título próprio de {local}',
            'introducao' => ['Parágrafo escrito para {local_uf}.'],
            'indexar' => true,
        ]);

        $this->get('/advocacia-tributaria/sete-lagoas')
            ->assertOk()
            ->assertSee('Título próprio de Sete Lagoas')
            ->assertSee('Parágrafo escrito para Sete Lagoas (MG).')
            ->assertSee('<meta name="robots" content="index, follow">', false);
    }

    public function test_homonimo_lista_as_cidades_e_uf_no_endereco_leva_a_cidade_certa(): void
    {
        $this->get('/advocacia-tributaria/bom-jesus')
            ->assertOk()
            ->assertSee('Há mais de uma cidade chamada Bom Jesus')
            ->assertSee('/advocacia-tributaria/bom-jesus-pi');

        $this->get('/advocacia-tributaria/bom-jesus/pi')->assertRedirect('/advocacia-tributaria/bom-jesus-pi');
        $this->get('/advocacia-tributaria/suzano/sp')->assertRedirect('/advocacia-tributaria/suzano');
    }

    public function test_enderecos_antigos_redirecionam(): void
    {
        $this->get('/arapoti')->assertStatus(301)->assertRedirect('/advocacia-tributaria/arapoti');
        $this->get('/jardim-suzano')->assertStatus(301)->assertRedirect('/advocacia-tributaria/jardim-suzano');
        $this->get("/advocacia-tributaria/alta-floresta-d'oeste")->assertStatus(301)->assertRedirect('/advocacia-tributaria/alta-floresta-doeste');
    }

    public function test_bairro_e_distrito_abrem(): void
    {
        $this->get('/advocacia-tributaria/jardim-suzano')->assertOk()->assertSee('Jardim Suzano');
        $this->get('/advogada-tributarista/jundiapeba')->assertOk()->assertSee('Advogada tributarista em Jundiapeba (SP)');
    }

    public function test_pagina_do_termo_lista_cidades_em_destaque(): void
    {
        $this->get('/advocacia-tributaria')
            ->assertOk()
            ->assertSee('Alto Tietê')
            ->assertSee('/advocacia-tributaria/suzano');
    }

    public function test_enderecos_inexistentes_dao_404_e_rotas_do_site_continuam(): void
    {
        $this->get('/advocacia-tributaria/cidade-que-nao-existe')->assertNotFound();
        $this->get('/termo-inexistente/suzano')->assertNotFound();
        $this->get('/pagina-qualquer')->assertNotFound();
        $this->get('/contato')->assertOk();
        $this->get('/servicos/planejamento-tributario')->assertOk();
        $this->get('/up')->assertOk();
    }
}
