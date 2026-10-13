<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Mail\ContactRequestMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormRecaptchaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Http::preventStrayRequests();
        config(['services.recaptcha' => ['site_key' => 'site-teste', 'secret_key' => 'secreta-teste']]);
    }

    private function preenchido()
    {
        return Livewire::test(ContactForm::class)
            ->set('nome', 'Maria')
            ->set('phone', '11999999999')
            ->set('email', 'maria@example.com')
            ->set('area', 'Planejamento Tributário')
            ->set('msg', 'Gostaria de uma análise do meu regime tributário.');
    }

    public function test_formulario_mostra_o_recaptcha(): void
    {
        Livewire::test(ContactForm::class)
            ->assertSee('google.com/recaptcha/api.js', false)
            ->assertSee('site-teste');
    }

    public function test_sem_marcar_a_caixa_nao_envia(): void
    {
        $this->preenchido()
            ->call('submit')
            ->assertHasErrors(['recaptcha' => 'required'])
            ->assertDispatched('recaptcha-reset');

        Mail::assertNothingSent();
    }

    public function test_resposta_recusada_pelo_google_nao_envia(): void
    {
        Http::fake(['www.google.com/recaptcha/api/siteverify' => Http::response(['success' => false])]);

        $this->preenchido()
            ->set('recaptcha', 'token-invalido')
            ->call('submit')
            ->assertHasErrors('recaptcha');

        Mail::assertNothingSent();
    }

    public function test_resposta_valida_envia_o_email(): void
    {
        Http::fake(['www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true])]);

        $this->preenchido()
            ->set('recaptcha', 'token-ok')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertDispatched('recaptcha-reset')
            ->assertSet('nome', null);

        Mail::assertSent(ContactRequestMail::class);
        Http::assertSent(fn ($request) => $request['secret'] === 'secreta-teste' && $request['response'] === 'token-ok');
    }

    public function test_sem_chave_configurada_o_formulario_funciona_sem_recaptcha(): void
    {
        config(['services.recaptcha.site_key' => null]);

        $this->preenchido()->call('submit')->assertHasNoErrors();

        Mail::assertSent(ContactRequestMail::class);
    }
}
