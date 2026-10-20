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

    <style>
        /* Convite para avisos no navegador (FCM). Mesmo material do aviso de cookies
           (cookies.css), no canto oposto: embaixo à direita, acima do WhatsApp,
           para não cobrir o menu nem disputar espaço com o aviso de cookies. */
        .cs-fcm-dialog {
            position: fixed;
            right: 24px;
            bottom: 96px;
            z-index: 2147483000;
            box-sizing: border-box;
            width: min(360px, calc(100% - 32px));
            padding: 18px 20px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            background:
                radial-gradient(360px 200px at 100% 0%, rgba(239, 207, 159, 0.12), transparent 70%),
                linear-gradient(160deg, #3a0637 0%, #24041f 100%);
            box-shadow: 0 32px 64px -24px rgba(20, 2, 18, 0.65);
            color: #f3e6f1;
            font-family: 'Public Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
            font-size: 14px;
            line-height: 1.55;
            opacity: 0;
            visibility: hidden;
            transform: translateY(12px);
            transition: opacity 250ms cubic-bezier(0.22, 0.8, 0.2, 1), transform 250ms cubic-bezier(0.22, 0.8, 0.2, 1), visibility 0s linear 250ms;
        }
        .cs-fcm-dialog--ativo {
            opacity: 1;
            visibility: visible;
            transform: none;
            transition-delay: 0s;
        }
        .cs-fcm-dialog p {
            margin: 0;
        }
        .cs-fcm-dialog__topo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cs-fcm-dialog__icone {
            display: block;
            flex: none;
            width: 22px;
            height: 22px;
            color: #efcf9f;
        }
        .cs-fcm-dialog__titulo {
            flex: 1;
            color: #fff;
            font-family: 'Newsreader', Georgia, serif;
            font-size: 18px;
            font-weight: 600;
            line-height: 1.2;
        }
        .cs-fcm-dialog__fechar {
            display: grid;
            width: 32px;
            height: 32px;
            margin: -6px -8px -6px 0;
            place-items: center;
            padding: 0;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: rgba(243, 230, 241, 0.7);
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
            transition: background-color 200ms ease, color 200ms ease;
        }
        .cs-fcm-dialog__fechar:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }
        .cs-fcm-dialog__texto {
            margin-top: 8px !important;
            color: rgba(243, 230, 241, 0.85);
        }
        .cs-fcm-dialog__acoes {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 14px;
        }
        .cs-fcm-dialog__acoes button {
            padding: 9px 18px;
            border-radius: 999px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
            cursor: pointer;
            transition: background-color 200ms ease, color 200ms ease, border-color 200ms ease;
        }
        .cs-fcm-dialog__btn-recusar {
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: transparent;
            color: rgba(243, 230, 241, 0.9);
        }
        .cs-fcm-dialog__btn-recusar:hover {
            border-color: rgba(255, 255, 255, 0.35);
            color: #fff;
        }
        .cs-fcm-dialog__btn-permitir {
            border: 1px solid #efcf9f;
            background: #efcf9f;
            color: #24041f;
        }
        .cs-fcm-dialog__btn-permitir:hover {
            border-color: #f7dfb9;
            background: #f7dfb9;
        }
        .cs-fcm-dialog__btn-permitir[disabled] {
            cursor: progress;
            opacity: 0.75;
        }
        .cs-fcm-dialog button:focus-visible {
            outline: 2px solid #efcf9f;
            outline-offset: 2px;
        }
        .cs-fcm-dialog__ok {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-weight: 600;
        }
        @media (max-width: 520px) {
            .cs-fcm-dialog {
                right: 12px;
                left: 12px;
                bottom: 92px;
                width: auto;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            .cs-fcm-dialog {
                transform: none;
                transition: opacity 1ms, visibility 0s linear 1ms;
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

    {{-- Convite para avisos no navegador (FCM) --}}
    <aside id="cs-fcm-dialog" class="cs-fcm-dialog" role="dialog" aria-labelledby="cs-fcm-titulo" aria-describedby="cs-fcm-texto">
        <div class="cs-fcm-dialog__topo">
            <svg class="cs-fcm-dialog__icone" viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" d="M6 16v-5a6 6 0 0 1 12 0v5l1.5 2h-15L6 16Z"/><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" d="M10 20.5a2.2 2.2 0 0 0 4 0"/></svg>
            <p id="cs-fcm-titulo" class="cs-fcm-dialog__titulo">Avisos de artigos novos</p>
            <button type="button" class="cs-fcm-dialog__fechar" onclick="csRecusarFCM()" aria-label="Fechar">&times;</button>
        </div>
        <p id="cs-fcm-texto" class="cs-fcm-dialog__texto">Receba um aviso no navegador quando a Cassia publicar sobre impostos e a Reforma Tributária. Dá para desligar quando quiser.</p>
        <div class="cs-fcm-dialog__acoes">
            <button type="button" class="cs-fcm-dialog__btn-recusar" onclick="csRecusarFCM()">Agora não</button>
            <button type="button" id="cs-fcm-btn-permitir" class="cs-fcm-dialog__btn-permitir" onclick="csPermitirFCM()">Ativar avisos</button>
        </div>
    </aside>

    <script>
        // Só convida quem já leu um pouco: depois da escolha de cookies (para não
        // empilhar dois avisos) e de rolar quase uma tela. Se o navegador já
        // bloqueou as notificações, o botão não teria efeito, então nem aparece.
        // Quem já permitiu não vê o convite, mas renova o token uma vez por dia:
        // o token muda com o tempo, e o servidor apaga os que deixaram de valer.
        document.addEventListener('DOMContentLoaded', function () {
            if (!('serviceWorker' in navigator) || !('Notification' in window)) return;

            if (Notification.permission === 'granted') {
                var renovado = parseInt(localStorage.getItem('cs_fcm_renovado') || '0', 10);
                if (Date.now() - renovado > 24 * 60 * 60 * 1000) {
                    csRegistrarFCM().then(function () {
                        localStorage.setItem('cs_fcm_renovado', Date.now().toString());
                    }).catch(function (e) { console.error('Erro FCM:', e); });
                }
                return;
            }
            if (Notification.permission !== 'default') return;
            var dispensado = localStorage.getItem('cs_fcm_dispensado');
            if (dispensado && (Date.now() - parseInt(dispensado, 10)) < 30 * 24 * 60 * 60 * 1000) return;

            function talvezMostrar() {
                if (window.scrollY < window.innerHeight * 0.8) return;
                if (!/(?:^|; )cs_consentimento=/.test(document.cookie)) return;
                window.removeEventListener('scroll', talvezMostrar);
                var el = document.getElementById('cs-fcm-dialog');
                if (el) el.classList.add('cs-fcm-dialog--ativo');
            }
            window.addEventListener('scroll', talvezMostrar, { passive: true });
        });

        function csCarregarScript(src) {
            return new Promise(function (ok, erro) {
                var s = document.createElement('script');
                s.src = src;
                s.onload = ok;
                s.onerror = erro;
                document.head.appendChild(s);
            });
        }

        // Gera o token deste navegador e grava no site. Exige a permissão já dada.
        async function csRegistrarFCM() {
            // O SDK só é baixado aqui, por quem aceitou (antes pesava em toda página)
            if (!window.firebase) {
                await csCarregarScript('https://www.gstatic.com/firebasejs/10.5.2/firebase-app-compat.js');
                await csCarregarScript('https://www.gstatic.com/firebasejs/10.5.2/firebase-messaging-compat.js');
            }
            if (!firebase.apps.length) {
                firebase.initializeApp({
                    apiKey: "AIzaSyDC_juTBl65iSz_TZsjYQEtUyIRURLQap0",
                    authDomain: "chat-cassia-souza-adv.firebaseapp.com",
                    projectId: "chat-cassia-souza-adv",
                    storageBucket: "chat-cassia-souza-adv.appspot.com",
                    messagingSenderId: "969461920153",
                    appId: "1:969461920153:web:89874b4322d96f77eda308",
                    measurementId: "G-DMYW90V0D7"
                });
            }

            var messaging = firebase.messaging();
            var registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
            await navigator.serviceWorker.ready;

            async function enviar() {
                var token = await messaging.getToken({
                    vapidKey: 'BMcsGmQg3luA4MCokshTgRcCW7C6jfF9mHplEUCc-hyXSGlFn6wKC_8zbA5vCk4_9TK3HJHM5N36sFiSk6MClFs',
                    serviceWorkerRegistration: registration
                });
                if (!token) throw new Error('Sem token do FCM');

                return fetch('/api/fcm/token', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ token: token })
                });
            }

            var resposta = await enviar();
            // 410: o SDK devolveu um token guardado que o Google já não aceita.
            // Apaga o guardado e pede outro (uma vez só).
            if (resposta.status === 410) {
                await messaging.deleteToken().catch(function () {});
                resposta = await enviar();
            }
            if (!resposta.ok) throw new Error('Site recusou o token: ' + resposta.status);
        }

        async function csPermitirFCM() {
            var btn = document.getElementById('cs-fcm-btn-permitir');
            var dialog = document.getElementById('cs-fcm-dialog');
            if (btn) { btn.disabled = true; btn.textContent = 'Ativando…'; }

            var permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                // Recusou no pedido do navegador: conta como "agora não"
                csRecusarFCM();
                return;
            }

            try {
                await csRegistrarFCM();
            } catch (e) {
                // Falha técnica não é recusa: o convite volta na próxima visita
                console.error('Erro FCM:', e);
                if (btn) { btn.disabled = false; btn.textContent = 'Tentar de novo'; }
                return;
            }

            localStorage.setItem('cs_fcm_renovado', Date.now().toString());
            if (dialog) {
                dialog.innerHTML = '<p class="cs-fcm-dialog__ok" role="status"><svg class="cs-fcm-dialog__icone" viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m5 12.5 4.5 4.5L19 7.5"/></svg>Avisos ativados</p>';
                setTimeout(function () {
                    dialog.classList.remove('cs-fcm-dialog--ativo');
                }, 2500);
            }
        }

        function csRecusarFCM() {
            localStorage.setItem('cs_fcm_dispensado', Date.now().toString());
            var dialog = document.getElementById('cs-fcm-dialog');
            if (dialog) dialog.classList.remove('cs-fcm-dialog--ativo');
        }
    </script>
</body>

</html>
