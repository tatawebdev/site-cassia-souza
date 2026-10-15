{{-- Carrega o reCAPTCHA v2 uma única vez por página, mesmo com vários
     formulários (contato, newsletter). Quem precisa renderizar um widget usa:
     window.grecaptcha?.render ? renderizar() : window.recaptchaFila.push(renderizar)

     O script do Google é pesado (~350 KB de JS): só baixa na primeira interação
     (rolar, tocar, teclar), antes de a pessoa chegar ao formulário. --}}
<script>
    window.recaptchaFila ??= [];
    window.recaptchaPronto ??= () => window.recaptchaFila.forEach((renderizar) => renderizar());

    if (! window.recaptchaAgendado) {
        window.recaptchaAgendado = true;
        const eventos = ['scroll', 'pointerdown', 'keydown', 'touchstart', 'focusin'];
        const carregar = () => {
            eventos.forEach((e) => window.removeEventListener(e, carregar, true));
            if (document.getElementById('recaptcha-api')) return;
            const script = document.createElement('script');
            script.id = 'recaptcha-api';
            script.src = 'https://www.google.com/recaptcha/api.js?onload=recaptchaPronto&render=explicit&hl=pt-BR';
            script.async = true;
            document.head.appendChild(script);
        };
        eventos.forEach((e) => window.addEventListener(e, carregar, { capture: true, passive: true }));
    }
</script>
