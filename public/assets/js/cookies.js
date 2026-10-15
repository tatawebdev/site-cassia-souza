/*
 * Aviso de cookies (LGPD) do site e do blog. Um arquivo só, servido pelo site e
 * carregado também pelo blog. A escolha fica no cookie "cs_consentimento" do
 * domínio .cassiasouzaadvocacia.com.br, então vale para os dois.
 *
 * Categorias: necessários (sempre ativos) e medição de audiência (Google
 * Analytics / Tag Manager). A medição só liga com o aceite: o blog declara o
 * Consent Mode do Google como "denied" antes de carregar o GA, e aqui o
 * consentimento é atualizado. Reabrir: window.csCookies.abrir() ou qualquer
 * elemento com [data-cookies-abrir].
 *
 * Uso: <script src="https://cassiasouzaadvocacia.com.br/assets/js/cookies.js" defer></script>
 */
(function () {
    var NOME = 'cs_consentimento';
    var VERSAO = '1';
    var PRIVACIDADE = 'https://cassiasouzaadvocacia.com.br/politica-de-privacidade';

    function ler() {
        var m = document.cookie.match(new RegExp('(?:^|; )' + NOME + '=([^;]*)'));
        if (!m) return null;
        var p = decodeURIComponent(m[1]).split('|');
        return p[0] === VERSAO ? { medicao: p[1] === '1' } : null;
    }

    function gravar(medicao) {
        var dominio = /cassiasouzaadvocacia\.com\.br$/.test(location.hostname) ? '; domain=.cassiasouzaadvocacia.com.br' : '';
        document.cookie = NOME + '=' + encodeURIComponent(VERSAO + '|' + (medicao ? '1' : '0')) +
            '; max-age=' + 60 * 60 * 24 * 365 + '; path=/; SameSite=Lax' + dominio + (location.protocol === 'https:' ? '; Secure' : '');
        aplicar(medicao);
    }

    function aplicar(medicao) {
        if (typeof window.gtag === 'function') {
            var estado = medicao ? 'granted' : 'denied';
            window.gtag('consent', 'update', { analytics_storage: estado, ad_storage: estado, ad_user_data: estado, ad_personalization: estado });
        }
    }

    var icone = {
        escudo: '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" d="M12 3 4.5 6v5.5c0 4.6 3.2 8.4 7.5 9.5 4.3-1.1 7.5-4.9 7.5-9.5V6L12 3Z"/><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg>',
        documento: '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" d="M7 3h7l5 5v13H7z"/><path fill="none" stroke="currentColor" stroke-width="1.8" d="M14 3v5h5M10 13h6M10 17h6"/></svg>',
    };

    var caixa = null;

    function montar() {
        caixa = document.createElement('section');
        caixa.className = 'cs-cookies';
        caixa.setAttribute('role', 'dialog');
        caixa.setAttribute('aria-labelledby', 'cs-cookies-titulo');
        caixa.hidden = true;
        caixa.innerHTML =
            '<div class="cs-cookies__topo">' +
                '<span class="cs-cookies__escudo">' + icone.escudo + '</span>' +
                '<p id="cs-cookies-titulo" class="cs-cookies__titulo">Controle sua privacidade</p>' +
                '<button type="button" class="cs-cookies__fechar" data-acao="recusar" aria-label="Fechar e usar só os cookies necessários">&times;</button>' +
            '</div>' +
            '<div class="cs-cookies__resumo">' +
                '<p class="cs-cookies__texto">Usamos cookies necessários para o site funcionar e, com a sua permissão, cookies de medição para entender como o conteúdo é usado.</p>' +
                '<ul class="cs-cookies__docs"><li>' + icone.documento + '<a href="' + PRIVACIDADE + '">Política de Privacidade</a></li></ul>' +
            '</div>' +
            '<div class="cs-cookies__prefs" hidden>' +
                '<div class="cs-cookies__item">' +
                    '<div><p class="cs-cookies__item-titulo">Necessários</p><p class="cs-cookies__item-texto">Funcionamento do site, segurança dos formulários (reCAPTCHA) e a sua escolha de cookies.</p></div>' +
                    '<span class="cs-cookies__sempre">Sempre ativos</span>' +
                '</div>' +
                '<label class="cs-cookies__item">' +
                    '<div><p class="cs-cookies__item-titulo">Medição de audiência</p><p class="cs-cookies__item-texto">Google Analytics, para saber quais páginas e artigos são mais lidos. Sem dados para anúncios.</p></div>' +
                    '<input type="checkbox" class="cs-cookies__chave" data-medicao>' +
                '</label>' +
            '</div>' +
            '<div class="cs-cookies__acoes">' +
                '<button type="button" class="cs-cookies__botao cs-cookies__botao--contorno" data-acao="personalizar">Personalizar</button>' +
                '<button type="button" class="cs-cookies__botao cs-cookies__botao--cheio" data-acao="aceitar">Aceitar</button>' +
            '</div>';
        document.body.appendChild(caixa);

        caixa.addEventListener('click', function (e) {
            var acao = e.target.closest('[data-acao]');
            if (!acao) return;
            var tipo = acao.getAttribute('data-acao');
            if (tipo === 'aceitar') { gravar(true); fechar(); }
            if (tipo === 'recusar') { gravar(false); fechar(); }
            if (tipo === 'salvar') { gravar(caixa.querySelector('[data-medicao]').checked); fechar(); }
            if (tipo === 'personalizar') personalizar(true);
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && caixa && !caixa.hidden && caixa.classList.contains('cs-cookies--prefs')) personalizar(false);
        });
    }

    function personalizar(ligar) {
        caixa.classList.toggle('cs-cookies--prefs', ligar);
        caixa.querySelector('.cs-cookies__prefs').hidden = !ligar;
        var atual = ler();
        caixa.querySelector('[data-medicao]').checked = atual ? atual.medicao : false;
        var botao = caixa.querySelector('[data-acao="personalizar"], [data-acao="salvar"]');
        botao.setAttribute('data-acao', ligar ? 'salvar' : 'personalizar');
        botao.textContent = ligar ? 'Salvar escolha' : 'Personalizar';
        caixa.querySelector('[data-acao="aceitar"]').textContent = ligar ? 'Aceitar todos' : 'Aceitar';
    }

    function abrir(comPreferencias) {
        if (!caixa) montar();
        caixa.hidden = false;
        personalizar(!!comPreferencias);
        requestAnimationFrame(function () { caixa.classList.add('cs-cookies--aberto'); });
    }

    function fechar() {
        caixa.classList.remove('cs-cookies--aberto');
        setTimeout(function () { caixa.hidden = true; }, 250);
    }

    window.csCookies = { abrir: abrir };
    document.addEventListener('click', function (e) {
        var link = e.target.closest('[data-cookies-abrir]');
        if (link) { e.preventDefault(); abrir(true); }
    });

    var atual = ler();
    if (atual) {
        aplicar(atual.medicao);
    } else {
        // Espera um pouco para não disputar a atenção com o carregamento da página
        setTimeout(function () { abrir(false); }, 1200);
    }
})();
