<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatbotInteracoesUsuario extends Model
{
    protected $table = 'chatbot_interacoes_usuario';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    private static $table_usuario = 'chatbot_usuario';

    public static function getInteractionsWithUsers()
    {
        $sql = "
        SELECT 
                ciu.id AS interacao_id,
                ciu.id_usuario,
                ciu.id_flow,
                ciu.id_step,
                ciu.aguardando,
                ciu.ultima_interacao,
                cu.*
            FROM " . self::getTableName() . " AS ciu
            LEFT JOIN " . self::$table_usuario . " AS cu ON ciu.id_usuario = cu.id
        ";

        return DB::select($sql);
    }

    public static function upsertInteraction($telefone)
    {
        // Localiza usuario
        $usuario = DB::table(self::$table_usuario)->where('telefone', $telefone)->first();
        if (!$usuario) {
            // Se não existe, cria usuário e interação
            $userId = DB::table(self::$table_usuario)->insertGetId([
                'telefone' => $telefone,
                'created_at' => now(),
            ]);
            $usuario = DB::table(self::$table_usuario)->where('id', $userId)->first();
        }

        $interacaoExistente = DB::table(self::getTableName())->where('id_usuario', $usuario->id)->first();

        if ($interacaoExistente) {
            // Atualiza ultima_interacao
            DB::table(self::getTableName())->where('id', $interacaoExistente->id)->update(['ultima_interacao' => now()]);
            return (array) DB::table(self::getTableName())->where('id', $interacaoExistente->id)->first();
        } else {
            $flowAndStep = self::getFlowAndStep();
            $idFlow = $flowAndStep['id_flow'] ?? 1;
            $idStep = $flowAndStep['id_step'] ?? null;

            $id = DB::table(self::getTableName())->insertGetId([
                'id_usuario' => $usuario->id,
                'id_flow' => $idFlow,
                'id_step' => $idStep,
                'aguardando' => 0,
                'ultima_interacao' => now(),
                'created_at' => now(),
            ]);

            return (array) DB::table(self::getTableName())->where('id', $id)->first();
        }
    }

    public static function getFlowAndStep()
    {
        // Seleciona fluxo atual; se houver constante TESTE pode adaptar
        $flow = DB::table('chatbot_flows')->where('atual', 1)->orWhere('teste', 1)->orderBy('teste', 'desc')->first();
        $idFlow = $flow->id ?? 1;
        $step = DB::table('chatbot_steps')->where('id_flow', $idFlow)->first();
        $idStep = $step->id ?? null;

        return ['id_flow' => $idFlow, 'id_step' => $idStep];
    }

    public static function updateStepById($id, $newIdStep, $aguardando = false)
    {
        $updateValues = [
            'id_step' => $newIdStep,
            'ultima_interacao' => now(),
        ];

        if (!$aguardando) {
            $updateValues['aguardando'] = 0;
        }

        DB::table(self::getTableName())->where('id', $id)->update($updateValues);

        return (array) DB::table(self::getTableName())->where('id', $id)->first();
    }

    public static function addUserAndInteraction($telefone, $nome = null)
    {
        // Cria usuário se não existir
        $user = DB::table(self::$table_usuario)->where('telefone', $telefone)->first();
        if (!$user) {
            $userId = DB::table(self::$table_usuario)->insertGetId([
                'telefone' => $telefone,
                'nome' => $nome,
                'created_at' => now(),
            ]);
            $user = DB::table(self::$table_usuario)->where('id', $userId)->first();
        }

        $interacao = self::upsertInteraction($telefone);

        return [
            'usuario' => (array) $user,
            'interacao' => $interacao,
        ];
    }

    private static function getTableName()
    {
        return (new self())->getTable();
    }
}
