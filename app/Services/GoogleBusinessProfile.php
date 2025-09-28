<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\MyBusinessAccountManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GoogleBusinessProfile
{
    /**
     * Cria e configura o cliente Google.
     */
    protected function makeClient(): GoogleClient
    {
        $user = Auth::user();

        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->setAccessType('offline');
        $client->setScopes(explode(' ', env('GOOGLE_SCOPES', 'https://www.googleapis.com/auth/business.manage')));

        // Define tokens atuais do usuário
        $client->setAccessToken([
            'access_token' => $user->google_access_token,
            'refresh_token' => $user->google_refresh_token,
            'expires_in' => max(1, Carbon::now()->diffInSeconds($user->google_token_expires_at ?? now())),
            'created' => time(),
        ]);

        // Se expirou, tenta refresh
        if ($client->isAccessTokenExpired() && $user->google_refresh_token) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);

            if (!empty($newToken['access_token'])) {
                $user->google_access_token = $newToken['access_token'];

                if (!empty($newToken['refresh_token'])) {
                    $user->google_refresh_token = $newToken['refresh_token'];
                }

                if (!empty($newToken['expires_in'])) {
                    $user->google_token_expires_at = now()->addSeconds($newToken['expires_in']);
                }

                $user->save();
                $client->setAccessToken($newToken);
            }
        }

        return $client;
    }

    /**
     * Busca todas as avaliações (reviews) do Google Business.
     */
    public function getAllReviews(): array
    {
        try {
            $client = $this->makeClient();

            $myBusiness = new MyBusinessAccountManagement($client);
            $accounts = $myBusiness->accounts->listAccounts();

            $allReviews = [];

            foreach ($accounts->getAccounts() ?? [] as $account) {
                // Listar locais (locations)
                $locations = $myBusiness->accounts_locations->listAccountsLocations(
                    $account->getName(),
                    ['pageSize' => 100]
                );

                foreach ($locations->getLocations() ?? [] as $location) {
                    // Listar reviews do local
                    $reviews = $myBusiness->accounts_locations_reviews->listAccountsLocationsReviews(
                        $location->getName(),
                        ['pageSize' => 100]
                    );

                    foreach ($reviews->getReviews() ?? [] as $r) {
                        $allReviews[] = [
                            'account' => $account->getName(),
                            'location' => $location->getName(),
                            'reviewId' => $r->getName(),
                            'reviewer' => $r->getReviewer()?->getDisplayName(),
                            'starRating' => $r->getStarRating(),
                            'comment' => $r->getComment(),
                            'createTime' => $r->getCreateTime(),
                            'updateTime' => $r->getUpdateTime(),
                            'reviewReply' => $r->getReviewReply()?->getComment(),
                            'replyUpdate' => $r->getReviewReply()?->getUpdateTime(),
                        ];
                    }
                }
            }

            // Salvar no storage/app
            $fileName = 'google_reviews_' . now()->format('Ymd_His') . '.json';
            Storage::put($fileName, json_encode($allReviews, JSON_PRETTY_PRINT));

            return $allReviews;

        } catch (\Google\Service\Exception $e) {
            if ($e->getCode() === 429) {

                dd($e);
                // Quota exceeded
                return [];
            }
            throw $e;
        }
    }
}
