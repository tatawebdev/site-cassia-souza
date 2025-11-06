<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

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
    /**
     * Send notification to a list of tokens using the FCM HTTP v1 API.
     * This implementation obtains an OAuth2 access token from a Service Account
     * (file path configured in FCM_SERVICE_ACCOUNT or defaults to storage/app/fcm.json)
     * and sends a message to each token (reusing the same access token).
     *
     * @param array $tokens
     * @param string $title
     * @param string $body
     * @param array $data
     * @return array Array of responses keyed by token
     * @throws \Exception
     */
    public function sendNotificationToTokens(array $tokens, string $title, string $body, array $data = [])
    {
        if (empty($tokens)) {
            Log::info('No FCM tokens to send to.');
            return [];
        }

        $serviceAccountPath = env('FCM_SERVICE_ACCOUNT', storage_path('app/fcm.json'));

        if (!file_exists($serviceAccountPath)) {
            throw new \Exception('Service account file not found at: ' . $serviceAccountPath);
        }

        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $projectId = $serviceAccount['project_id'] ?? null;
        if (empty($projectId)) {
            throw new \Exception('project_id not found in service account JSON');
        }

        $accessToken = $this->getAccessToken($serviceAccountPath);
        if (empty($accessToken)) {
            throw new \Exception('Failed to obtain access token for FCM HTTP v1');
        }

        $results = [];
        $urlBase = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        foreach ($tokens as $token) {
            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ],
            ];

            if (!empty($data)) {
                // FCM expects string values for data
                $strData = [];
                foreach ($data as $k => $v) {
                    $strData[$k] = is_string($v) ? $v : json_encode($v);
                }
                $payload['message']['data'] = $strData;
            }

            $response = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($urlBase, $payload);

            if ($response->failed()) {
                Log::error('FCM v1 send failed', ['token' => $token, 'status' => $response->status(), 'body' => $response->body()]);
                $results[$token] = ['ok' => false, 'status' => $response->status(), 'body' => $response->body()];
            } else {
                $results[$token] = ['ok' => true, 'response' => $response->json()];
            }
        }

        return $results;
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

    /**
     * Obtain OAuth2 access token for service account using JWT assertion.
     * Caches token in the application cache for its lifetime minus a small buffer.
     *
     * @param string|null $serviceAccountPath
     * @return string|null
     */
    protected function getAccessToken(string $serviceAccountPath = null)
    {
        $serviceAccountPath = $serviceAccountPath ?: env('FCM_SERVICE_ACCOUNT', storage_path('app/fcm.json'));
        $cacheKey = 'fcm_access_token_' . md5($serviceAccountPath);

        // Return cached token if available
        $cached = Cache::get($cacheKey);
        if (!empty($cached) && isset($cached['access_token']) && isset($cached['expires_at']) && $cached['expires_at'] > time()) {
            return $cached['access_token'];
        }

        if (!file_exists($serviceAccountPath)) {
            Log::error('FCM service account file not found: ' . $serviceAccountPath);
            return null;
        }

        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $clientEmail = $serviceAccount['client_email'] ?? null;
        $privateKey = $serviceAccount['private_key'] ?? null;
        if (!$clientEmail || !$privateKey) {
            Log::error('Invalid service account JSON for FCM');
            return null;
        }

        $now = time();
        $claims = [
            'iss' => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ];

        $jwtHeader = ['alg' => 'RS256', 'typ' => 'JWT'];
        $base64Url = function ($str) {
            return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
        };

        $assertion = $base64Url(json_encode($jwtHeader)) . '.' . $base64Url(json_encode($claims));

        // Sign assertion
        $signature = '';
        openssl_sign($assertion, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $assertion .= '.' . $base64Url($signature);

        // Request token
        $resp = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $assertion,
        ]);

        if ($resp->failed()) {
            Log::error('Failed to obtain FCM access token', ['status' => $resp->status(), 'body' => $resp->body()]);
            return null;
        }

        $data = $resp->json();
        $accessToken = $data['access_token'] ?? null;
        $expiresIn = $data['expires_in'] ?? 3600;
        if ($accessToken) {
            $expiresAt = time() + $expiresIn - 60; // buffer
            Cache::put($cacheKey, ['access_token' => $accessToken, 'expires_at' => $expiresAt], $expiresIn / 60);
            return $accessToken;
        }

        return null;
    }
}
