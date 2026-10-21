<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NewsletterApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Http::preventStrayRequests();
        config(['services.recaptcha' => ['site_key' => 'site-teste', 'secret_key' => 'secreta-teste']]);
    }

    public function test_inscreve_pelo_blog_com_recaptcha_valido(): void
    {
        Http::fake(['www.google.com/recaptcha/*' => Http::response(['success' => true])]);

        $this->postJson('/api/newsletter', ['email' => 'leitor@example.com', 'recaptcha' => 'ok'])
            ->assertOk()
            ->assertJson(['status' => 'inscrito']);

        $this->assertDatabaseHas('newsletter_subscribers', ['email' => 'leitor@example.com', 'source' => 'blog']);
    }

    public function test_checagem_de_inscrito_sem_recaptcha_com_limite(): void
    {
        NewsletterSubscriber::create(['email' => 'leitor@example.com']);

        $this->postJson('/api/newsletter/inscrito', ['email' => 'leitor@example.com'])->assertOk()->assertJson(['inscrito' => true]);
        $this->postJson('/api/newsletter/inscrito', ['email' => 'novo@example.com'])->assertOk()->assertJson(['inscrito' => false]);

        for ($i = 0; $i < 8; $i++) {
            $this->postJson('/api/newsletter/inscrito', ['email' => 'x'.$i.'@example.com']);
        }
        $this->postJson('/api/newsletter/inscrito', ['email' => 'leitor@example.com'])->assertStatus(429);
        Http::assertNothingSent();
    }

    public function test_blog_pode_gravar_inscricao_de_notificacao(): void
    {
        $this->call('OPTIONS', '/api/fcm/token', [], [], [], [
            'HTTP_ORIGIN' => 'https://blog.cassiasouzaadvocacia.com.br',
            'HTTP_ACCESS_CONTROL_REQUEST_METHOD' => 'POST',
        ])->assertHeader('Access-Control-Allow-Origin', 'https://blog.cassiasouzaadvocacia.com.br');
    }

    public function test_email_ja_inscrito_responde_sem_duplicar(): void
    {
        Http::fake(['www.google.com/recaptcha/*' => Http::response(['success' => true])]);
        NewsletterSubscriber::create(['email' => 'leitor@example.com']);

        $this->postJson('/api/newsletter', ['email' => 'leitor@example.com', 'recaptcha' => 'ok'])
            ->assertOk()
            ->assertJson(['status' => 'ja_inscrito']);

        $this->assertSame(1, NewsletterSubscriber::count());
    }

    public function test_sem_recaptcha_ou_email_invalido_recusa(): void
    {
        $this->postJson('/api/newsletter', ['email' => 'leitor@example.com'])
            ->assertStatus(422)->assertJsonValidationErrors('recaptcha');

        Http::fake(['www.google.com/recaptcha/*' => Http::response(['success' => true])]);
        $this->postJson('/api/newsletter', ['email' => 'nao-e-email', 'recaptcha' => 'ok'])
            ->assertStatus(422)->assertJsonValidationErrors('email');

        $this->assertSame(0, NewsletterSubscriber::count());
    }

    public function test_cors_libera_so_o_blog(): void
    {
        $this->call('OPTIONS', '/api/newsletter', [], [], [], [
            'HTTP_ORIGIN' => 'https://blog.cassiasouzaadvocacia.com.br',
            'HTTP_ACCESS_CONTROL_REQUEST_METHOD' => 'POST',
        ])->assertHeader('Access-Control-Allow-Origin', 'https://blog.cassiasouzaadvocacia.com.br');

        $outro = $this->call('OPTIONS', '/api/newsletter', [], [], [], [
            'HTTP_ORIGIN' => 'https://site-qualquer.com',
            'HTTP_ACCESS_CONTROL_REQUEST_METHOD' => 'POST',
        ]);
        $this->assertNotSame('https://site-qualquer.com', $outro->headers->get('Access-Control-Allow-Origin'));
    }

    public function test_modal_de_saida_aparece_no_site_menos_no_contato(): void
    {
        $this->get('/')->assertSee('Antes de ir: quer entender o caso da sua empresa?');
        $this->get('/contato')->assertDontSee('Antes de ir: quer entender o caso da sua empresa?');
    }
}
