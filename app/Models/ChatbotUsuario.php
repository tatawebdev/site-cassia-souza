<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotUsuario extends Model
{
    protected $table = 'chatbot_usuario';

    protected $fillable = [
        'nome',
        'telefone',
        'ultima_mensagem',
        'ultima_conversa',
        'notBot',
        'notion',
        'ia',
    ];

    protected $casts = [
        'ultima_mensagem' => 'datetime',
        'ultima_conversa' => 'datetime',
        'ia' => 'boolean',
        'notBot' => 'boolean',
    ];


    public static function addUserIfNotExists($telefone, $nome = null)
    {
        // Tenta recuperar o usuário pelo telefone
        $user = self::where('telefone', $telefone)->first();

        // Se não existir, insere um novo usuário
        if (!$user) {
            $user = self::create([
                'telefone' => $telefone,
                'nome' => $nome,
            ])->fresh();
        }

        // Atualiza os campos de data/hora
        $user->ultima_mensagem = now();
        $user->ultima_conversa = now();
        $user->save();


        // Se não tiver notion, cria
        // if (!$user->notion) {
        //     try {
        //         $notion = new NotionClient();
        //         $response = $notion->newcreatePage("{$nome} | {$telefone}");
        //         $user->notion = str_replace("-", "", $response['id']);
        //         $user->save();
        //     } catch (\Exception $e) {
        //         // Log error or handle as needed
        //     }
        // }

        return $user;
    }

}
