<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Um destinatário de um aviso de artigo (navegador ou e-mail) e se deu certo
class FcmAvisoEnvio extends Model
{
    public const NAVEGADOR = 'navegador';
    public const EMAIL = 'email';

    protected $table = 'fcm_aviso_envios';

    protected $fillable = [
        'fcm_aviso_id',
        'canal',
        'destino',
        'ok',
        'erro',
    ];

    protected $casts = [
        'ok' => 'boolean',
    ];
}
