<?php

namespace App\Http\Controllers;

use App\Rules\Recaptcha;
use App\Services\Newsletter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/** Inscrição na newsletter vinda do blog (modal de saída). */
class NewsletterApiController extends Controller
{
    public function store(Request $request, Newsletter $newsletter): JsonResponse
    {
        $regras = ['email' => 'required|email|max:255'];

        if (config('services.recaptcha.site_key')) {
            $regras['recaptcha'] = ['required', new Recaptcha()];
        }

        $dados = $request->validate($regras, [
            'email.required' => 'Informe seu e-mail.',
            'email.email' => 'Esse e-mail não parece válido.',
            'recaptcha.required' => 'Confirme que você não é um robô.',
        ]);

        $resultado = $newsletter->inscrever($dados['email'], 'blog');

        return response()->json([
            'status' => $resultado,
            'mensagem' => $resultado === Newsletter::JA_INSCRITO
                ? 'Este e-mail já está inscrito. Obrigado!'
                : 'Inscrição feita! Você vai receber nossas novidades.',
        ]);
    }
}
