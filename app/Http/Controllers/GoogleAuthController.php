<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /** Redirect the user to Google's OAuth page */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /** Obtain the user information from Google and log them in */
    public function callback(Request $request)
    {
        // Using stateless in case the frontend is SPA-like; change if you rely on session state.
        $googleUser = Socialite::driver('google')->stateless()->user();

        if (! $googleUser || ! $googleUser->getEmail()) {
            return redirect()->route('login')->with('status', 'Não foi possível obter dados do Google.');
        }

        $email = $googleUser->getEmail();

        // Domain whitelist (CSV) - configure GOOGLE_ALLOWED_DOMAINS in .env (ex: cassiasouzaadvocacia.com,example.com)
        $allowedDomains = array_filter(array_map('trim', explode(',', env('GOOGLE_ALLOWED_DOMAINS', ''))));

        if (! empty($allowedDomains)) {
            $parts = explode('@', $email);
            $domain = strtolower($parts[1] ?? '');
            if (! in_array($domain, array_map('strtolower', $allowedDomains), true)) {
                return redirect()->route('login')->with('status', 'A conta Google usada não pertence a um domínio autorizado.');
            }
        }

        $user = User::where('email', $email)->first();

        // If user doesn't exist, create one only if allowedDomains is empty or domain allowed (already checked)
        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? $email,
                'email' => $email,
                // generate a random password (user logs in via Google)
                'password' => Str::random(40),
            ]);
        }

        // Save tokens for future API calls (nullable)
        $user->google_access_token = $googleUser->token ?? null;
        $user->google_refresh_token = $googleUser->refreshToken ?? null;
        if (! empty($googleUser->expiresIn)) {
            $user->google_token_expires_at = now()->addSeconds($googleUser->expiresIn);
        }
        $user->save();

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }
}




