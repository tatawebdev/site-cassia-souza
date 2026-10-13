<?php

namespace Tests\Feature;

use App\Livewire\NewsletterSubscribe;
use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class NewsletterRecaptchaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Http::preventStrayRequests();
        config(['services.recaptcha' => ['site_key' => 'site-teste', 'secret_key' => 'secreta-teste']]);
    }

    public function test_confirmacao_so_aparece_na_janela_do_inscrever_se(): void
    {
        Livewire::test(NewsletterSubscribe::class)
            ->assertSee('Confirme sua inscrição')
            ->assertSee('google.com/recaptcha/api.js', false);
    }

    public function test_sem_confirmar_nao_inscreve(): void
    {
        Livewire::test(NewsletterSubscribe::class)
            ->set('email', 'maria@example.com')
            ->call('subscribe')
            ->assertHasErrors(['recaptcha' => 'required'])
            ->assertDispatched('newsletter-recaptcha-reset');

        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }

    public function test_email_invalido_nao_inscreve(): void
    {
        Http::fake(['www.google.com/recaptcha/*' => Http::response(['success' => true])]);

        Livewire::test(NewsletterSubscribe::class)
            ->set('email', 'nao-e-email')
            ->set('recaptcha', 'token-ok')
            ->call('subscribe')
            ->assertHasErrors(['email' => 'email']);

        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }

    public function test_confirmado_inscreve(): void
    {
        Http::fake(['www.google.com/recaptcha/*' => Http::response(['success' => true])]);

        Livewire::test(NewsletterSubscribe::class)
            ->set('email', 'maria@example.com')
            ->set('recaptcha', 'token-ok')
            ->call('subscribe')
            ->assertHasNoErrors()
            ->assertSet('recaptcha', '')
            ->assertDispatched('swal');

        $this->assertTrue(NewsletterSubscriber::where('email', 'maria@example.com')->exists());
    }

    public function test_sem_chave_configurada_inscreve_direto(): void
    {
        config(['services.recaptcha.site_key' => null]);

        Livewire::test(NewsletterSubscribe::class)
            ->assertDontSee('Confirme sua inscrição')
            ->set('email', 'joao@example.com')
            ->call('subscribe')
            ->assertHasNoErrors();

        $this->assertTrue(NewsletterSubscriber::where('email', 'joao@example.com')->exists());
    }
}
