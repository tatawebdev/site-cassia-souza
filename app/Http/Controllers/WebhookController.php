<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Services\WhatsAppWebhookProcessor;
use App\Models\Conversation;
use App\Models\Message;
use App\Services\AgenteSuporte;
use App\Services\Legacy\NewChatbotService;

class WebhookController extends Controller
{

    public $withCache = false;
    public function handle(Request $request, AgenteSuporte $agenteSuporte, NewChatbotService $newChatbot)
    {
        $webhookData = $request->all();
        $filePath = storage_path('app/webhook_data.json');
        file_put_contents($filePath, json_encode($webhookData, JSON_PRETTY_PRINT));

        $this->processWebhookData($webhookData, $agenteSuporte, $newChatbot);

        return response()->json([
            'status' => 'ok',
            'file' => $filePath
        ]);
    }


    private function processWebhookData($webhookData, $agenteSuporte, $newChatbot)
    {
        $processor = new WhatsAppWebhookProcessor();
        $result = $processor->process($webhookData);

        // Sempre grava na conversa interna
        if ($result['event_type'] == 'message_text' && isset($result['celular'])) {
            $celular = $result['celular'];
            $mensagem = $result['message'];

            $conversation = Conversation::firstOrCreate(
                ['phone' => $celular],
                ['last_message_at' => now(), 'status' => 'active']
            );

            $conversation->messages()->create([
                'sender' => 'user',
                'content' => $mensagem,
                'type' => 'text',
            ]);

            // Enfileira resposta do agente humano
            $agenteSuporte->replyToMessage($conversation);
        }

        // Encaminha ao chatbot legacy (novo serviço) para processar lógica do fluxo
        if (in_array($result['event_type'], ['message_text', 'message_button', 'interactive'])) {
            $payload = [
                'celular' => $result['celular'],
                'message' => $result['message'],
                'message_id' => $result['message_id'] ?? null,
                'name' => $result['name'] ?? null,
                'event_type' => $result['event_type'],
                'interactive_id' => $result['interactive_id'] ?? null,
            ];

            $newChatbot->processInput($payload);
        }
    }

    public function teste()
    {
        $filePath = storage_path('app/webhook_data.json');
        $webhookData = json_decode(file_get_contents($filePath), true);
dd($filePath);
        if ($webhookData) {
            $agenteSuporte = app(AgenteSuporte::class);
            $newChatbot = app(NewChatbotService::class);
            $this->processWebhookData($webhookData, $agenteSuporte, $newChatbot);
            return response()->json(['status' => 'processed']);
        } else {
            return response()->json(['error' => 'No webhook data found'], 404);
        }
    }

}