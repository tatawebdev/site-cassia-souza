{{-- Carrega o reCAPTCHA v2 uma única vez por página, mesmo com vários
     formulários (contato, newsletter). Quem precisa renderizar um widget usa:
     window.grecaptcha?.render ? renderizar() : window.recaptchaFila.push(renderizar) --}}
<script>
    window.recaptchaFila ??= [];
    window.recaptchaPronto ??= () => window.recaptchaFila.forEach((renderizar) => renderizar());

    if (! document.getElementById('recaptcha-api')) {
        const script = document.createElement('script');
        script.id = 'recaptcha-api';
        script.src = 'https://www.google.com/recaptcha/api.js?onload=recaptchaPronto&render=explicit&hl=pt-BR';
        script.async = true;
        document.head.appendChild(script);
    }
</script>
