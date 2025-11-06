<?php

namespace App\Services;

use App\Models\ChatbotInteracaoChat;
use App\Models\ChatbotInteracaoUsuario;
use App\Models\ChatbotOption;
use App\Models\ChatbotStep;
use App\Services\GeminiService;
use App\Services\WhatsAppService;
use App\Services\Helpers;

class ChatbotService
{

    public $nomeUsuario = null;
    public $numeroUsuario;
    public $mensagemUsuario;
    public $mensagemId;
    public $event_type;
    public $interactiveId;
    public $last_message_id;
    public $updateStep = false;
    public $stopStep = false;
    protected GeminiService $gemini;
    protected WhatsAppService $whatsapp;

    public function __construct(GeminiService $gemini, WhatsAppService $whatsapp)
    {
        require_once app_path('Functions/validacoes.php');

        $this->gemini = $gemini;
        $this->whatsapp = $whatsapp;
    }

    public function processInput(array $data): void
    {
        if (empty($data['celular']) || empty($data['message'])) {
            return;
        }
        $this->nomeUsuario = $data['name'] ?? null;
        $this->numeroUsuario = $data['celular'] ?? null;
        $this->mensagemUsuario = $data['message'] ?? null;
        $this->mensagemId = $data['message_id'] ?? null;
        $this->event_type = $data['event_type'] ?? 'message_text';
        $this->interactiveId = $data['interactive_id'] ?? null;
        $this->updateStep = false;
        $resultado = $this->obterUsuarioEEtapa();


        $step = $resultado['step'] ?? null;
        $usuario = $resultado['usuario'] ?? null;



        // try {
        //     $notion = new NotionClient();
        //     $response = $notion->addTextToPage($this->mensagemUsuario, $usuario['notion']);

        // } catch (Exception $e) {
        //     $this->enviarMensagemWhatsApp(json_encode($e->getMessage()));
        // }


        ChatbotInteracaoChat::create([
            'usuario_id' => $usuario['usuario_id'],
            'mensagem' => $this->mensagemUsuario,
            'message_id' => $data['message_id'],
            'data' => json_encode([$data]),
            'remetente' => 'user',
            'id_step' => $step['id'] ?? null,
            'status_mensagem' => 'enviado',
            'data_envio' => date('Y-m-d H:i:s')
        ]);

        if (!!$usuario['notBot']) {
            // $this->sendFCMNotificationUser($this->mensagemUsuario);

            if (!!$usuario['aguardando']) {
                ChatbotInteracaoUsuario::update([
                    'id_flow' => null,
                    'id_step' => null,
                    'aguardando' => 0,
                    'tipo_interacao_esperado' => ''
                ], $usuario['interacoes_id']);
            }
            return;
        }

        if (!($step['id'] ?? false)) {
            return;
        }
        if ($data['event_type'] == "interactive") {
            $data['event_type'] = "message_interactive";
        }
        if (!!$usuario['aguardando']) {
            $tipoInteracaoCorreta = $data['event_type'] == $usuario['tipo_interacao_esperado'];
            if ($tipoInteracaoCorreta) {
                $this->processarEtapa($usuario, $step, $data);
            } else {
                $this->enviarMensagemWhatsApp("Selecione uma opção válida");
            }
        }
        if ($this->stopStep) {
            return;
        }

        if ($this->updateStep) {

            if (!!$step['nome_campo']) {
                // ChatbotAtendimento::insertByNumeroCampoResposta($this->numeroUsuario, $step['nome_campo'], $data['message']);
            }
            $resultado = $this->obterUsuarioEEtapa();

            $step = $resultado['step'];
            $usuario = $resultado['usuario'];
        }

        $enviaremail = !$step['id_step_proximo'] && count($step['options']) == 0;

        if ($enviaremail) {
            // $this->enviarEmailAtendimentobyNumber($this->numeroUsuario, $usuario);
        }

        $step['pergunta'] = Helpers::convertHtmlToWhatsApp($step['pergunta']);
        $enviodeInteracao = false;
        switch ($step['tipo_interacao']) {
            case 'message_button':
                // Divide a string de perguntas em partes
                $perguntas = explode("|", $step['pergunta']);

                // Envia todas as perguntas, exceto a última
                for ($i = 0; $i < count($perguntas) - 1; $i++) {
                    if (!!trim($perguntas[$i])) {
                        $enviodeInteracao = true;
                        $this->enviarMensagemWhatsApp($perguntas[$i]);
                    }
                }

                // Envia a última pergunta com botões
                $ultimaPergunta = trim(end($perguntas)); // Obtém a última pergunta
                if (!!$ultimaPergunta) {
                    $enviodeInteracao = true;
                    // $this->enviarMensagemComBotoes($ultimaPergunta, $usuario['id_step']);
                }
                break;

            case 'message_interactive':
                $enviodeInteracao = true;
                // $this->enviarListaInterativaComDados(
                //     $usuario['id_step'],
                // );
                break;

            default:
                // Para outros tipos de interação, envia todas as perguntas
                $perguntas = explode("|", (trim($step['pergunta'], "|")));
                foreach ($perguntas as $perguntaIndividual) {
                    if (!!$perguntaIndividual) {
                        $this->enviarMensagemWhatsApp(trim($perguntaIndividual));
                        $enviodeInteracao = true;
                    }
                }
        }


        if ($enviodeInteracao) {
            if (isset($usuario['interacoes_id']))

                ChatbotInteracaoChat::create([
                    'usuario_id' => $usuario['usuario_id'],
                    'mensagem' => $step['pergunta'],
                    'remetente' => 'bot',
                    'status_mensagem' => 'enviado',
                    'id_step' => $usuario['id_step'],
                    'data_envio' => date('Y-m-d H:i:s')
                ]);
            if (!$enviaremail) {

                $interacaoUsuario = ChatbotInteracaoUsuario::find($usuario['interacoes_id']);
                if ($interacaoUsuario) {
                    $interacaoUsuario->update([
                        'aguardando' => 1,
                        'tipo_interacao_esperado' => $step['tipo_interacao']
                    ]);
                }
            }
        }

    }

    private function obterUsuarioEEtapa()
    {
        $usuario = ChatbotInteracaoUsuario::addUserAndInteraction($this->numeroUsuario, $this->nomeUsuario); // 0
        $step = ChatbotStep::with('options')->find($usuario['id_step'])->toArray();

        $step['nome_da_funcao'] = !empty($step['nome_da_funcao']) ? $step['nome_da_funcao'] : "proxima_etapa";

        return [
            'usuario' => $usuario,
            'step' => $step,
        ];
    }

    public function enviarMensagemWhatsApp($mensagem, $numero = null, $previewUrl = false)
    {
        if ($numero === null) {
            $numero = $this->numeroUsuario;
        }
        $this->whatsapp->sendMessageText($numero, $mensagem, $previewUrl);
    }

    public function processarEtapa($usuario, $step, $data)
    {
        switch ($data['event_type']) {
            case 'message_interactive':
            case 'message_button':
                $this->processarInteracaoEtapa($usuario, $step, $data);
                break;
            case 'message_text':
                $this->processarTextEtapa($usuario, $step, $data);
        }
    }
    //processarInteracaoEtapa
    public function processarInteracaoEtapa($usuario, $step, $data)
    {
        $interactive_id = $data['interactive_id'];

        // Filtrando as opções para verificar se a opção selecionada pelo usuário existe
        $resultado = array_filter($step['options'], function ($option) use ($interactive_id) {
            return $option['id'] == $interactive_id;
        });

        if (count($resultado) === 0) {
            $this->enviarMensagemWhatsApp("Você selecionou uma opção inválida.");
        } else {
            $id_step_proximo = ChatbotOption::where('id', $data['interactive_id'])
                ->first()['id_step_proximo'] ?? null;

            ChatbotInteracaoUsuario::updateStepById($usuario['interacoes_id'], $id_step_proximo);

            $this->updateStep = true;
        }
    }

    //processarTextEtapa
    public function processarTextEtapa($usuario, $step, $data)
    {

        if (function_exists($step['nome_da_funcao'])) {
            $step['step_id'] = $step['id'];
            unset($step['id']);
            $params = array_merge($step, $usuario);
            $params['data'] = $data;

            $resultado_validacao = call_user_func($step['nome_da_funcao'], $params);

            $this->stopStep = !$resultado_validacao['result'];

            if ($resultado_validacao['result']) {
                $id_step_proximo = $params['id_step_proximo'];
                ChatbotInteracaoUsuario::updateStepById($params['interacoes_id'], $id_step_proximo);
                $this->updateStep = true;
            } else {
                foreach ($resultado_validacao['message'] as $message) {
                    $this->enviarMensagemWhatsApp($message);
                }
            }
        }
    }


}
