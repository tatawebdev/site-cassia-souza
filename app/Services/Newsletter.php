<?php

namespace App\Services;

use App\Mail\NewsletterConfirmationMail;
use App\Mail\NewsletterNotificationMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;

/**
 * Inscrição na newsletter, usada pelo rodapé do site (Livewire) e pelo
 * modal do blog (POST /api/newsletter).
 */
class Newsletter
{
    public const INSCRITO = 'inscrito';

    public const JA_INSCRITO = 'ja_inscrito';

    public function inscrever(string $email, ?string $origem = null): string
    {
        if (NewsletterSubscriber::where('email', $email)->exists()) {
            return self::JA_INSCRITO;
        }

        $inscrito = NewsletterSubscriber::create(['email' => $email, 'source' => $origem]);

        try {
            Mail::to('cassia_souza@adv.oabsp.org.br')->cc('suporte@tataweb.com.br')
                ->send(new NewsletterConfirmationMail($inscrito));
        } catch (\Exception $e) {
            logger()->error('Erro ao enviar e-mail de confirmação: '.$e->getMessage());
        }

        $admin = config('site.contact_email') ?? config('mail.from.address');
        if ($admin) {
            try {
                Mail::to($admin)->send(new NewsletterNotificationMail($inscrito));
            } catch (\Exception $e) {
                logger()->error('Erro ao enviar notificação ao admin: '.$e->getMessage());
            }
        }

        return self::INSCRITO;
    }
}
