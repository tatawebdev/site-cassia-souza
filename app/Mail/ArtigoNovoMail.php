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
        // Remetente do domínio do site, que pode enviar pelo nosso SMTP (o da OAB-SP
        // tem DMARC p=reject e é recusado vindo de fora). Respostas vão para a Cassia.
        return $this->subject($this->aviso->titulo)
            ->from('contato@cassiasouzaadvocacia.com.br', 'Cassia Souza Advocacia')
            ->replyTo('cassia_souza@adv.oabsp.org.br', 'Cassia Souza')
            ->view('emails.artigo-novo')
            ->withSymfonyMessage(function (Email $mensagem) {
                $mensagem->getHeaders()->addTextHeader('List-Unsubscribe', '<'.$this->linkCancelar.'>');
            });
    }
}
