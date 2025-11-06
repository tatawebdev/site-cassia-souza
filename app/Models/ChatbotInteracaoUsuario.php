<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotInteracaoUsuario extends Model
{
    protected $table = 'chatbot_interacoes_usuario';

    protected $fillable = [
        'id_usuario',
        'id_flow',
        'id_step',
        'primeira_interacao',
        'ultima_interacao',
        'aguardando',
        'tipo_interacao_esperado',
        'ia',
    ];

    protected $casts = [
        'aguardando' => 'boolean',
        'primeira_interacao' => 'boolean',
        'ia' => 'boolean',
        'ultima_interacao' => 'datetime',
    ];
}
