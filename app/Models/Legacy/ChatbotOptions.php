<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatbotOptions extends Model
{
    protected $table = 'chatbot_options';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function getAllOptions()
    {
        return self::select('id', 'id_step', 'resposta_opcional', 'id_step_proximo', 'tipo_interacao', 'titulo_interacao', 'descricao_interacao')->get()->toArray();
    }

    public static function getOptionById($id)
    {
        return self::select('id', 'id_step', 'resposta_opcional', 'id_step_proximo', 'tipo_interacao', 'titulo_interacao', 'descricao_interacao')->where('id', $id)->first();
    }

    public static function addOption($data)
    {
        return self::create($data)->id;
    }

    public static function updateOption($id, $data)
    {
        return self::where('id', $id)->update($data);
    }

    public static function deleteOption($id)
    {
        return self::where('id', $id)->delete();
    }

    public static function getBotoesMensagemWhatsApp($id_step)
    {
        $opcoes = DB::table('chatbot_options')->select('id', 'titulo_interacao')->where('id_step', $id_step)->orderBy('id')->get();

        if ($opcoes->isEmpty()) {
            return [];
        }

        $buttons = [];
        foreach ($opcoes as $key => $opcao) {
            $buttons[] = [
                'type' => 'reply',
                'reply' => [
                    'id' => (string) $opcao->id,
                    'title' => $opcao->titulo_interacao,
                ],
            ];
        }

        return $buttons;
    }

    public static function getListaInterativaWhatsApp($id_step)
    {
        $opcoes = DB::table('chatbot_options')->where('id_step', $id_step)->orderBy('id')->get();
        if ($opcoes->isEmpty()) {
            return [];
        }

        $rows = [];
        foreach ($opcoes as $opcao) {
            $rows[] = [
                'id' => (string) $opcao->id,
                'title' => $opcao->titulo_interacao,
                'description' => $opcao->descricao_interacao ?? '',
            ];
        }

        return $rows;
    }
}
