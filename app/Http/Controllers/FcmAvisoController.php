<?php

namespace App\Http\Controllers;

use App\Models\FcmAviso;
use App\Services\FcmService;
use Illuminate\Http\Request;

/**
 * Chamado pelo blog (functions.php do tema) quando um post é publicado: avisa os
 * inscritos do site. Cada endereço é avisado uma vez só. O envio roda depois da
 * resposta, porque produção não tem fila e o WordPress não deve esperar.
 */
class FcmAvisoController extends Controller
{
    public function store(Request $request, FcmService $fcm)
    {
        $chave = config('services.fcm.chave_avisos');
        if (! $chave || ! hash_equals($chave, (string) $request->header('X-Chave-Avisos'))) {
            abort(403);
        }

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'url' => ['required', 'url', 'max:500', 'starts_with:https://blog.cassiasouzaadvocacia.com.br/'],
        ]);

        $aviso = FcmAviso::firstOrCreate(['url' => $data['url']], ['titulo' => $data['titulo']]);
        if (! $aviso->wasRecentlyCreated) {
            return response()->json(['status' => 'ja_avisado']);
        }

        dispatch(fn () => $fcm->avisarArtigo($aviso))->afterResponse();

        return response()->json(['status' => 'enviando']);
    }
}
