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
    public static function getBotoesMensagemWhatsApp($id_step)
    {
        $opcoes = self::where('id_step', $id_step)
            ->select('id', 'titulo_interacao')
            ->get();

        if ($opcoes->isEmpty()) {
            return [];
        }

        $buttons = [];
        foreach ($opcoes as $opcao) {
            $buttons[] = [
                'type' => 'reply',
                'reply' => [
                    'id' => $opcao->id,
                    'title' => $opcao->titulo_interacao
                ]
            ];
        }

        return $buttons;
    }

}
