<?php

namespace Tests\Feature;

use App\Services\GoogleReviewsImporter;
use Tests\TestCase;

class AvaliacoesTest extends TestCase
{
    public function test_parse_extrai_autor_nota_texto_completo_data_e_resposta(): void
    {
        $reviews = app(GoogleReviewsImporter::class)->parse(file_get_contents(base_path('tests/fixtures/google-avaliacoes.html')));

        $this->assertCount(3, $reviews);

        [$manoel, $thaine] = $reviews;

        $this->assertSame('Manoel Luiz', $manoel['author']);
        $this->assertSame(5, $manoel['rating']);
        // Usa a versão completa, não a resumida com "Exibir avaliação completa"
        $this->assertStringContainsString('Super indico a quem procura', $manoel['text']);
        $this->assertStringNotContainsString('Exibir avaliação completa', $manoel['text']);
        $this->assertNull($manoel['reply']);
        $this->assertStringStartsWith('https://lh3.googleusercontent.com/', $manoel['photo_url']);
        $this->assertSame(now()->subWeeks(11)->toDateString(), $manoel['date']);

        // <br> vira quebra de linha; indentação do código-fonte não
        $this->assertStringStartsWith("A Dra. Cássia é uma excelente profissional e uma grande especialista na área tributária.\n\nEla me ajudou", $thaine['text']);
        $this->assertSame('Muito obrigada por seu feedback, Thaine! Conte sempre conosco!!!', $thaine['reply']);
    }

    public function test_html_sem_avaliacoes_e_rejeitado(): void
    {
        $this->expectExceptionMessage('Nenhuma avaliação encontrada');

        app(GoogleReviewsImporter::class)->parse('<html><body><p>outra página</p></body></html>');
    }

    public function test_home_mostra_as_avaliacoes_do_array(): void
    {
        $review = fn (string $author, int $rating, string $text) => [
            'id' => $author, 'rating' => $rating, 'text' => $text, 'author' => $author,
            'date' => now()->subWeeks(3)->toDateString(), 'reply' => null, 'photo' => null,
        ];

        config(['avaliacoes' => [
            'rating' => 5.0,
            'reviews' => [
                $review('Maria', 5, 'Recomendo muito a Dra. Cássia'),
                $review('Sem texto', 5, ''),
                $review('Ana', 4, 'Ótimo atendimento'),
            ],
        ]]);

        $this->get('/')
            ->assertOk()
            ->assertSee('O que dizem os clientes atendidos')
            ->assertSee('3 avaliações no Google')
            ->assertSee('Recomendo muito a Dra. Cássia')
            ->assertSee('Ótimo atendimento')
            ->assertSee('há 3 semanas')
            ->assertSee('Próxima avaliação')
            ->assertDontSee('Resposta da Cássia');
    }

    public function test_importacao_guarda_so_4_estrelas_ou_mais_sem_respostas_e_com_fotos_locais(): void
    {
        \Illuminate\Support\Facades\Http::fake([
            'lh3.googleusercontent.com/*' => \Illuminate\Support\Facades\Http::response('PNG', 200, ['Content-Type' => 'image/png']),
        ]);
        // Não sobrescreve os arquivos reais do projeto
        $this->app->usePublicPath(sys_get_temp_dir().'/avaliacoes-public-'.uniqid());
        $config = config_path('avaliacoes.php');
        $original = file_get_contents($config);

        $html = file_get_contents(base_path('tests/fixtures/google-avaliacoes.html'));
        // Rebaixa a 1ª avaliação para 3 estrelas
        $html = preg_replace('/aria-label="5 de 5 estrelas"/', 'aria-label="3 de 5 estrelas"', $html, 1);

        try {
            $data = app(GoogleReviewsImporter::class)->import($html);
        } finally {
            file_put_contents($config, $original);
        }

        $this->assertCount(2, $data['reviews']);
        $this->assertNotContains('Manoel Luiz', array_column($data['reviews'], 'author'));
        $this->assertArrayNotHasKey('reply', $data['reviews'][0]);
        $this->assertStringStartsWith('assets/avaliacoes/', $data['reviews'][0]['photo']);
        $this->assertFileExists(public_path($data['reviews'][0]['photo']));
    }

    public function test_sem_avaliacoes_a_secao_nao_aparece(): void
    {
        config(['avaliacoes' => ['rating' => null, 'reviews' => []]]);

        $this->get('/')->assertOk()->assertDontSee('O que dizem os clientes atendidos');
    }
}
