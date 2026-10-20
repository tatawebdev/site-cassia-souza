<?php

namespace App\Http\Controllers;

use App\Models\FcmToken;
use App\Services\FcmService;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    /**
     * Visitante do site que aceitou os avisos de artigos novos (rota pública).
     */
    public function store(Request $request)
    {
        return $this->salvar($request, FcmToken::SITE);
    }

    /**
     * Navegador do painel, para as mensagens do chat (rota com login: o chat
     * traz conversas de clientes e não pode chegar a quem só visita o site).
     */
    public function storePainel(Request $request)
    {
        return $this->salvar($request, FcmToken::PAINEL);
    }

    private function salvar(Request $request, string $publico)
    {
        $data = $request->validate([
            'token' => 'required|string|max:500',
        ]);

        // Token morto (o navegador guardou um antigo): não grava e pede um novo
        if (app(FcmService::class)->tokenValido($data['token']) === false) {
            return response()->json(['status' => 'token_invalido'], 410);
        }

        FcmToken::firstOrCreate(['token' => $data['token'], 'publico' => $publico]);

        return response()->json(['status' => 'ok']);
    }
}
