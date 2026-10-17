<?php

namespace App\Http\Controllers;

use App\Models\FcmToken;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    /**
     * Store FCM token in database and fallback file.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string',
        ]);

        $token = $data['token'];

        try {
            FcmToken::firstOrCreate(
                ['token' => $token],
                [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]
            );
        } catch (\Exception $e) {
            logger()->error('Erro ao salvar FCM token no banco: ' . $e->getMessage());
        }

        $file = storage_path('app/fcm_tokens.json');
        try {
            $tokens = [];
            if (file_exists($file)) {
                $tokens = json_decode(file_get_contents($file), true) ?? [];
            }

            if (!in_array($token, $tokens)) {
                $tokens[] = $token;
                file_put_contents($file, json_encode($tokens, JSON_PRETTY_PRINT));
            }
        } catch (\Exception $e) {
            logger()->error('Erro ao salvar FCM token em arquivo: ' . $e->getMessage());
        }

        return response()->json(['status' => 'ok']);
    }
}
