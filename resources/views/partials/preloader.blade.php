{{-- Pré-loader de tela cheia (mesmo estilo do Scorpion/Brokers). Fica logo no
início do <body>, com o CSS inline, pra aparecer instantâneo antes do resto
da página renderizar.

O monograma "SC" (recorte de logo-roxo.png) "respira": duas cópias com
máscara em gradiente acendem alternadas — uma o lado do S, outra o do C —
com meio segundo de atraso, e um brilho difuso atrás. Na saída faz fade +
leve zoom. Quem esconde é /assets/js/preloader.js. --}}
<style>
    @keyframes site-preloader-mark {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.06); }
    }
    @keyframes site-preloader-half {
        0%, 100% { opacity: .35; }
        50% { opacity: 1; }
    }
    @keyframes site-preloader-glow {
        0%, 100% { opacity: .10; transform: scale(.85); }
        50% { opacity: .24; transform: scale(1.2); }
    }

    /* Entra rápido (150ms), sai devagar e suave (550ms) — mesma curva de
       desaceleração na opacidade e na escala. visibility some só depois do
       fade, pra sair do foco/leitor de tela sem cortar a transição. */
    #site-preloader {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        opacity: 1;
        transform: scale(1);
        transition:
            opacity .15s cubic-bezier(.16, 1, .3, 1),
            transform .15s cubic-bezier(.16, 1, .3, 1);
    }
    #site-preloader.site-preloader--hidden {
        opacity: 0;
        transform: scale(1.045);
        pointer-events: none;
        visibility: hidden;
        transition:
            opacity .55s cubic-bezier(.16, 1, .3, 1),
            transform .55s cubic-bezier(.16, 1, .3, 1),
            visibility 0s linear .55s;
    }
    .site-preloader__inner {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 120px;
        height: 120px;
    }
    .site-preloader__glow {
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 9999px;
        background: #590854;
        filter: blur(26px);
        animation: site-preloader-glow 2.2s ease-in-out infinite;
    }
    .site-preloader__mark {
        position: relative;
        width: 68px;
        height: 68px;
        animation: site-preloader-mark 2s ease-in-out infinite;
    }
    .site-preloader__half {
        position: absolute;
        inset: 0;
        background: url(/assets/images/monograma-sc.png) center / contain no-repeat;
        animation: site-preloader-half 2s ease-in-out infinite;
    }
    .site-preloader__half--s {
        -webkit-mask-image: linear-gradient(to right, #000 35%, transparent 75%);
        mask-image: linear-gradient(to right, #000 35%, transparent 75%);
    }
    .site-preloader__half--c {
        -webkit-mask-image: linear-gradient(to left, #000 35%, transparent 75%);
        mask-image: linear-gradient(to left, #000 35%, transparent 75%);
        animation-delay: .5s;
    }

    @media (prefers-reduced-motion: reduce) {
        .site-preloader__glow,
        .site-preloader__mark,
        .site-preloader__half {
            animation-duration: 4s;
        }
        .site-preloader__mark { animation: none; }
        #site-preloader,
        #site-preloader.site-preloader--hidden {
            transform: none;
        }
    }
</style>
<div id="site-preloader" role="status" aria-label="Carregando">
    <div class="site-preloader__inner">
        <span class="site-preloader__glow"></span>
        <div class="site-preloader__mark" aria-hidden="true">
            <span class="site-preloader__half site-preloader__half--s"></span>
            <span class="site-preloader__half site-preloader__half--c"></span>
        </div>
    </div>
</div>
