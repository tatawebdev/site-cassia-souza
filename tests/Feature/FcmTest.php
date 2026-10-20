<?php

namespace Tests\Feature;

use App\Models\FcmAviso;
use App\Models\FcmToken;
use App\Models\User;
use App\Services\FcmService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FcmTest extends TestCase
{
    use RefreshDatabase;

    private string $credenciais;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();

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
        $this->postJson('/api/fcm/token', ['token' => 'tok-visitante'])->assertOk();

        $this->assertDatabaseHas('fcm_tokens', ['token' => 'tok-visitante', 'publico' => 'site']);
    }

    public function test_inscricao_do_painel_exige_login(): void
    {
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
        Http::assertSent(fn ($r) => $r['message']['webpush']['fcm_options']['link'] === 'https://blog.cassiasouzaadvocacia.com.br/post/');
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
            && $r['message']['notification']['title'] === 'Minha empresa tem créditos tributários?');

        // Repetir sem --forcar não manda de novo
        $this->artisan('fcm:avisar-artigo')->expectsOutputToContain('já foi avisado');
        $this->assertSame(1, FcmAviso::count());
    }
}
