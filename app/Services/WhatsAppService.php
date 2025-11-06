<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $token;
    protected $phoneId;
    protected $apiPhoneNumber;
    protected $apiVersion;

    public function __construct()
    {
        $this->token = config('whatsapp.token');
        $this->phoneId = config('whatsapp.phone_id');
        $this->apiPhoneNumber = config('whatsapp.api_phone_number');
        $this->apiVersion = config('whatsapp.api_version');
    }

    public function sendMessageText($recipientNumber, $text, $previewUrl = true)
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $recipientNumber,
            'type' => 'text',
            'text' => [
                'preview_url' => $previewUrl,
                'body' => $text,
            ],
        ];

        return $this->sendRequest($payload);
    }

    public function sendButtonMessage($recipientNumber, string $text, array $buttons = [])
    {
        $actionButtons = [];
        foreach ($buttons as $b) {
            $actionButtons[] = $b;
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $recipientNumber,
            'type' => 'interactive',
            'interactive' => [
                'type' => 'button',
                'body' => ['text' => $text],
                'action' => [
                    'buttons' => $actionButtons,
                ],
            ],
        ];

        return $this->sendRequest($payload);
    }

    public function sendListMessage($recipientNumber, string $title, string $bodyText, string $footerText, array $sections = [], string $buttonText = 'Ver opções')
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $recipientNumber,
            'type' => 'interactive',
            'interactive' => [
                'type' => 'list',
                'header' => ['type' => 'text', 'text' => $title],
                'body' => ['text' => $bodyText],
                'footer' => ['text' => $footerText],
                'action' => [
                    'button' => $buttonText,
                    'sections' => $sections,
                ],
            ],
        ];

        return $this->sendRequest($payload);
    }


    public function sendInteractiveMessage($recipientNumber, array $messageData)
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $recipientNumber,
            'type' => 'interactive',
            'interactive' => $messageData,
        ];

        return $this->sendRequest($payload);
    }


    protected function sendRequest($data)
    {
        $url = "https://graph.facebook.com/{$this->apiVersion}/{$this->phoneId}/messages";

        $response = Http::withHeaders([
            "Authorization" => "Bearer {$this->token}",
            "Content-Type" => "application/json",
        ])->post($url, $data);

        $result = $response->json();

        if ($response->failed() && isset($result['error'])) {
            // Store or log the error as needed, here we just return it
            abort(500, 'WhatsApp API Error: ' . json_encode($result['error']));
                
        }

        return $result;
    }
}