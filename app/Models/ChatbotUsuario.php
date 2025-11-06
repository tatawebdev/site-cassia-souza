<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotUsuario extends Model
{
    protected $table = 'chatbot_usuario';

    protected $fillable = [
        'nome',
        'telefone',
        'ultima_mensagem',
        'ultima_conversa',
        'notBot',
        'notion',
        'ia',
    ];

    protected $casts = [
        'ultima_mensagem' => 'datetime',
        'ultima_conversa' => 'datetime',
        'ia' => 'boolean',
        'notBot' => 'boolean',
    ];
}
