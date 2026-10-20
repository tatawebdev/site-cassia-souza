<?php

namespace App\Mail;

use App\Models\FcmAviso;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

/**
 * Artigo novo do blog para um inscrito da newsletter. O link de descadastro é
 * assinado (só funciona para aquele e-mail) e vai também no cabeçalho
 * List-Unsubscribe, que o Gmail e o Outlook mostram como "Cancelar inscrição".
 */
class ArtigoNovoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public FcmAviso $aviso, public string $linkCancelar)
    {
    }

    public function build()
    {
        // Respostas vão para a Cassia (o remetente é do domínio do site, que pode
        // enviar pelo nosso SMTP; o da OAB-SP rejeita e-mail vindo de fora)
        return $this->subject($this->aviso->titulo)
            ->replyTo('cassia_souza@adv.oabsp.org.br', 'Cassia Souza')
            ->view('emails.artigo-novo')
            ->withSymfonyMessage(function (Email $mensagem) {
                $mensagem->getHeaders()->addTextHeader('List-Unsubscribe', '<'.$this->linkCancelar.'>');
            });
    }
}
