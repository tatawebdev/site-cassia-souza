<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewsController;
use App\Services\PlacesService;

Route::get('/', \App\Livewire\Index::class);
Route::get('/about', \App\Livewire\About::class);
Route::get('/blog-details2', \App\Livewire\BlogDetails2::class);
Route::get('/booking', \App\Livewire\Booking::class);
Route::get('/confirmation', \App\Livewire\Confirmation::class);
Route::get('/rooms-details', \App\Livewire\RoomsDetails::class);
Route::get('/rooms2', \App\Livewire\Rooms2::class);
Route::get('/blog-details', \App\Livewire\BlogDetails::class);
Route::get('/blog', \App\Livewire\Blog::class);
Route::get('/checkout', \App\Livewire\Checkout::class);
Route::get('/contact', \App\Livewire\Contact::class);
Route::get('/index2', \App\Livewire\Index2::class);
Route::get('/rooms', \App\Livewire\Rooms::class);

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
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
