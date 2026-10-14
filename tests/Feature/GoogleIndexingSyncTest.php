<?php

namespace Tests\Feature;

use App\Models\IndexedPage;
use App\Services\GoogleIndexingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleIndexingSyncTest extends TestCase
{
    use RefreshDatabase;

    /** Serviço falso: registra as URLs em vez de chamar o Google. */
    private function fake(bool $sucesso = true): object
    {
        $fake = new class($sucesso) extends GoogleIndexingService {
            public array $enviadas = [];

            public function __construct(private bool $sucesso) {}

            public function notifyUrlUpdate(string $url): bool
            {
                $this->enviadas[] = $url;

                return $this->sucesso;
            }
        };

        $this->app->instance(GoogleIndexingService::class, $fake);

        return $fake;
    }

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.google_indexing.enabled' => true, 'services.google_indexing.base_url' => 'https://cassiasouzaadvocacia.com.br']);
    }

    public function test_envia_paginas_fixas_e_servicos_com_url_de_producao(): void
    {
        $fake = $this->fake();

        $this->artisan('google:indexing-sync')->assertSuccessful();

        $this->assertCount(5 + count(config('servicos')), $fake->enviadas);
        $this->assertContains('https://cassiasouzaadvocacia.com.br/sobre-nos', $fake->enviadas);
        $this->assertContains('https://cassiasouzaadvocacia.com.br/servicos/consultoria-tributaria', $fake->enviadas);
        $this->assertSame(count($fake->enviadas), IndexedPage::whereNotNull('indexed_at')->count());
    }

    public function test_pula_as_ja_indexadas_e_force_reenvia(): void
    {
        $fake = $this->fake();
        $this->artisan('google:indexing-sync');
        $fake->enviadas = [];

        $this->artisan('google:indexing-sync')->assertSuccessful();
        $this->assertSame([], $fake->enviadas);

        $this->artisan('google:indexing-sync --force')->assertSuccessful();
        $this->assertNotEmpty($fake->enviadas);
    }

    public function test_falha_registra_erro_e_tenta_de_novo_depois(): void
    {
        $this->fake(false);

        $this->artisan('google:indexing-sync')->assertFailed();
        $this->assertSame(0, IndexedPage::whereNotNull('indexed_at')->count());
        $this->assertNotNull(IndexedPage::first()->last_error);
    }

    public function test_desativado_nao_envia_nada(): void
    {
        config(['services.google_indexing.enabled' => false]);
        $fake = $this->fake();

        $this->artisan('google:indexing-sync')->assertSuccessful();
        $this->assertSame([], $fake->enviadas);
    }
}
