<?php

namespace App\Http\Controllers;

use App\Models\FcmAviso;
use App\Services\AvisoArtigo;
use Illuminate\Http\Request;

/**
 * Chamado pelo blog (functions.php do tema) quando um post é publicado: avisa os
 * inscritos no navegador e por e-mail. Cada endereço é avisado uma vez só. O envio
 * roda depois da resposta, porque produção não tem fila e o WordPress não deve esperar.
 */
class FcmAvisoController extends Controller
{
    public function store(Request $request, AvisoArtigo $avisoArtigo)
    {
        $chave = config('services.fcm.chave_avisos');
        if (! $chave || ! hash_equals($chave, (string) $request->header('X-Chave-Avisos'))) {
            abort(403);
        }

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'url' => ['required', 'url', 'max:500', 'starts_with:https://blog.cassiasouzaadvocacia.com.br/'],
            'resumo' => 'nullable|string|max:2000',
            'imagem' => 'nullable|url|max:500',
            'categoria' => 'nullable|string|max:255',
        ]);

        $aviso = FcmAviso::firstOrCreate(['url' => $data['url']], $data);
        if (! $aviso->wasRecentlyCreated) {
            return response()->json(['status' => 'ja_avisado']);
        }

        dispatch(fn () => $avisoArtigo->enviar($aviso))->afterResponse();

        return response()->json(['status' => 'enviando']);
    }
}
