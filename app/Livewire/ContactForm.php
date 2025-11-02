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

        Mail::to($to)->cc($cc)->send(new ContactRequestMail($data));
        session()->flash('contact_success', 'Mensagem enviada com sucesso. Entraremos em contato em breve.');
        $this->reset(['nome', 'phone', 'email', 'area', 'msg']);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
