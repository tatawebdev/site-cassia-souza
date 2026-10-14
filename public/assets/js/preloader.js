(function () {
    var MIN_VISIBLE_MS = 1500; // não "pisca" quando a página carrega rápido
    var MAX_WAIT_MS = 8000; // não prende o usuário se algum recurso externo travar o "load"

    // performance.now() conta desde o início da navegação: se o load já
    // passou do mínimo, esconde na hora; senão espera só o que falta.
    function hideAfterMinimum() {
        setTimeout(hidePreloader, Math.max(0, MIN_VISIBLE_MS - performance.now()));
    }

    function hidePreloader() {
        var el = document.getElementById('site-preloader');
        if (!el || el.classList.contains('site-preloader--hidden')) return;

        el.classList.add('site-preloader--hidden');
        // Remove do DOM depois da animação de saída (550ms)
        setTimeout(function () {
            if (el.parentNode) el.parentNode.removeChild(el);
        }, 600);
    }

    window.addEventListener('load', hideAfterMinimum);
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
