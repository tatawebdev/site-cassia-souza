{{-- Página de erro do tema novo (403, 419, 429, 500, 503). Layout enxuto, sem
     banco de dados, Livewire nem formulários: precisa funcionar justamente
     quando algo deu errado (ex.: banco fora do ar no 500). --}}
@props(['codigo', 'titulo', 'texto', 'voltar' => true])

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $titulo }} | Cassia Souza Advocacia Tributária</title>
    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <meta name="theme-color" content="#590854">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:opsz,wght@6..72,600&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/novo.css')
</head>

<body>
    <main class="cs-plum-bg flex min-h-screen flex-col text-white">
        <div class="cs-wrap flex items-center justify-between py-5">
            <a href="/" aria-label="Cassia Souza Advocacia — início">
                <img src="/assets/images/logo-acinzentado.png" alt="Cassia Souza Advocacia" width="128" height="68" class="block h-auto w-[128px]">
            </a>
            <a href="{{ config('site.whatsapp_link') }}" target="_blank" rel="nofollow noopener"
                class="inline-flex items-center gap-2 rounded-full border border-white/25 px-4 py-2 text-[15px] font-semibold tabular-nums text-white transition-colors hover:border-champagne">
                <i class="fab fa-whatsapp text-lg text-champagne" aria-hidden="true"></i>
                <span class="hidden sm:inline">{{ config('site.whatsapp') }}</span>
            </a>
        </div>

        <section class="cs-wrap flex flex-1 flex-col justify-center pb-[clamp(56px,8vw,112px)] pt-8">
            <p class="font-display text-[clamp(72px,10vw,140px)] font-semibold leading-none text-champagne/90">{{ $codigo }}</p>
            <h1 class="mt-4 max-w-[16em] font-display text-[clamp(34px,4.4vw,54px)] font-semibold leading-[1.08] tracking-[-0.02em]">
                {{ $titulo }}
            </h1>
            <p class="mt-5 max-w-[36em] text-lg leading-relaxed text-on-plum">{{ $texto }}</p>

            <div class="mt-9 flex flex-wrap items-center gap-x-7 gap-y-4">
                {{ $slot }}

                @if ($voltar)
                    <a href="/"
                        class="inline-flex items-center gap-2.5 rounded-full bg-champagne px-7 py-4 font-semibold text-plum-night transition hover:bg-champagne-light">
                        Voltar para o início
                    </a>
                @endif
                <a href="{{ config('site.whatsapp_link') }}" target="_blank" rel="nofollow noopener"
                    class="font-semibold text-white underline decoration-champagne/60 underline-offset-[6px] hover:decoration-champagne">
                    Falar com a gente no WhatsApp
                </a>
            </div>
        </section>

        <p class="cs-wrap border-t border-white/10 py-6 text-sm text-on-plum/60">
            © {{ date('Y') }} Cassia Souza Advocacia · cassia_souza@adv.oabsp.org.br
        </p>
    </main>
</body>

</html>
