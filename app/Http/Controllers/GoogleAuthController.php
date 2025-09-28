<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        $scopes = explode(' ', config('app.google_scopes', env('GOOGLE_SCOPES', 'https://www.googleapis.com/auth/business.manage')));
        return Socialite::driver('google')
            ->scopes($scopes)
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Tenta encontrar usuário pelo email do Google
        $user = \App\Models\User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Cria novo usuário
            $user = \App\Models\User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                // Defina uma senha padrão ou gere uma aleatória
                'password' => bcrypt(str()->random(16)),
            ]);
        }

        // Atualiza tokens do Google
        $user->google_access_token = $googleUser->token;
        $user->google_refresh_token = $googleUser->refreshToken ?? null;
        $user->google_token_expires_at = now()->addSeconds($googleUser->expiresIn ?? 3600);
        $user->save();

        // Faz login do usuário
        Auth::login($user);

        return redirect('/get/comentarios')->with('success', 'Google conectado com sucesso.');
    }
}
