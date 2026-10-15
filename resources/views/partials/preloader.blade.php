{{-- Pré-loader de tela cheia (mesmo estilo do Scorpion/Brokers). Fica logo no
início do <body>; o CSS está em partials/preloader-head, no <head>, pra
aparecer instantâneo antes do resto da página renderizar.

O monograma "SC" (recorte de logo-roxo.png) "respira": duas cópias com
máscara em gradiente acendem alternadas — uma o lado do S, outra o do C —
com meio segundo de atraso, e um brilho difuso atrás. Na saída faz fade +
leve zoom. Quem esconde é /assets/js/preloader.js. --}}
<div id="site-preloader" role="status" aria-label="Carregando">
    <div class="site-preloader__inner">
        <span class="site-preloader__glow"></span>
        <div class="site-preloader__mark" aria-hidden="true">
            <span class="site-preloader__half site-preloader__half--s"><span class="site-preloader__ink"></span></span>
            <span class="site-preloader__half site-preloader__half--c"><span class="site-preloader__ink"></span></span>
        </div>
    </div>
</div>
