<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NewsletterSubscriber;

class NewsletterSubscribe extends Component
{
    public $email;
    public $source;

    protected $rules = [
        'email' => 'required|email|unique:newsletter_subscribers,email',
    ];

    public function mount($source = null)
    {
        $this->source = $source;
    }

    public function subscribe()
    {
        $this->validate();

        try {
            NewsletterSubscriber::create([
                'email' => $this->email,
                'source' => $this->source,
            ]);

            session()->flash('newsletter_success', 'Obrigado! Você foi inscrito na nossa newsletter.');
            $this->reset('email');
        } catch (\Exception $e) {
            logger()->error('Newsletter subscribe error: ' . $e->getMessage());
            session()->flash('newsletter_error', 'Erro ao inscrever seu e-mail. Tente novamente mais tarde.');
        }
    }

    public function render()
    {
        return view('livewire.newsletter-subscribe');
    }
}
