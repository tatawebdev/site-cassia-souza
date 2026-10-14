<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PaginasDeErroTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Como em produção: sem a tela de debug
        config(['app.debug' => false]);

        Route::get('/_erro/{codigo}', fn (int $codigo) => abort($codigo));
        Route::get('/_erro-excecao', fn () => throw new \RuntimeException('falha simulada'));
    }

    public static function codigos(): array
    {
        return [
            [403, 'Acesso não permitido.'],
            [404, 'Esta página não existe ou mudou de lugar.'],
            [419, 'Sua sessão expirou.'],
            [429, 'Muitas tentativas seguidas.'],
            [500, 'Algo deu errado do nosso lado.'],
            [503, 'Site em manutenção.'],
        ];
    }

    #[DataProvider('codigos')]
    public function test_cada_erro_tem_pagina_no_tema_novo(int $codigo, string $titulo): void
    {
        $this->get("/_erro/{$codigo}")
            ->assertStatus($codigo)
            ->assertSee($titulo)
            ->assertSee('WhatsApp');
    }

    public function test_excecao_nao_tratada_mostra_a_pagina_500_sem_detalhes(): void
    {
        $this->get('/_erro-excecao')
            ->assertStatus(500)
            ->assertSee('Algo deu errado do nosso lado.')
            ->assertDontSee('falha simulada')
            ->assertDontSee('RuntimeException');
    }
}
