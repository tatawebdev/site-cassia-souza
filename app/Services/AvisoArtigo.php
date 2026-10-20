<?php

namespace App\Services;

use App\Mail\ArtigoNovoMail;
use App\Models\FcmAviso;
use App\Models\FcmAvisoEnvio;
use App\Models\FcmToken;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

/**
 * Aviso de artigo novo do blog: notificação no navegador para quem ativou os
 * avisos e e-mail para os inscritos da newsletter. Roda depois da resposta (o
 * blog chama /api/fcm/avisos) ou pelo comando fcm:avisar-artigo. Cada
 * destinatário fica registrado em fcm_aviso_envios, com o resultado.
 */
class AvisoArtigo
{
    public function __construct(private FcmService $fcm)
    {
    }

    public function enviar(FcmAviso $aviso, bool $navegador = true, bool $email = true): void
    {
        if ($navegador) {
            $this->enviarNavegador($aviso);
        }

        if ($email) {
            $enviados = $falhas = 0;
            NewsletterSubscriber::orderBy('id')->each(function (NewsletterSubscriber $inscrito) use ($aviso, &$enviados, &$falhas) {
                $erro = $this->enviarEmail($aviso, $inscrito);
                $erro === null ? $enviados++ : $falhas++;
                $this->registrar($aviso, FcmAvisoEnvio::EMAIL, $inscrito->email, $erro);
            });
            $aviso->update(['emails_enviados' => $enviados, 'emails_falhas' => $falhas]);
        }
    }

    /**
     * Um e-mail; também usado para testar o visual com --para no comando.
     *
     * @return string|null o erro, ou null se foi enviado
     */
    public function enviarEmail(FcmAviso $aviso, NewsletterSubscriber $inscrito): ?string
    {
        try {
            Mail::to($inscrito->email)->send(new ArtigoNovoMail($aviso, self::linkCancelar($inscrito)));

            return null;
        } catch (\Exception $e) {
            Log::error('E-mail de artigo novo não enviado: '.$e->getMessage(), ['email' => $inscrito->email]);

            return $e->getMessage();
        }
    }

    public static function linkCancelar(NewsletterSubscriber $inscrito): string
    {
        return URL::signedRoute('newsletter.cancelar', ['inscrito' => $inscrito->id]);
    }

    private function enviarNavegador(FcmAviso $aviso): void
    {
        // O token não diz nada a ninguém: na tabela, o navegador aparece pelo número
        $ids = FcmToken::where('publico', FcmToken::SITE)->pluck('id', 'token');

        try {
            $resultado = $this->fcm->enviarPara(FcmToken::SITE, $aviso->titulo, 'Artigo novo da Cassia Souza no blog', [], $aviso->url);
        } catch (\Exception $e) {
            Log::error('Aviso de artigo não enviado ao navegador: '.$e->getMessage(), ['url' => $aviso->url]);
            $this->registrar($aviso, FcmAvisoEnvio::NAVEGADOR, 'todos', $e->getMessage());

            return;
        }

        $aviso->update(['enviados' => $resultado['enviados'], 'falhas' => $resultado['falhas']]);
        foreach ($resultado['resultados'] as $token => $r) {
            $erro = $r['ok'] ? null : (($r['invalido'] ?? false)
                ? 'Navegador cancelou a inscrição (removido da lista)'
                : 'Google respondeu HTTP '.$r['status']);
            $this->registrar($aviso, FcmAvisoEnvio::NAVEGADOR, 'Navegador #'.($ids[$token] ?? '?'), $erro);
        }
    }

    private function registrar(FcmAviso $aviso, string $canal, string $destino, ?string $erro): void
    {
        FcmAvisoEnvio::create([
            'fcm_aviso_id' => $aviso->id,
            'canal' => $canal,
            'destino' => $destino,
            'ok' => $erro === null,
            'erro' => $erro ? mb_substr($erro, 0, 500) : null,
        ]);
    }
}
