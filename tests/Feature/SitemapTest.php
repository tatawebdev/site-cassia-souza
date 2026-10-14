<?php

namespace Tests\Feature;

use App\Models\SeoLocalidade;
use App\Models\SeoPagina;
use App\Models\SeoTermo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_lista_institucionais_e_so_paginas_de_seo_indexaveis(): void
    {
        $this->artisan('seo:importar')->assertSuccessful();

        $resposta = $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>'.route('contato').'</loc>', false)
            ->assertSee('<loc>'.url('/advocacia-tributaria/suzano').'</loc>', false)
            ->assertSee('<loc>'.url('/advocacia-tributaria').'</loc>', false)
            // Fora: cidade não liberada, termo sinônimo e homônimo
            ->assertDontSee(url('/advocacia-tributaria/sete-lagoas').'<', false)
            ->assertDontSee(url('/escritorio-de-advocacia-tributaria/suzano').'<', false)
            ->assertDontSee(url('/advocacia-tributaria/bom-jesus').'<', false);

        // 12 institucionais + 5 termos principais × (1 página do termo + 65 localidades)
        $this->assertSame(12 + 5 * 66, substr_count($resposta->getContent(), '<loc>'));
    }

    public function test_decisao_por_pagina_inclui_ou_tira_do_sitemap(): void
    {
        $this->artisan('seo:importar')->assertSuccessful();
        $termo = SeoTermo::where('slug', 'advocacia-tributaria')->value('id');

        SeoPagina::create(['seo_termo_id' => $termo, 'seo_localidade_id' => SeoLocalidade::where('slug', 'sete-lagoas')->value('id'), 'indexar' => true]);
        SeoPagina::create(['seo_termo_id' => $termo, 'seo_localidade_id' => SeoLocalidade::where('slug', 'suzano')->value('id'), 'indexar' => false]);

        $this->get('/sitemap.xml')
            ->assertSee(url('/advocacia-tributaria/sete-lagoas').'<', false)
            ->assertDontSee(url('/advocacia-tributaria/suzano').'<', false);
    }
}
