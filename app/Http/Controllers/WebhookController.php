<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppWebhookProcessor; 
use App\Models\Conversation;
use App\Models\Message;
use App\Services\AgenteSuporte;
use App\Services\Legacy\NewChatbotService;

class WebhookController extends Controller
{
    public function handle(Request $request, AgenteSuporte $agenteSuporte, NewChatbotService $newChatbot)
    {
        $webhookData = $request->all();


        dd($webhookData);
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

        return response()->json(['status' => 'ok']);
    }
}