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
            // espera cada botão no formato ['type'=>'reply','reply'=>['id'=>..., 'title'=>...]]
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
        // sections: array of ['title'=> 'Secao', 'rows' => [['id'=>'1','title'=>'Item','description'=>'...']]]
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


    protected function sendRequest($data)
    {
        $url = "https://graph.facebook.com/{$this->apiVersion}/{$this->phoneId}/messages";

        $response = Http::withHeaders([
            "Authorization" => "Bearer {$this->token}",
            "Content-Type" => "application/json",
        ])->post($url, $data);

        return $response->json();
    }
}