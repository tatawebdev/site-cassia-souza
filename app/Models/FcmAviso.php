<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Artigo do blog já avisado aos inscritos: no navegador (FCM) e por e-mail
// (newsletter). Evita mandar o mesmo post duas vezes.
class FcmAviso extends Model
{
    protected $table = 'fcm_avisos';

    protected $fillable = [
        'url',
        'titulo',
        'resumo',
        'imagem',
        'categoria',
        'enviados',
        'falhas',
        'emails_enviados',
        'emails_falhas',
    ];
}
