<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotAtendimento extends Model
{
    protected $table = 'chatbot_atendimento';

    protected $fillable = [
        'numero',
        'nome_campo',
        'resposta',
    ];
}
