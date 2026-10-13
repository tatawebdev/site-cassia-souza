<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

/** Confere no Google a resposta do reCAPTCHA v2 enviada pelo formulário. */
class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $ok = Http::asForm()->timeout(10)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $value,
                'remoteip' => request()->ip(),
            ])->json('success') === true;
        } catch (\Throwable $e) {
            report($e);
            $ok = false;
        }

        if (! $ok) {
            $fail('Não foi possível confirmar que você não é um robô. Marque a caixa novamente.');
        }
    }
}
