<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotInteracaoUsuario extends Model
{
    protected $table = 'chatbot_interacoes_usuario';

    protected $fillable = [
        'id_usuario',
        'id_flow',
        'id_step',
        'primeira_interacao',
        'ultima_interacao',
        'aguardando',
        'tipo_interacao_esperado',
        'ia',
    ];

    protected $casts = [
        'aguardando' => 'boolean',
        'primeira_interacao' => 'boolean',
        'ia' => 'boolean',
        'ultima_interacao' => 'datetime',
    ];


    public static function addUserAndInteraction($telefone, $nome = null)
    {
        $usuario = ChatbotUsuario::addUserIfNotExists($telefone, $nome)?->toArray();
        $interacao = self::upsertInteraction($telefone)?->toArray();

        return [
            'usuario_id' => $usuario['id'],
            'telefone' => $usuario['telefone'],
            'nome' => $usuario['nome'],
            'notion' => $usuario['notion'] ?? null,
            'ia' => $usuario['ia'] ?? null,
            'notBot' => $usuario['notBot'],
            'interacoes_id' => $interacao['id'],
            'id_flow' => $interacao['id_flow'],
            'id_step' => $interacao['id_step'],
            'primeira_interacao' => $interacao['primeira_interacao'],
            'aguardando' => $interacao['aguardando'],
            'tipo_interacao_esperado' => $interacao['tipo_interacao_esperado'],
            'ultima_interacao' => $interacao['ultima_interacao'],
        ];
    }


    public static function upsertInteraction($telefone)
    {
        // Passo 1: Obter o usuário pelo telefone
        $usuario = ChatbotUsuario::where('telefone', $telefone)->first();

        if (!$usuario) {
            throw new \Exception("Usuário não encontrado com o telefone: $telefone");
        }

        $id_usuario = $usuario->id ?? null;

        // Passo 2: Verificar se a interação já existe
        $interacaoExistente = self::where('id_usuario', $id_usuario)->first();

        $fluxoAtual = ChatbotFlow::where('atual', 1)->first();

        if ($interacaoExistente) {
            if ($fluxoAtual) {
                $novoIdFlow = $fluxoAtual->id;

                if (
                    $interacaoExistente->id_flow != $novoIdFlow ||
                    ($fluxoAtual->processo_de_loop == 1 && $interacaoExistente->id_step == null)
                ) {
                    $flowAndStep = self::getFlowAndStep();
                    $interacaoExistente->update([
                        'id_flow' => $flowAndStep['id_flow'],
                        'id_step' => $flowAndStep['id_step'],
                        'aguardando' => false,
                        'tipo_interacao_esperado' => '',
                        'ultima_interacao' => now()
                    ]);
                } else {
                    $interacaoExistente->update([
                        'ultima_interacao' => now()
                    ]);
                }
                return $interacaoExistente->fresh();
            }
            return $interacaoExistente->fresh();
        } else {
            $flowAndStep = self::getFlowAndStep();
            $novaInteracao = self::create([
                'id_usuario' => $id_usuario,
                'id_flow' => $flowAndStep['id_flow'],
                'id_step' => $flowAndStep['id_step'],
                'primeira_interacao' => now(),
                'ultima_interacao' => now()
            ]);
            return $novaInteracao->fresh();
        }
    }

    public static function updateStepById($id, $newIdStep, $aguardando = false)
    {
        $interacao = self::find($id);

        if (!$interacao) {
            return null;
        }

        $interacao->update([
            'id_step' => $newIdStep,
            'aguardando' => $aguardando ? $interacao->aguardando : false,
            'tipo_interacao_esperado' => $aguardando ? $interacao->tipo_interacao_esperado : '',
        ]);

        return $interacao->fresh();
    }
    public static function getFlowAndStep()
    {
        $flow = ChatbotFlow::where('atual', 1)->first();

        $idFlow = $flow ? $flow->id : 1;

        $step = ChatbotStep::where('id_flow', $idFlow)->first();

        $idStep = $step ? $step->id : null;

        return [
            'id_flow' => $idFlow,
            'id_step' => $idStep
        ];
    }

}
