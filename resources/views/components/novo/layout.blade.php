@props([
    'title' => 'Cassia Souza Advocacia Tributária',
    'description' => 'Advocacia tributária para empresas: planejamento tributário, recuperação de PIS/COFINS, regularização de débitos na PGFN e assessoria para a Reforma Tributária.',
    // Imagem ao compartilhar o link (WhatsApp, LinkedIn etc.)
    'image' => '/assets/img/og-cassia-souza.jpg',
    // Páginas de SEO: canonical para o termo principal e noindex até ganharem texto próprio
    'canonical' => null,
    'robots' => null,
    // Dados estruturados (App\Support\Schema): tipo da página, breadcrumb e nós extras
    'tipoPagina' => 'WebPage',
    // Palavras-chave (o Google ignora; outras ferramentas e buscadores ainda leem)
    'keywords' => 'advocacia tributária, advogada tributarista, planejamento tributário, recuperação de PIS/COFINS, regularização de débitos PGFN, Reforma Tributária, Suzano',
    'breadcrumbs' => [],
    'schema' => [],
    // Campos extras do nó da página (App\Support\Schema::pagina): name, about, mainEntity...
    'paginaSchema' => [],
])

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">
    {{-- Padrão: indexar e permitir prévia grande da imagem (Google Discover e respostas de IA) --}}
    <meta name="robots" content="{{ $robots ?? 'index, follow, max-image-preview:large' }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="Cassia Souza">
    <meta name="publisher" content="Cassia Souza Advocacia Tributária">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="Cassia Souza Advocacia Tributária">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical ?? url()->current() }}">
    <meta property="og:image" content="{{ url($image) }}">
    @if ($image === '/assets/img/og-cassia-souza.jpg')
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="Cassia Souza Advocacia Tributária, escritório em Suzano (SP)">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    {{-- Favicon para Google e navegadores (múltiplos de 48px exigidos pelo Google Search) --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon-192x192.png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#590854">
    <link rel="preload" href="/assets/images/monograma-sc.png" as="image">
    @include('partials.preloader-head')

    {{-- Fontes no próprio site (@font-face em novo.css); a do texto vem antes de tudo --}}
    <link rel="preload" href="/assets/fonts/public-sans-latin.woff2" as="font" type="font/woff2" crossorigin>
    {{-- Ícones sem bloquear a primeira pintura: o CSS chega depois e os ícones aparecem em seguida --}}
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    {{-- CSS dentro do HTML (~10 KB comprimido): a primeira pintura não espera
         outra requisição. Com o Vite em modo dev (composer dev), link normal. --}}
    @if (\Illuminate\Support\Facades\Vite::isRunningHot())
        @vite('resources/css/novo.css')
    @else
        <style>{!! \Illuminate\Support\Facades\Vite::content('resources/css/novo.css') !!}</style>
    @endif
    @stack('head')
    {{-- Aviso de cookies (o mesmo do blog); pequeno, vai junto no HTML --}}
    <style>{!! file_get_contents(public_path('assets/css/cookies.css')) !!}</style>
    <script src="/assets/js/cookies.js?v={{ filemtime(public_path('assets/js/cookies.js')) }}" defer></script>

    <script type="application/ld+json">{!! \App\Support\Schema::json(array_merge(
        \App\Support\Schema::base(),
        \App\Support\Schema::pagina($title, $description, $canonical ?? url()->current(), $breadcrumbs, $tipoPagina, $paginaSchema),
        $schema,
    )) !!}</script>
</head>

<body>
    @include('partials.preloader')

    {{ $slot }}

    @include('novo.partials.footer')

    @include('novo.partials.modal-saida')

    <x-link-whatsapp rel="nofollow" title="Conversar no WhatsApp" aria-label="Conversar no WhatsApp"
        class="fixed bottom-6 right-6 z-50 grid h-14 w-14 place-items-center rounded-full bg-[#25d366] text-[28px] text-white shadow-[0_12px_28px_-8px_rgba(0,0,0,0.45)] transition motion-safe:hover:scale-105">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
    </x-link-whatsapp>

    <script>
        // Revelar ao rolar (estilos .cs-revelar no novo.css): títulos de seção e
        // cards de serviço, uma vez só. Só esconde o que está abaixo da dobra e
        // só quando o navegador tem IntersectionObserver e não pede menos movimento;
        // sem isso (ou sem JS), tudo fica visível como sempre.
        (function () {
            if (!('IntersectionObserver' in window) || matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            var alvos = document.querySelectorAll('main h2[id$="-titulo"], [data-revelar]');
            var io = new IntersectionObserver(function (entradas) {
                entradas.forEach(function (e) {
                    if (!e.isIntersecting) return;
                    e.target.classList.add('cs-visivel');
                    io.unobserve(e.target);
                });
            }, { rootMargin: '0px 0px -8% 0px' });
            var dobra = window.innerHeight;
            // Mede tudo antes de mudar classes: ler a posição depois de cada
            // classList.add forçava um layout por elemento (reflow forçado)
            var abaixo = Array.prototype.filter.call(alvos, function (el) {
                return el.getBoundingClientRect().top >= dobra;
            });
            abaixo.forEach(function (el) {
                el.classList.add('cs-revelar');
                io.observe(el);
            });
        })();
    </script>
    <script src="/assets/js/preloader.js?v={{ filemtime(public_path('assets/js/preloader.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script>
        // Livewire 3: dispatch('swal', payload) dos formulários de contato e newsletter
        window.addEventListener('swal', event => {
            let detail = event.detail;
            if (Array.isArray(detail) && detail.length) detail = detail[0];
            detail = detail || {};

            Swal.fire({
                icon: detail.type || 'success',
                title: detail.title || '',
                text: detail.text || '',
                showConfirmButton: detail.showConfirmButton !== false,
                timer: detail.timer || undefined,
                confirmButtonColor: '#590854',
            });
        });
    </script>
</body>

</html>
