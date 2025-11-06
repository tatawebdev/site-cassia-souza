<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotOption extends Model
{
    protected $table = 'chatbot_options';

    protected $fillable = [
        'id_step',
        'resposta_opcional',
        'id_step_proximo',
        'tipo_interacao',
        'titulo_interacao',
        'descricao_interacao',
        'secao_titulo',
    ];


}
