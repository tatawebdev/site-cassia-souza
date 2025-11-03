<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatbotUsuario extends Model
{
    protected $table = 'chatbot_usuario';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    // Construtor padrão do Eloquent não foi sobrescrito para manter a compatibilidade

    public static function getAllUsers()
    {
        return self::select('id', 'telefone', 'nome')->get()->toArray();
    }

    public static function findUser($id, $columns = ['*'])
    {
        return self::select($columns)->where('id', $id)->first();
    }

    public static function addUserIfNotExists($telefone, $nome = null)
    {
        $user = self::where('telefone', $telefone)->first();
        if (!$user) {
            $id = self::create(['telefone' => $telefone, 'nome' => $nome])->id;
            $user = self::where('id', $id)->first();
        }

        // Atualiza últimos timestamps
        self::where('id', $user->id)->update([
            'ultima_mensagem' => now(),
            'ultima_conversa' => now(),
        ]);

        // Nota: campos relacionados ao Notion ou flags podem ser mantidos conforme necessário

        return $user->toArray();
    }
}
