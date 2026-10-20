<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Artigo do blog já avisado aos inscritos do site (evita mandar o mesmo duas vezes)
class FcmAviso extends Model
{
    protected $table = 'fcm_avisos';

    protected $fillable = [
        'url',
        'titulo',
        'enviados',
        'falhas',
    ];
}
