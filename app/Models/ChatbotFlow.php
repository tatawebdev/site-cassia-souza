<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotFlow extends Model
{
    protected $table = 'chatbot_flows';

    protected $fillable = [
        'nome',
        'descricao',
        'atual',
        'id_step_inicial',
        'processo_de_loop',
        'teste',
    ];

    protected $casts = [
        'atual' => 'boolean',
        'processo_de_loop' => 'boolean',
        'teste' => 'boolean',
    ];
}
