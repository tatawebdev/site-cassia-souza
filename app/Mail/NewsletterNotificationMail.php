<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;

    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function build()
    {
        return $this->subject('Novo assinante da newsletter')
                    ->view('emails.newsletter-notification')
                    ->with('subscriber', $this->subscriber);
    }
}
