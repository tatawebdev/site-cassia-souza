<?php

namespace App\Livewire;

use Livewire\Component;
use App\Rules\Recaptcha;
use App\Services\Newsletter;

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
                $this->dispatch('swal', [
                    'type' => 'warning',
                    'title' => 'E-mail já inscrito',
                    'text' => 'Este e-mail já está inscrito na nossa newsletter.',
                    'timer' => 4000,
                ]);
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
