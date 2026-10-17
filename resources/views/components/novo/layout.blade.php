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

    {{-- Feed RSS do Blog --}}
    <link rel="alternate" type="application/rss+xml" title="Blog Cassia Souza Advocacia" href="https://blog.cassiasouzaadvocacia.com.br/feed/">

    {{-- Google Firebase Cloud Messaging (FCM) SDK --}}
    <script src="https://www.gstatic.com/firebasejs/10.5.2/firebase-app-compat.js" defer></script>
    <script src="https://www.gstatic.com/firebasejs/10.5.2/firebase-messaging-compat.js" defer></script>
    <style>
        /* Banner de Notificações Push FCM - Padrão Dark & Champagne */
        .cs-fcm-dialog {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 2147483000;
            width: min(440px, calc(100% - 32px));
            padding: 22px 24px 20px;
            border: 1px solid rgba(239, 207, 159, 0.3);
            border-radius: 20px;
            background:
                radial-gradient(420px 220px at 100% 0%, rgba(239, 207, 159, 0.15), transparent 70%),
                linear-gradient(160deg, #3a0637 0%, #24041f 100%);
            box-shadow: 0 32px 64px -16px rgba(15, 1, 14, 0.85), 0 0 0 1px rgba(255, 255, 255, 0.08);
            color: #f3e6f1;
            font-family: 'Public Sans', system-ui, -apple-system, sans-serif;
            opacity: 0;
            transform: translateY(-20px) scale(0.96);
            pointer-events: none;
            transition: opacity 300ms cubic-bezier(0.22, 0.8, 0.2, 1), transform 300ms cubic-bezier(0.22, 0.8, 0.2, 1);
        }
        .cs-fcm-dialog--ativo {
            opacity: 1;
            transform: none;
            pointer-events: auto;
        }
        .cs-fcm-dialog__topo {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .cs-fcm-dialog__brasao {
            flex: none;
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: rgba(239, 207, 159, 0.12);
            border: 1px solid rgba(239, 207, 159, 0.25);
            padding: 5px;
        }
        .cs-fcm-dialog__brasao img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .cs-fcm-dialog__titulos {
            flex: 1;
        }
        .cs-fcm-dialog__titulo {
            margin: 0;
            color: #ffffff;
            font-family: 'Newsreader', Georgia, serif;
            font-size: 19px;
            font-weight: 600;
            line-height: 1.25;
        }
        .cs-fcm-dialog__texto {
            margin: 6px 0 0;
            color: rgba(243, 230, 241, 0.82);
            font-size: 13.5px;
            line-height: 1.45;
        }
        .cs-fcm-dialog__acoes {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            margin-top: 16px;
        }
        .cs-fcm-dialog__btn-permitir {
            padding: 9px 22px;
            border-radius: 999px;
            border: 0;
            background: #efcf9f;
            color: #24041f;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(239, 207, 159, 0.25);
            transition: all 200ms ease;
        }
        .cs-fcm-dialog__btn-permitir:hover {
            background: #f7dfb9;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(239, 207, 159, 0.35);
        }
        .cs-fcm-dialog__btn-recusar {
            padding: 9px 18px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.05);
            color: rgba(243, 230, 241, 0.85);
            font-family: inherit;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 200ms ease;
        }
        .cs-fcm-dialog__btn-recusar:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.3);
        }
        @media (max-width: 640px) {
            .cs-fcm-dialog {
                top: auto;
                bottom: 24px;
                right: 16px;
                left: 16px;
                width: auto;
            }
        }
    </style>
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

    {{-- Banner de Notificações Push FCM --}}
    <aside id="cs-fcm-dialog" class="cs-fcm-dialog" aria-live="polite" aria-label="Permissão para receber notificações">
        <div class="cs-fcm-dialog__topo">
            <div class="cs-fcm-dialog__brasao">
                <img src="/assets/images/monograma-sc.png" alt="Cassia Souza Advocacia" width="36" height="36">
            </div>
            <div class="cs-fcm-dialog__titulos">
                <p class="cs-fcm-dialog__titulo">Notificações Tributárias</p>
                <p class="cs-fcm-dialog__texto">Deseja receber em primeira mão novidades sobre Reforma Tributária e novos artigos do blog?</p>
            </div>
        </div>
        <div class="cs-fcm-dialog__acoes">
            <button type="button" class="cs-fcm-dialog__btn-recusar" onclick="csRecusarFCM()">Agora não</button>
            <button type="button" id="cs-fcm-btn-permitir" class="cs-fcm-dialog__btn-permitir" onclick="csPermitirFCM()">Permitir</button>
        </div>
    </aside>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!('serviceWorker' in navigator) || !('Notification' in window)) return;
            var status = localStorage.getItem('cs_fcm_status');
            var dispensado = localStorage.getItem('cs_fcm_dispensado');
            if (Notification.permission === 'granted' || status === 'granted') return;
            if (dispensado && (Date.now() - parseInt(dispensado, 10)) < 7 * 24 * 60 * 60 * 1000) return;

            setTimeout(function () {
                var el = document.getElementById('cs-fcm-dialog');
                if (el) el.classList.add('cs-fcm-dialog--ativo');
            }, 2500);
        });

        async function csPermitirFCM() {
            var btn = document.getElementById('cs-fcm-btn-permitir');
            var dialog = document.getElementById('cs-fcm-dialog');
            if (btn) btn.textContent = 'Ativando...';

            try {
                var permission = await Notification.requestPermission();
                if (permission === 'granted') {
                    var config = {
                        apiKey: "AIzaSyDC_juTBl65iSz_TZsjYQEtUyIRURLQap0",
                        authDomain: "chat-cassia-souza-adv.firebaseapp.com",
                        projectId: "chat-cassia-souza-adv",
                        storageBucket: "chat-cassia-souza-adv.appspot.com",
                        messagingSenderId: "969461920153",
                        appId: "1:969461920153:web:89874b4322d96f77eda308",
                        measurementId: "G-DMYW90V0D7"
                    };

                    if (!firebase.apps.length) {
                        firebase.initializeApp(config);
                    }

                    var messaging = firebase.messaging();
                    var registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
                    await navigator.serviceWorker.ready;

                    var token = await messaging.getToken({
                        vapidKey: 'BMcsGmQg3luA4MCokshTgRcCW7C6jfF9mHplEUCc-hyXSGlFn6wKC_8zbA5vCk4_9TK3HJHM5N36sFiSk6MClFs',
                        serviceWorkerRegistration: registration
                    });

                    if (token) {
                        await fetch('/api/fcm/token', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ token: token })
                        });

                        localStorage.setItem('cs_fcm_status', 'granted');
                        if (dialog) {
                            dialog.innerHTML = '<div style="display:flex;align-items:center;gap:12px;color:#efcf9f;"><i class="fas fa-check-circle" style="font-size:22px;"></i><span style="font-size:15px;font-weight:600;color:#ffffff;">Notificações ativadas com sucesso!</span></div>';
                            setTimeout(function () {
                                dialog.classList.remove('cs-fcm-dialog--ativo');
                            }, 2500);
                        }
                        return;
                    }
                }
            } catch (e) {
                console.error('Erro FCM:', e);
            }

            if (dialog) dialog.classList.remove('cs-fcm-dialog--ativo');
        }

        function csRecusarFCM() {
            localStorage.setItem('cs_fcm_dispensado', Date.now().toString());
            var dialog = document.getElementById('cs-fcm-dialog');
            if (dialog) dialog.classList.remove('cs-fcm-dialog--ativo');
        }
    </script>
</body>

</html>
