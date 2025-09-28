<?php
namespace App\Http\Controllers;

use App\Services\GoogleBusinessProfile;
use Illuminate\Support\Facades\Storage;

class ReviewsController extends Controller
{
    public function index(GoogleBusinessProfile $gbp)
    {

        $reviews = $gbp->getAllReviews();

        $lines = [];
        $lines[] = 'account | location | createTime | rating | reviewer | comment | reply';
        foreach ($reviews as $r) {
            $lines[] = implode(' | ', [
                $r['account'],
                $r['location'],
                $r['createTime'],
                $r['starRating'],
                $r['reviewer'],
                str_replace(["\r", "\n", "|"], [' ', ' ', '/'], $r['comment'] ?? ''),
                str_replace(["\r", "\n", "|"], [' ', ' ', '/'], $r['reviewReply'] ?? ''),
            ]);
        }

        $filename = 'google_reviews_' . now()->format('Ymd_His') . '.txt';
        Storage::disk('local')->put($filename, implode(PHP_EOL, $lines));

        return response()->download(storage_path('app/' . $filename));
    }
}
