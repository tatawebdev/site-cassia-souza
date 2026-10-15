<?php

namespace Tests\Feature;

use App\Models\SeoLocalidade;
use App\Models\SeoPagina;
use App\Models\SeoTermo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoLiberarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('seo:importar')->assertSuccessful();
    }

    public function test_libera_primeiro_o_alto_tiete_e_entra_no_sitemap(): void
    {
        $this->artisan('seo:liberar --quantidade=5')->assertSuccessful();

        $liberadas = SeoPagina::where('indexar', true)->with('localidade', 'termo')->get();
        $this->assertCount(5, $liberadas);
        foreach ($liberadas as $p) {
            $this->assertTrue($p->localidade->presencial, $p->localidade->slug.' não é do Alto Tietê');
            $this->assertNull($p->termo->canonical);
        }

        $url = url('/'.$liberadas[0]->termo->slug.'/'.$liberadas[0]->localidade->slug);
        $this->get('/sitemap.xml')->assertSee('<loc>'.$url.'</loc>', false);
        $this->get(parse_url($url, PHP_URL_PATH))->assertSee('<meta name="robots" content="index', false);
    }

    public function test_simular_nao_grava_e_decisao_manual_e_respeitada(): void
    {
        $this->artisan('seo:liberar --quantidade=3 --simular')->assertSuccessful();
        $this->assertSame(0, SeoPagina::count());

        // Bloqueia à mão todas as combinações do Alto Tietê ainda fechadas
        $termos = SeoTermo::where('indexar', true)->whereNull('canonical')->get();
        foreach (SeoLocalidade::where('presencial', true)->where('indexar', false)->get() as $l) {
            foreach ($termos as $t) {
                SeoPagina::create(['seo_termo_id' => $t->id, 'seo_localidade_id' => $l->id, 'indexar' => false]);
            }
        }

        $this->artisan('seo:liberar --quantidade=4')->assertSuccessful();
        $liberadas = SeoPagina::where('indexar', true)->with('localidade')->get();
        $this->assertCount(4, $liberadas);
        $this->assertSame(['bairro'], $liberadas->pluck('localidade.tipo')->unique()->values()->all());
        $this->assertSame(0, SeoPagina::where('indexar', false)->whereNot('notas', null)->count());
    }

    public function test_nunca_libera_sinonimo_nem_homonimo(): void
    {
        $this->artisan('seo:liberar --quantidade=200')->assertSuccessful();

        $liberadas = SeoPagina::where('indexar', true)->with('localidade', 'termo')->get();
        $this->assertCount(200, $liberadas);
        $this->assertTrue($liberadas->every(fn ($p) => $p->termo->canonical === null && $p->localidade->tipo !== 'homonimo'));
    }
}
