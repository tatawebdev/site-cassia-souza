<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatbotInteracoesChat extends Model
{
    protected $table = 'chatbot_interacoes_chat';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    // Atualiza status e seta campo de data correspondente
    public static function atualizarStatus($id, $status, $dataStatusField)
    {
        $payload = [
            'status_mensagem' => $status,
        ];
        $payload[$dataStatusField] = now();

        return self::where('id', $id)->update($payload);
    }

    public static function buscarMensagensPorUsuario($usuario_id)
    {
        return self::where('usuario_id', $usuario_id)->get()->toArray();
    }

    public static function deletar($id)
    {
        return self::where('id', $id)->delete();
    }
}
