<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NewsletterSubscriber;
use App\Rules\Recaptcha;
use App\Services\Newsletter;
use Illuminate\Support\Facades\RateLimiter;

class NewsletterSubscribe extends Component
{
    public $email;
    public $source;

    /** Resposta do reCAPTCHA v2, preenchida ao confirmar "Não sou um robô". */
    public $recaptcha = '';

    protected function rules(): array
    {
        // E-mail já inscrito é tratado em subscribe(), com aviso amigável
        $rules = ['email' => 'required|email'];

        if (config('services.recaptcha.site_key')) {
            $rules['recaptcha'] = ['required', new Recaptcha()];
        }

        return $rules;
    }

    protected function messages(): array
    {
        return ['recaptcha.required' => 'Confirme que você não é um robô.'];
    }

    public function mount($source = null)
    {
        $this->source = $source;
    }

    /**
     * Chamado antes do reCAPTCHA: e-mail já inscrito recebe o aviso direto, sem
     * precisar confirmar que não é robô. True encerra o envio no navegador.
     * Limitado por IP para ninguém usar isso para descobrir quem está na lista;
     * passando do limite, segue para o reCAPTCHA como os demais.
     */
    public function jaInscrito(): bool
    {
        $this->resetErrorBag();
        if (validator(['email' => $this->email], ['email' => 'required|email'])->fails()) {
            $this->addError('email', 'Informe um e-mail válido.');

            return true;
        }

        $chave = 'newsletter-ja-inscrito:'.request()->ip();
        if (RateLimiter::tooManyAttempts($chave, 10)) {
            return false;
        }
        RateLimiter::hit($chave, 60);

        if (! NewsletterSubscriber::where('email', $this->email)->exists()) {
            return false;
        }

        $this->avisarJaInscrito();

        return true;
    }

    private function avisarJaInscrito(): void
    {
        $this->dispatch('swal', [
            'type' => 'info',
            'title' => 'Você já está inscrito',
            'text' => 'Este e-mail já recebe a nossa newsletter.',
            'timer' => 4000,
        ]);
    }

    public function subscribe()
    {
        try {
            $this->validate();
        } finally {
            // A resposta do reCAPTCHA só vale uma vez
            $this->recaptcha = '';
            $this->dispatch('newsletter-recaptcha-reset');
        }

        try {
            $resultado = app(Newsletter::class)->inscrever($this->email, $this->source);

            if ($resultado === Newsletter::JA_INSCRITO) {
                $this->avisarJaInscrito();
                return;
            }

            // Livewire 3: dispatch() replaces dispatchBrowserEvent
            $this->dispatch('swal', [
                'type' => 'success',
                'title' => 'Inscrição efetuada',
                'text' => 'Obrigado! Você foi inscrito na nossa newsletter.',
                'timer' => 4000,
            ]);
            $this->reset('email');
        } catch (\Exception $e) {
            logger()->error('Newsletter subscribe error: ' . $e->getMessage());
            $this->dispatch('swal', [
                'type' => 'error',
                'title' => 'Erro',
                'text' => 'Erro ao inscrever seu e-mail. Tente novamente mais tarde.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.newsletter-subscribe');
    }
}
