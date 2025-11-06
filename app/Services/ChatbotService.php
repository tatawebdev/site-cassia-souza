<?php

namespace App\Services\Legacy;

use App\Models\Legacy\ChatbotInteracoesUsuario;
use App\Models\Legacy\ChatbotInteracoesChat;
use App\Models\Legacy\ChatbotAtendimento;
use App\Models\Legacy\ChatbotSteps;
use App\Models\Legacy\ChatbotOptions;
use App\Models\Legacy\ChatboConfigMessageInteractive;
use App\Models\Legacy\Users as LegacyUsers;
use App\Services\GeminiService;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

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

        ChatbotInteracoesChat::insert([
            'usuario_id' => $usuario['usuario_id'],
            'mensagem' => $this->mensagemUsuario,
            'message_id' => $this->mensagemId,
            'data' => json_encode([$data]),
            'remetente' => 'user',
            'id_step' => $step['id'] ?? null,
            'status_mensagem' => 'enviado',
            'data_envio' => date('Y-m-d H:i:s')
        ]);




    }

    private function obterUsuarioEEtapa()
    {
        $usuario = ChatbotInteracoesUsuario::addUserAndInteraction($this->numeroUsuario, $this->nomeUsuario);


        dd($usuario);
        $step = (new ChatbotSteps)->getStepById($usuario['id_step']);
        $step = $step ?? [];

        $step['nome_da_funcao'] = !empty($step['nome_da_funcao']) ? $step['nome_da_funcao'] : "proxima_etapa";

        return [
            'step' => $step,
            'usuario' => $usuario
        ];
    }



}
