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

    public static function getRespostaByNumero($numero)
    {
        return self::where('numero', $numero)->value('resposta');
    }

    public static function getCNPJByNumero($numero)
    {
        return self::where('numero', $numero)
            ->where('nome_campo', 'CNPJ')
            ->value('resposta');
    }

    public static function getAssuntoUsuarioByNumero($numero)
    {
        $assunto = self::where('numero', $numero)
            ->where('nome_campo', 'Assunto')
            ->value('resposta');

        return $assunto ? " - {$assunto}" : null;
    }

    public static function getGroupedByNumero()
    {
        return self::select('numero')->groupBy('numero')->get();
    }

    public static function getInteracoesPendentes()
    {
        return \DB::table('chatbot_interacoes_usuario as ci')
            ->leftJoin('chatbot_usuario as cu', 'cu.id', '=', 'ci.id_usuario')
            ->leftJoin('chatbot_atendimento as ca', 'cu.telefone', '=', 'ca.numero')
            ->where(function ($query) {
                $query->whereRaw('TIMESTAMPDIFF(HOUR, ci.ultima_interacao, NOW()) > 3')
                      ->orWhere('ci.aguardando', 1);
            })
            ->select('ca.*')
            ->get();
    }

    public static function getInteracoesAbandonoChatBot()
    {
        return \DB::table('chatbot_interacoes_usuario')
            ->whereRaw('TIMESTAMPDIFF(HOUR, ultima_interacao, NOW()) < 3')
            ->where('aguardando', 1)
            ->get();
    }

    public static function deleteByNumero($numero)
    {
        self::where('numero', $numero)->delete();
    }

    public static function getAllByNumero($numero)
    {
        return self::where('numero', $numero)->get();
    }

    public static function insertByNumeroCampoResposta($numero, $campo, $resposta)
    {
        self::create([
            'numero' => $numero,
            'nome_campo' => $campo,
            'resposta' => $resposta
        ]);
    }
}
