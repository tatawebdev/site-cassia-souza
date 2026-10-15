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

    public function test_limite_nao_pausa_e_a_proxima_execucao_tenta_de_novo(): void
    {
        $this->fake('limite', 0);

        $this->get('/sobre-nos');
        $this->assertStringContainsString('Limite diário', IndexedPage::first()->last_error);

        // Outra página e o comando tentam normalmente (sem pausa)
        $fake = $this->fake();
        $this->get('/contato');
        $this->assertSame(['https://cassiasouzaadvocacia.com.br/contato'], $fake->enviadas);
        $this->artisan('google:indexing-sync')->assertSuccessful();
        $this->assertSame(5 + count(config('servicos')), IndexedPage::whereNotNull('indexed_at')->count());
    }

    public function test_comando_para_no_limite_e_continua_de_onde_parou(): void
    {
        $fake = $this->fake('limite', 3);

        $this->artisan('google:indexing-sync')->expectsOutputToContain('Limite diário do Google atingido depois de 3 envios')->assertSuccessful();
        $this->assertSame(3, IndexedPage::whereNotNull('indexed_at')->count());

        // Próxima execução (cota renovada): envia só o que faltou
        $fake = $this->fake();
        $this->artisan('google:indexing-sync')->assertSuccessful();
        $this->assertCount(5 + count(config('servicos')) - 3, $fake->enviadas);
    }

    public function test_loop_libera_e_envia_ate_acabar_a_cota(): void
    {
        $this->artisan('seo:importar');
        $institucionais = 5 + count(config('servicos'));
        $indexaveis = app(\App\Services\Sitemap::class)->paginasSeo()->count();
        // Cota cobre o sitemap atual + 12 páginas novas
        $fake = $this->fake('limite', $institucionais + $indexaveis + 12);

        $this->artisan('google:indexing-sync --loop --lote=5')
            ->expectsOutputToContain('Limite diário do Google atingido')
            ->assertSuccessful();

        $this->assertCount($institucionais + $indexaveis + 12, $fake->enviadas);
        // 3 lotes de 5 liberados (o 3º só em parte coube na cota), começando pelo Alto Tietê
        $liberadas = \App\Models\SeoPagina::where('indexar', true)->with('localidade')->get();
        $this->assertCount(15, $liberadas);
        $this->assertTrue($liberadas->every(fn ($p) => $p->localidade->presencial));
    }

    public function test_limite_por_rodada_e_erro_comum(): void
    {
        $fake = $this->fake();
        $this->artisan('google:indexing-sync --limite=2')->assertSuccessful();
        $this->assertCount(2, $fake->enviadas);

        $this->fake('erro');
        $this->artisan('google:indexing-sync')->assertFailed();
        $this->assertSame('Permission denied', IndexedPage::whereNull('indexed_at')->first()->last_error);
    }
}
