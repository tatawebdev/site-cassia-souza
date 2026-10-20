<?php

namespace Tests\Feature;

use App\Mail\ArtigoNovoMail;
use App\Models\FcmAviso;
use App\Models\FcmToken;
use App\Models\NewsletterSubscriber;
use App\Services\AvisoArtigo;
use App\Models\User;
use App\Services\FcmService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FcmTest extends TestCase
{
    use RefreshDatabase;

    private string $credenciais;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
        Mail::fake();

        // Conta de serviço falsa e token de acesso já em cache: o teste não assina JWT
        $this->credenciais = tempnam(sys_get_temp_dir(), 'fcm');
        file_put_contents($this->credenciais, json_encode(['project_id' => 'teste']));
        config(['services.fcm' => ['credentials_path' => $this->credenciais, 'chave_avisos' => 'chave-teste']]);
        Cache::put('fcm_access_token_'.md5($this->credenciais), ['access_token' => 'acesso', 'expires_at' => time() + 3600]);
    }

    protected function tearDown(): void
    {
        @unlink($this->credenciais);

        parent::tearDown();
    }

    public function test_visitante_se_inscreve_como_site(): void
    {
        Http::fake(['fcm.googleapis.com/*' => Http::response(['name' => 'ok'])]);

        $this->postJson('/api/fcm/token', ['token' => 'tok-visitante'])->assertOk();

        $this->assertDatabaseHas('fcm_tokens', ['token' => 'tok-visitante', 'publico' => 'site']);
        Http::assertSent(fn ($r) => $r['validate_only'] === true);
    }

    public function test_token_morto_nao_e_gravado_e_pede_outro(): void
    {
        Http::fake(['fcm.googleapis.com/*' => Http::response(['error' => ['status' => 'NOT_FOUND']], 404)]);

        $this->postJson('/api/fcm/token', ['token' => 'tok-antigo'])
            ->assertStatus(410)
            ->assertJson(['status' => 'token_invalido']);

        $this->assertDatabaseMissing('fcm_tokens', ['token' => 'tok-antigo']);
    }

    public function test_sem_conferir_com_o_google_grava_mesmo_assim(): void
    {
        Http::fake(['fcm.googleapis.com/*' => Http::response('erro', 500)]);

        $this->postJson('/api/fcm/token', ['token' => 'tok-visitante'])->assertOk();

        $this->assertDatabaseHas('fcm_tokens', ['token' => 'tok-visitante']);
    }

    public function test_inscricao_do_painel_exige_login(): void
    {
        Http::fake(['fcm.googleapis.com/*' => Http::response(['name' => 'ok'])]);

        $this->postJson('/painel/fcm/token', ['token' => 'tok-intruso'])->assertUnauthorized();
        $this->assertDatabaseMissing('fcm_tokens', ['token' => 'tok-intruso']);

        $this->actingAs(User::factory()->create())
            ->postJson('/painel/fcm/token', ['token' => 'tok-cassia'])
            ->assertOk();
        $this->assertDatabaseHas('fcm_tokens', ['token' => 'tok-cassia', 'publico' => 'painel']);
    }

    public function test_envio_vai_so_para_o_publico_certo_e_apaga_token_morto(): void
    {
        FcmToken::create(['token' => 'tok-painel', 'publico' => 'painel']);
        FcmToken::create(['token' => 'tok-vivo', 'publico' => 'site']);
        FcmToken::create(['token' => 'tok-morto', 'publico' => 'site']);

        Http::fake(function ($request) {
            $token = $request['message']['token'];

            return $token === 'tok-morto'
                ? Http::response(['error' => ['status' => 'NOT_FOUND', 'details' => [['errorCode' => 'UNREGISTERED']]]], 404)
                : Http::response(['name' => 'ok']);
        });

        $resultado = app(FcmService::class)->enviarPara('site', 'Título', 'Texto', [], 'https://blog.cassiasouzaadvocacia.com.br/post/');

        $this->assertSame(['enviados' => 1, 'falhas' => 1], $resultado);
        Http::assertNotSent(fn ($r) => $r['message']['token'] === 'tok-painel');
        Http::assertSent(fn ($r) => $r['message']['data']['aviso_link'] === 'https://blog.cassiasouzaadvocacia.com.br/post/');
        $this->assertDatabaseMissing('fcm_tokens', ['token' => 'tok-morto']);
        $this->assertDatabaseHas('fcm_tokens', ['token' => 'tok-painel']);
    }

    public function test_aviso_do_blog_exige_a_chave(): void
    {
        $this->postJson('/api/fcm/avisos', ['titulo' => 'Post', 'url' => 'https://blog.cassiasouzaadvocacia.com.br/post/'])
            ->assertForbidden();

        $this->postJson('/api/fcm/avisos', ['titulo' => 'Post', 'url' => 'https://blog.cassiasouzaadvocacia.com.br/post/'], ['X-Chave-Avisos' => 'errada'])
            ->assertForbidden();
    }

    public function test_aviso_do_blog_envia_uma_vez_por_post(): void
    {
        FcmToken::create(['token' => 'tok-vivo', 'publico' => 'site']);
        Http::fake(['fcm.googleapis.com/*' => Http::response(['name' => 'ok'])]);
        $dados = ['titulo' => 'Minha empresa tem créditos tributários?', 'url' => 'https://blog.cassiasouzaadvocacia.com.br/creditos/'];

        $this->postJson('/api/fcm/avisos', $dados, ['X-Chave-Avisos' => 'chave-teste'])
            ->assertOk()
            ->assertJson(['status' => 'enviando']);
        Http::assertSentCount(1);
        $this->assertDatabaseHas('fcm_avisos', ['url' => $dados['url'], 'enviados' => 1, 'falhas' => 0]);

        // (Nos testes o app é o mesmo entre requisições e reexecuta o afterResponse
        // anterior; em produção cada requisição é um processo novo. Por isso a
        // contagem fica acima e aqui só se confere a resposta.)
        $this->postJson('/api/fcm/avisos', $dados, ['X-Chave-Avisos' => 'chave-teste'])
            ->assertJson(['status' => 'ja_avisado']);
        $this->assertSame(1, FcmAviso::count());
    }

    public function test_aviso_so_aceita_posts_do_blog(): void
    {
        $this->postJson('/api/fcm/avisos', ['titulo' => 'Golpe', 'url' => 'https://outro-site.com/'], ['X-Chave-Avisos' => 'chave-teste'])
            ->assertUnprocessable();

        $this->assertSame(0, FcmAviso::count());
    }

    public function test_comando_avisa_o_ultimo_post_do_feed(): void
    {
        FcmToken::create(['token' => 'tok-vivo', 'publico' => 'site']);
        Http::fake([
            'blog.cassiasouzaadvocacia.com.br/feed/' => Http::response('<?xml version="1.0"?><rss><channel>'
                .'<item><title>Minha empresa tem cr&#233;ditos tribut&#225;rios?</title><link>https://blog.cassiasouzaadvocacia.com.br/creditos/</link></item>'
                .'<item><title>Antigo</title><link>https://blog.cassiasouzaadvocacia.com.br/antigo/</link></item>'
                .'</channel></rss>'),
            'fcm.googleapis.com/*' => Http::response(['name' => 'ok']),
        ]);

        $this->artisan('fcm:avisar-artigo')->assertSuccessful()->expectsOutputToContain('1 enviados');
        Http::assertSent(fn ($r) => str_contains($r->url(), 'fcm.googleapis.com')
            && $r['message']['data']['aviso_titulo'] === 'Minha empresa tem créditos tributários?');

        // Repetir sem --forcar não manda de novo
        $this->artisan('fcm:avisar-artigo')->expectsOutputToContain('já foi avisado');
        $this->assertSame(1, FcmAviso::count());
    }

    public function test_aviso_do_blog_manda_email_para_a_newsletter(): void
    {
        NewsletterSubscriber::create(['email' => 'leitor@example.com']);
        NewsletterSubscriber::create(['email' => 'outra@example.com']);
        $dados = [
            'titulo' => 'Minha empresa tem créditos tributários?',
            'url' => 'https://blog.cassiasouzaadvocacia.com.br/creditos/',
            'resumo' => 'Sua empresa paga os impostos todos os meses.',
            'imagem' => 'https://blog.cassiasouzaadvocacia.com.br/capa.jpg',
            'categoria' => 'Créditos Tributários',
        ];

        $this->postJson('/api/fcm/avisos', $dados, ['X-Chave-Avisos' => 'chave-teste'])->assertOk();

        Mail::assertSent(ArtigoNovoMail::class, 2);
        Mail::assertSent(ArtigoNovoMail::class, function (ArtigoNovoMail $mail) {
            $html = $mail->render();

            return $mail->hasTo('leitor@example.com')
                && $mail->hasSubject('Minha empresa tem créditos tributários?')
                && str_contains($html, 'Sua empresa paga os impostos todos os meses.')
                && str_contains($html, 'Créditos Tributários')
                && str_contains($html, 'https://blog.cassiasouzaadvocacia.com.br/capa.jpg')
                && str_contains($html, e($mail->linkCancelar));
        });
        $this->assertDatabaseHas('fcm_avisos', ['url' => $dados['url'], 'emails_enviados' => 2, 'emails_falhas' => 0]);
    }

    public function test_link_do_email_cancela_a_inscricao(): void
    {
        $inscrito = NewsletterSubscriber::create(['email' => 'leitor@example.com']);

        // Sem a assinatura do e-mail, ninguém descadastra outra pessoa
        $this->get('/newsletter/cancelar/'.$inscrito->id)->assertForbidden();
        $this->assertDatabaseHas('newsletter_subscribers', ['email' => 'leitor@example.com']);

        $this->get(AvisoArtigo::linkCancelar($inscrito))->assertOk()->assertSee('Inscrição cancelada');
        $this->assertDatabaseMissing('newsletter_subscribers', ['email' => 'leitor@example.com']);

        // Clicar de novo no mesmo link não dá erro
        $this->get(AvisoArtigo::linkCancelar($inscrito))->assertOk();
    }

    public function test_comando_testa_o_email_sem_avisar_ninguem(): void
    {
        FcmToken::create(['token' => 'tok-vivo', 'publico' => 'site']);
        NewsletterSubscriber::create(['email' => 'leitor@example.com']);
        Http::fake(['blog.cassiasouzaadvocacia.com.br/feed/' => Http::response('<?xml version="1.0"?><rss><channel>'
            .'<item><title>Post</title><link>https://blog.cassiasouzaadvocacia.com.br/post/</link><description>Resumo do post [&#8230;]</description></item>'
            .'</channel></rss>')]);

        $this->artisan('fcm:avisar-artigo', ['--para' => 'eu@example.com'])->assertSuccessful();

        Mail::assertSent(ArtigoNovoMail::class, 1);
        Mail::assertSent(ArtigoNovoMail::class, fn ($mail) => $mail->hasTo('eu@example.com') && $mail->aviso->resumo === 'Resumo do post…');
        Http::assertNotSent(fn ($r) => str_contains($r->url(), 'fcm.googleapis.com'));
        $this->assertSame(0, FcmAviso::count());
    }
}
