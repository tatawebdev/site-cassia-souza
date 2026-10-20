<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    // Quem recebe: o painel (chat, só com login) ou o site (artigos novos)
    public const PAINEL = 'painel';
    public const SITE = 'site';

    protected $table = 'fcm_tokens';

    protected $fillable = [
        'token',
        'publico',
    ];
}
