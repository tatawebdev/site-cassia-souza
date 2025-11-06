<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    /**
     * Send notification to a list of tokens using the legacy FCM HTTP API.
     * Requires FCM_SERVER_KEY in .env (server key).
     *
     * @param array $tokens
     * @param string $title
     * @param string $body
     * @param array $data
     * @return array|null
     */
    public function sendNotificationToTokens(array $tokens, string $title, string $body, array $data = [])
    {
        $serverKey = env('FCM_SERVER_KEY');
        if (empty($serverKey)) {
            Log::warning('FCM_SERVER_KEY not set; skipping push send.');
            return null;
        }

        if (empty($tokens)) {
            Log::info('No FCM tokens to send to.');
            return null;
        }

        $payload = [
            'registration_ids' => array_values($tokens),
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => $data,
            'priority' => 'high'
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', $payload);

            if ($response->failed()) {
                Log::error('FCM send failed', ['status' => $response->status(), 'body' => $response->body()]);
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error sending FCM notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Read tokens from storage file and send notification to all.
     * File path: storage/app/fcm_tokens.json
     */
    public function sendNotificationToAll(string $title, string $body, array $data = [])
    {
        $file = storage_path('app/fcm_tokens.json');
        $tokens = [];
        if (file_exists($file)) {
            $tokens = json_decode(file_get_contents($file), true) ?? [];
        }

        return $this->sendNotificationToTokens($tokens, $title, $body, $data);
    }
}
