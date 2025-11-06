<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotConfigMessageInteractive extends Model
{
    protected $table = 'chatbot_config_message_interactive';

    protected $fillable = [
        'id_step',
        'texto_cabecalho',
        'texto_corpo',
        'texto_rodape',
        'texto_botao',
    ];
}
