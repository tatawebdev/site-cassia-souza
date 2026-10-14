<?php

namespace Tests\Feature;

use App\Providers\AppServiceProvider;
use Tests\TestCase;

class DominioOficialTest extends TestCase
{
    public function test_em_producao_as_urls_usam_o_dominio_oficial(): void
    {
        $this->app['env'] = 'production';
        config(['app.url' => 'https://cassiasouzaadvocacia.com.br']);
        (new AppServiceProvider($this->app))->boot();

        $this->assertSame('https://cassiasouzaadvocacia.com.br/sobre-nos', url('/sobre-nos'));
        $this->assertSame('https://cassiasouzaadvocacia.com.br/sobre-nos', route('sobre'));
    }

    public function test_fora_de_producao_nada_muda(): void
    {
        (new AppServiceProvider($this->app))->boot();

        $this->assertStringStartsWith(config('app.url'), url('/sobre-nos'));
    }
}
