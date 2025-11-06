<?php

namespace App\Services;

use App\Services\GeminiService;
use App\Services\WhatsAppService;

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




    }

    private function obterUsuarioEEtapa()
    {

    }



}
