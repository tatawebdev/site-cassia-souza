(function () {
    var MIN_VISIBLE_MS = 700; // não "pisca" quando a página carrega rápido
    var MAX_WAIT_MS = 4000; // não prende o usuário se algo travar

    // Sai quando o HTML está pronto (DOMContentLoaded), sem esperar imagens e
    // scripts externos (o "load"): esperar por eles atrasava a foto do topo e
    // derrubava o LCP do PageSpeed. performance.now() conta desde o início da
    // navegação: se já passou do mínimo, esconde na hora; senão espera o que falta.
    function hideAfterMinimum() {
        setTimeout(hidePreloader, Math.max(0, MIN_VISIBLE_MS - performance.now()));
    }

    function hidePreloader() {
        var el = document.getElementById('site-preloader');
        if (!el || el.classList.contains('site-preloader--hidden')) return;

        el.classList.add('site-preloader--hidden');
        // Solta as animações de entrada da página junto com o fade de saída
        document.documentElement.classList.remove('cs-preloading');
        // Remove do DOM depois da animação de saída (550ms)
        setTimeout(function () {
            if (el.parentNode) el.parentNode.removeChild(el);
        }, 600);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', hideAfterMinimum);
    } else {
        hideAfterMinimum();
    }
    setTimeout(hidePreloader, MAX_WAIT_MS);

    // Voltando pelo histórico (bfcache) a página não dispara "load" de novo
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) hidePreloader();
    });
})();

// Pré-loader antigo (resources/views/antigo/layout.blade.php)
if (window.jQuery) {
    $(window).on('load', function () {
        $('.loader').fadeOut();
        $('.loader-mask').delay(350).fadeOut('slow');
    });
}
