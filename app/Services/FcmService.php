<?php

namespace App\Services;

use App\Models\FcmToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Notificações no navegador pelo Firebase Cloud Messaging (API HTTP v1).
 * Autentica com o JSON da conta de serviço do projeto (config services.fcm).
 */
class FcmService
{
    /**
     * Envia para todos os tokens de um público (FcmToken::PAINEL ou ::SITE) e
     * apaga os que o Google diz que não existem mais.
     *
     * @return array{enviados: int, falhas: int, resultados: array} resultados por token (ver sendNotificationToTokens)
     */
    public function enviarPara(string $publico, string $title, string $body, array $data = [], ?string $link = null): array
    {
        $tokens = FcmToken::where('publico', $publico)->pluck('token')->all();
        $results = $this->sendNotificationToTokens($tokens, $title, $body, $data, $link);

        $invalidos = array_keys(array_filter($results, fn ($r) => $r['invalido'] ?? false));
        if ($invalidos) {
            FcmToken::where('publico', $publico)->whereIn('token', $invalidos)->delete();
        }

        $enviados = count(array_filter($results, fn ($r) => $r['ok']));

        return ['enviados' => $enviados, 'falhas' => count($results) - $enviados, 'resultados' => $results];
    }

    /**
     * Confere com o Google, sem mostrar nada ao usuário (validate_only), se o
     * token ainda vale. O SDK do navegador guarda o token por dias e pode
     * devolver um que já morreu. Null quando não deu para conferir.
     */
    public function tokenValido(string $token): ?bool
    {
        try {
            $resultado = $this->sendNotificationToTokens([$token], 'teste', 'teste', [], null, true)[$token];
        } catch (\Exception $e) {
            Log::warning('Token FCM não conferido: ' . $e->getMessage());
            return null;
        }

        return $resultado['ok'] ? true : (($resultado['invalido'] ?? false) ? false : null);
    }

    /**
     * @return array Respostas por token: ok, status e se o token é inválido
     * @throws \Exception sem a conta de serviço ou sem conseguir autenticar
     */
    public function sendNotificationToTokens(array $tokens, string $title, string $body, array $data = [], ?string $link = null, bool $soValidar = false): array
    {
        if (empty($tokens)) {
            return [];
        }

        $serviceAccountPath = $this->serviceAccountPath();
        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $projectId = $serviceAccount['project_id'] ?? null;
        if (empty($projectId)) {
            throw new \Exception('project_id not found in service account JSON');
        }

        $accessToken = $this->getAccessToken($serviceAccountPath);
        if (empty($accessToken)) {
            throw new \Exception('Failed to obtain access token for FCM HTTP v1');
        }

        if ($link) {
            // Aviso com link (artigos): só dados, e o service worker monta a
            // notificação. Com "notification", o SDK do Firebase não mostra nada
            // quando há uma aba do site aberta em foco, só repassa à página.
            $mensagem = [
                'data' => ['aviso_titulo' => $title, 'aviso_texto' => $body, 'aviso_link' => $link] + $data,
                'webpush' => ['headers' => ['Urgency' => 'high', 'TTL' => '86400']],
            ];
        } else {
            $mensagem = [
                'notification' => ['title' => $title, 'body' => $body],
                'webpush' => ['notification' => ['icon' => url('/favicon-192x192.png')]],
            ];
            if (! empty($data)) {
                $mensagem['data'] = $data;
            }
        }
        // O FCM só aceita textos nos dados
        if (isset($mensagem['data'])) {
            $mensagem['data'] = array_map(fn ($v) => is_string($v) ? $v : json_encode($v), $mensagem['data']);
        }

        $results = [];
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        foreach ($tokens as $token) {
            $response = Http::withToken($accessToken)
                ->timeout(10)
                ->post($url, ['message' => ['token' => $token] + $mensagem] + ($soValidar ? ['validate_only' => true] : []));

            if ($response->successful()) {
                $results[$token] = ['ok' => true, 'status' => $response->status()];
                continue;
            }

            // 404 UNREGISTERED: o navegador cancelou a inscrição.
            // 400 com token mal formado: não adianta tentar de novo.
            $invalido = $response->status() === 404
                || ($response->status() === 400 && str_contains($response->body(), 'registration token'));

            if (! $invalido) {
                Log::error('FCM v1 send failed', ['status' => $response->status(), 'body' => $response->body()]);
            }
            $results[$token] = ['ok' => false, 'status' => $response->status(), 'invalido' => $invalido];
        }

        return $results;
    }

    protected function serviceAccountPath(): string
    {
        $caminho = config('services.fcm.credentials_path');
        if (! file_exists($caminho) && file_exists(storage_path('app/fcm.json'))) {
            $caminho = storage_path('app/fcm.json');
        }
        if (! file_exists($caminho)) {
            throw new \Exception('Service account file not found at: ' . $caminho);
        }

        return $caminho;
    }

    /**
     * Obtain OAuth2 access token for service account using JWT assertion.
     * Caches token in the application cache for its lifetime minus a small buffer.
     */
    protected function getAccessToken(string $serviceAccountPath): ?string
    {
        $cacheKey = 'fcm_access_token_' . md5($serviceAccountPath);

        $cached = Cache::get($cacheKey);
        if (! empty($cached['access_token']) && ($cached['expires_at'] ?? 0) > time()) {
            return $cached['access_token'];
        }

        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $clientEmail = $serviceAccount['client_email'] ?? null;
        $privateKey = $serviceAccount['private_key'] ?? null;
        if (! $clientEmail || ! $privateKey) {
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

        $base64Url = fn ($str) => rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
        $assertion = $base64Url(json_encode(['alg' => 'RS256', 'typ' => 'JWT'])) . '.' . $base64Url(json_encode($claims));

        $signature = '';
        openssl_sign($assertion, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $assertion .= '.' . $base64Url($signature);

        $resp = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $assertion,
        ]);

        if ($resp->failed()) {
            Log::error('Failed to obtain FCM access token', ['status' => $resp->status(), 'body' => $resp->body()]);
            return null;
        }

        $accessToken = $resp->json('access_token');
        $expiresIn = $resp->json('expires_in', 3600);
        if ($accessToken) {
            Cache::put($cacheKey, ['access_token' => $accessToken, 'expires_at' => time() + $expiresIn - 60], $expiresIn);
            return $accessToken;
        }

        return null;
    }
}
