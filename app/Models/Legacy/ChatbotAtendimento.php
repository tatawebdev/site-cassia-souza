<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatbotAtendimento extends Model
{
    protected $table = 'chatbot_atendimento';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

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
        return self::where('numero', $numero)
            ->where('nome_campo', 'Assunto')
            ->value('resposta');
    }

    public static function getGroupedByNumero()
    {
        return self::select('numero')->groupBy('numero')->get()->toArray();
    }

    public static function getInteracoesPendentes()
    {
        // Reimplementa a query com query builder
        return DB::table('chatbot_interacoes_usuario as ci')
            ->leftJoin('chatbot_usuario as cu', 'cu.id', '=', 'ci.id_usuario')
            ->leftJoin('chatbot_atendimento as ca', 'cu.telefone', '=', 'ca.numero')
            ->select('ca.*')
            ->whereRaw('(TIMESTAMPDIFF(HOUR, ci.ultima_interacao, NOW()) > 3 OR ci.aguardando = 1)')
            ->get()
            ->toArray();
    }

    public static function getInteracoesAbandonoChatBot()
    {
        return DB::table('chatbot_interacoes_usuario')
            ->whereRaw('(TIMESTAMPDIFF(HOUR, ultima_interacao, NOW()) < 3 and aguardando = 1)')
            ->get()
            ->toArray();
    }

    public static function deleteByNumero($numero)
    {
        return self::where('numero', $numero)->delete();
    }

    public static function getAllByNumero($numero)
    {
        return self::where('numero', $numero)->get()->toArray();
    }

    public static function insertByNumeroCampoResposta($numero, $campo, $resposta)
    {
        return self::create([
            'numero' => $numero,
            'nome_campo' => $campo,
            'resposta' => $resposta,
        ]);
    }
}
