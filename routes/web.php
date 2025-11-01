<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewsController;
use App\Services\PlacesService;

Route::get('/', \App\Livewire\Index::class)->name('inicio');
Route::get('/sobre-nos', \App\Livewire\About::class)->name('sobre');
Route::get('/contato', \App\Livewire\Contact::class)->name('contato');
Route::get('/servicos', \App\Livewire\Servicos::class)->name('servicos');

Route::get('/servicos/consultoria-tributaria', \App\Livewire\Servicos\ConsultoriaTributaria::class)->name('servicos.consultoria.tributaria');
Route::get('/servicos/regularizacao-debitos-pgfn', \App\Livewire\Servicos\RegularizacaoDebitosPGFN::class)->name('servicos.regularizacao.debitos.pgfn');
Route::get('/servicos/planejamento-tributario', \App\Livewire\Servicos\PlanejamentoTributario::class)->name('servicos.planejamento.tributario');
Route::get('/servicos/planejamento-tributario-clinicas', \App\Livewire\Servicos\PlanejamentoClinicas::class)->name('servicos.planejamento.tributario.clinicas');
Route::get('/servicos/assessoria-reforma-tributaria', \App\Livewire\Servicos\AssessoriaReformaTributaria::class)->name('servicos.assessoria.reforma.tributaria');
Route::get('/servicos/treinamento-tributario', \App\Livewire\Servicos\TreinamentoTributario::class)->name('servicos.treinamento.tributario');
Route::get('/servicos/recuperacao-pis-cofins-monofasicos', \App\Livewire\Servicos\RecuperacaoPISCOFINS::class)->name('servicos.recuperacao.pis.cofins.monofasicos');

Route::get('/auth/google/redirecionar', [GoogleAuthController::class, 'redirect'])->name('google.redirecionar');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::get('/get/comentarios', [ReviewsController::class, 'index'])->name('reviews.export');

Route::get('/conectar-google', fn() => redirect()->route('google.redirect'))->name('google.connect');

Route::get('/get/places-reviews/{placeId}', function (Request $request, PlacesService $places, $placeId) {
    $result = $places->getPlaceDetails($placeId);
    if (!$result) {
        return response('Não foi possível obter detalhes do local.', 404);
    }
    $filename = 'places_reviews_' . now()->format('Ymd_His') . '.txt';
    $places->saveReviewsTxt($result, $filename);
    return response()->download(storage_path('app/'.$filename));
});

Route::get('/get/mocked-reviews', function (PlacesService $places) {
    $reviews = $places->getMockedReviews();
    $lines = [];
    $lines[] = 'autor | perfil | estrelas | data | comentário | resposta';
    foreach ($reviews as $r) {
        $lines[] = implode(' | ', [
            $r['author_name'],
            $r['profile'],
            str_repeat('★', $r['rating']),
            $r['date'],
            str_replace(["\r","\n","|"], [' ',' ','/'], $r['text']),
            str_replace(["\r","\n","|"], [' ',' ','/'], $r['reply'] ?? ''),
        ]);
    }
    $filename = 'mocked_reviews_' . now()->format('Ymd_His') . '.txt';
    \Illuminate\Support\Facades\Storage::disk('local')->put($filename, implode(PHP_EOL, $lines));
    return response()->download(storage_path('app/'.$filename));
});


Route::get('/download/review-images', function (PlacesService $places) {
    $reviews = $places->getMockedReviews();
    $images = [];

    foreach ($reviews as $index => $review) {
        if (!empty($review['photo_url'])) {
            $imageContent = file_get_contents($review['photo_url']);
            if ($imageContent !== false) {
                $filename = 'image_' . ($review['id']) . '.jpg';
                \Illuminate\Support\Facades\Storage::disk('local')->put($filename, $imageContent);
                $images[] = storage_path('app/' . $filename);
            }
        }
    }

    if (empty($images)) {
        return response('Nenhuma imagem encontrada para download.', 404);
    }

    return response()->json([
        'message' => 'Imagens salvas com sucesso.',
        'files' => $images,
    ]);
})->name('download.review.images');


Route::get('/download/review-images2', function (PlacesService $places) {
    $reviews = $places->getMockedReviews();
    $zip = new \ZipArchive();
    $zipFilename = storage_path('app/review_images_' . now()->format('Ymd_His') . '.zip');

    if ($zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
        foreach ($reviews as $index => $review) {
            if (!empty($review['photo_url'])) {
                $imageContent = file_get_contents($review['photo_url']);
                if ($imageContent !== false) {
                    $zip->addFromString('image_' . ($index + 1) . '.jpg', $imageContent);
                }
            }
        }
        $zip->close();
    }

    return response()->download($zipFilename)->deleteFileAfterSend(true);
})->name('download.review.images');
