<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotStep extends Model
{
    protected $table = 'chatbot_steps';

    protected $fillable = [
        'id_flow',
        'pergunta',
        'tipo_resposta',
        'tipo_interacao',
        'id_step_proximo',
        'nome_da_funcao',
        'parent',
        'nome_campo',
        'titulo',
    ];


    public function options()
    {
        return $this->hasMany(ChatbotOption::class, 'id_step', 'id');
    }

}
