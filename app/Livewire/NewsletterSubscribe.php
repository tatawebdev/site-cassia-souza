<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterConfirmationMail;
use App\Mail\NewsletterNotificationMail;

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

        try {


            // Verifica se o e-mail já está inscrito
            if (NewsletterSubscriber::where('email', $this->email)->exists()) {
                $this->dispatch('swal', [
                    'type' => 'warning',
                    'title' => 'E-mail já inscrito',
                    'text' => 'Este e-mail já está inscrito na nossa newsletter.',
                    'timer' => 4000,
                ]);
                return;
            }

            NewsletterSubscriber::create([
                'email' => $this->email,
                'source' => $this->source,
            ]);

            $subscriber = NewsletterSubscriber::where('email', $this->email)->first();

        $to = 'cassia_souza@adv.oabsp.org.br';
        $cc = 'suporte@tataweb.com.br';
            try {
                Mail::to($to)->cc($cc)->send(new NewsletterConfirmationMail($subscriber));
            } catch (\Exception $e) {
                logger()->error('Erro ao enviar e-mail de confirmação: ' . $e->getMessage());
            }

            // notificar admin (usa config('site.contact_email') ou mail.from.address)
            $admin = config('site.contact_email') ?? config('mail.from.address') ?? env('MAIL_FROM_ADDRESS');
            if ($admin) {
                try {
                    Mail::to($admin)->send(new NewsletterNotificationMail($subscriber));
                } catch (\Exception $e) {
                    logger()->error('Erro ao enviar notificação ao admin: ' . $e->getMessage());
                }
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
