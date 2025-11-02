<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactRequestMail;

class ContactForm extends Component
{
    public $nome;
    public $phone;
    public $email;
    public $area;
    public $msg;

    protected $rules = [
        'nome' => 'required|min:2',
        'phone' => 'required',
        'email' => 'required|email',
        'area' => 'required',
        'msg' => 'required|min:10',
    ];

    public function submit()
    {
        $data = $this->validate();

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

    public function render()
    {
        return view('livewire.contact-form');
    }
}
