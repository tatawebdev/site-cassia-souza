<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactRequestMail;
use App\Rules\Recaptcha;
use Illuminate\Validation\ValidationException;

class ContactForm extends Component
{
    public $nome;
    public $phone;
    public $email;
    public $area;
    public $msg;

    /** Resposta do reCAPTCHA v2, preenchida pelo widget no navegador. */
    public $recaptcha = '';

    protected function rules(): array
    {
        $rules = [
            'nome' => 'required|min:2',
            'phone' => 'required',
            'email' => 'required|email',
            'area' => 'required',
            'msg' => 'required|min:10',
        ];

        if (config('services.recaptcha.site_key')) {
            $rules['recaptcha'] = ['required', new Recaptcha()];
        }

        return $rules;
    }

    protected function messages(): array
    {
        return ['recaptcha.required' => 'Marque a caixa "Não sou um robô".'];
    }

    public function submit()
    {
        try {
            $data = $this->validate();
        } catch (ValidationException $e) {
            // A resposta do reCAPTCHA só vale uma vez: pede outra marcação
            $this->resetRecaptcha();

            throw $e;
        }

        unset($data['recaptcha']);
        $this->resetRecaptcha();

        $to = 'cassia_souza@adv.oabsp.org.br';
        $cc = 'suporte@tataweb.com.br';

        try {
            Mail::to($to)->cc($cc)->send(new ContactRequestMail($data));
            // Livewire 3: use dispatch() to send browser events
            $this->dispatch('swal', [
                'type' => 'success',
                'title' => 'Mensagem enviada',
                'text' => 'Mensagem enviada com sucesso. Entraremos em contato em breve.',
                'timer' => 4000,
            ]);
            $this->reset(['nome', 'phone', 'email', 'area', 'msg']);
        } catch (\Exception $e) {
            logger()->error('Erro ao enviar contato: ' . $e->getMessage());
            $this->dispatch('swal', [
                'type' => 'error',
                'title' => 'Erro',
                'text' => 'Ocorreu um erro ao enviar sua mensagem. Tente novamente mais tarde.',
            ]);
        }
    }

    private function resetRecaptcha(): void
    {
        $this->recaptcha = '';
        $this->dispatch('recaptcha-reset');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
