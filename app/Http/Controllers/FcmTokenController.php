<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    /**
     * Store FCM token (simple file-based persistence).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string',
        ]);

        $token = $data['token'];

        $file = storage_path('app/fcm_tokens.json');
        $tokens = [];
        if (file_exists($file)) {
            $tokens = json_decode(file_get_contents($file), true) ?? [];
        }

        if (!in_array($token, $tokens)) {
            $tokens[] = $token;
            file_put_contents($file, json_encode($tokens, JSON_PRETTY_PRINT));
        }

        return response()->json(['status' => 'ok']);
    }
}
