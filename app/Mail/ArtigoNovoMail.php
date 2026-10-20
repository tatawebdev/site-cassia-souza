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
        return $this->subject($this->aviso->titulo)
            ->view('emails.artigo-novo')
            ->withSymfonyMessage(function (Email $mensagem) {
                $mensagem->getHeaders()->addTextHeader('List-Unsubscribe', '<'.$this->linkCancelar.'>');
            });
    }
}
