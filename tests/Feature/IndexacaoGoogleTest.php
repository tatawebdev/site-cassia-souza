<?php

namespace Tests\Feature;

use App\Models\IndexedPage;
use App\Services\GoogleIndexingService;
use App\Services\IndexacaoGoogle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use RuntimeException;
use Tests\TestCase;

class IndexacaoGoogleTest extends TestCase
{
    use RefreshDatabase;

    /** Serviço falso: 'ok', 'erro' ou 'limite' (cota esgotada depois de $cota envios) */
    private function fake(string $modo = 'ok', int $cota = PHP_INT_MAX): object
    {
        $fake = new class($modo, $cota) extends GoogleIndexingService {
            public array $enviadas = [];

            public function __construct(private string $modo, private int $cota) {}

            public function notifyUrlUpdate(string $url): bool
            {
                $this->ultimoErro = null;
                if ($this->modo === 'limite' && count($this->enviadas) >= $this->cota) {
                    $this->ultimoErro = new RuntimeException('Quota exceeded for quota metric', 429);

                    return false;
                }
                if ($this->modo === 'erro') {
                    $this->ultimoErro = new RuntimeException('Permission denied');

                    return false;
                }
                $this->enviadas[] = $url;

                return true;
            }
        };

        $this->app->instance(GoogleIndexingService::class, $fake);

        return $fake;
    }

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.google_indexing.enabled' => true, 'services.google_indexing.base_url' => 'https://cassiasouzaadvocacia.com.br']);
        Cache::flush();
        app(IndexacaoGoogle::class)->liberarPausa();
    }

    protected function tearDown(): void
    {
        app(IndexacaoGoogle::class)->liberarPausa();
        parent::tearDown();
    }

    public function test_abrir_a_pagina_envia_uma_vez_so(): void
    {
        $fake = $this->fake();

        $this->get('/sobre-nos')->assertOk();
        $this->get('/sobre-nos')->assertOk();

        $this->assertSame(['https://cassiasouzaadvocacia.com.br/sobre-nos'], $fake->enviadas);
        $this->assertNotNull(IndexedPage::firstWhere('url', 'https://cassiasouzaadvocacia.com.br/sobre-nos')->indexed_at);
    }

    public function test_paginas_noindex_sinonimo_e_com_parametros_nao_sao_enviadas(): void
    {
        $fake = $this->fake();
        $this->artisan('seo:importar');

        $this->get('/advocacia-tributaria/sete-lagoas')->assertOk();          // noindex
        $this->get('/escritorio-de-advocacia-tributaria/suzano')->assertOk(); // canonical aponta para outra
        $this->get('/sobre-nos?utm_source=teste')->assertOk();                // com parâmetros
        $this->get('/pagina-que-nao-existe');                                 // 404

        $this->assertSame([], $fake->enviadas);

        $this->get('/advocacia-tributaria/suzano')->assertOk();
        $this->assertSame(['https://cassiasouzaadvocacia.com.br/advocacia-tributaria/suzano'], $fake->enviadas);
    }

    public function test_limite_pausa_por_36_horas_no_site_e_no_comando(): void
    {
        $fake = $this->fake('limite', 0);

        $this->get('/sobre-nos');
        $this->assertNotNull($ate = app(IndexacaoGoogle::class)->pausadoAte());
        $this->assertTrue($ate->between(now()->addHours(35), now()->addHours(37)));
        $this->assertStringContainsString('Limite diário', IndexedPage::first()->last_error);

        // Durante a pausa nem o site nem o comando tentam
        $this->get('/contato');
        $this->artisan('google:indexing-sync')->expectsOutputToContain('Envios pausados até')->assertSuccessful();
        $this->assertSame(1, IndexedPage::count());
    }

    public function test_pausa_sobrevive_ao_cache_clear_do_deploy(): void
    {
        $this->fake('limite', 0);
        $this->get('/sobre-nos');

        $this->artisan('cache:clear');

        $this->assertNotNull(app(IndexacaoGoogle::class)->pausadoAte());
    }

    public function test_comando_para_no_limite_e_continua_de_onde_parou(): void
    {
        $fake = $this->fake('limite', 3);

        $this->artisan('google:indexing-sync')->expectsOutputToContain('Limite diário do Google atingido depois de 3 envios')->assertSuccessful();
        $this->assertSame(3, IndexedPage::whereNotNull('indexed_at')->count());

        // Dia seguinte (fim da pausa e cota renovada): envia só o que faltou
        $this->travel(37)->hours();
        $fake = $this->fake();
        $this->artisan('google:indexing-sync')->assertSuccessful();
        $this->assertCount(5 + count(config('servicos')) - 3, $fake->enviadas);
    }

    public function test_limite_por_rodada_e_erro_comum_nao_pausa(): void
    {
        $fake = $this->fake();
        $this->artisan('google:indexing-sync --limite=2')->assertSuccessful();
        $this->assertCount(2, $fake->enviadas);

        $this->fake('erro');
        $this->artisan('google:indexing-sync')->assertFailed();
        $this->assertNull(app(IndexacaoGoogle::class)->pausadoAte());
        $this->assertSame('Permission denied', IndexedPage::whereNull('indexed_at')->first()->last_error);
    }
}
