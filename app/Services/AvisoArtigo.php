<?php

namespace App\Services;

use App\Mail\ArtigoNovoMail;
use App\Models\FcmAviso;
use App\Models\FcmToken;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

/**
 * Aviso de artigo novo do blog: notificação no navegador para quem ativou os
 * avisos e e-mail para os inscritos da newsletter. Roda depois da resposta (o
 * blog chama /api/fcm/avisos) ou pelo comando fcm:avisar-artigo.
 */
class AvisoArtigo
{
    public function __construct(private FcmService $fcm)
    {
    }

    public function enviar(FcmAviso $aviso, bool $navegador = true, bool $email = true): void
    {
        if ($navegador) {
            try {
                $aviso->update($this->fcm->enviarPara(FcmToken::SITE, $aviso->titulo, 'Artigo novo da Cassia Souza no blog', [], $aviso->url));
            } catch (\Exception $e) {
                Log::error('Aviso de artigo não enviado ao navegador: '.$e->getMessage(), ['url' => $aviso->url]);
            }
        }

        if ($email) {
            $enviados = $falhas = 0;
            NewsletterSubscriber::orderBy('id')->each(function (NewsletterSubscriber $inscrito) use ($aviso, &$enviados, &$falhas) {
                $this->enviarEmail($aviso, $inscrito) ? $enviados++ : $falhas++;
            });
            $aviso->update(['emails_enviados' => $enviados, 'emails_falhas' => $falhas]);
        }
    }

    /** Um e-mail; também usado para testar o visual com --para no comando. */
    public function enviarEmail(FcmAviso $aviso, NewsletterSubscriber $inscrito): bool
    {
        try {
            Mail::to($inscrito->email)->send(new ArtigoNovoMail($aviso, self::linkCancelar($inscrito)));

            return true;
        } catch (\Exception $e) {
            Log::error('E-mail de artigo novo não enviado: '.$e->getMessage(), ['email' => $inscrito->email]);

            return false;
        }
    }

    public static function linkCancelar(NewsletterSubscriber $inscrito): string
    {
        return URL::signedRoute('newsletter.cancelar', ['inscrito' => $inscrito->id]);
    }
}
