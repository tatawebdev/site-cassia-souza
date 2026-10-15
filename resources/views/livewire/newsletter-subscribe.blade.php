<div x-data="{
        confirmando: false,
        id: null,
        exigeRecaptcha: @js((bool) config('services.recaptcha.site_key')),
        {{-- Clique em "Inscrever-se": sem reCAPTCHA envia direto; com ele,
             abre a confirmação e envia sozinho quando a caixa é marcada --}}
        enviar() {
            if (! this.exigeRecaptcha) return $wire.subscribe();
            this.confirmando = true;
            this.$nextTick(() => {
                if (this.id !== null) return grecaptcha.reset(this.id);
                const renderizar = () => this.id = grecaptcha.render(this.$refs.widget, {
                    sitekey: @js(config('services.recaptcha.site_key')),
                    callback: (token) => {
                        $wire.recaptcha = token;
                        this.confirmando = false;
                        $wire.subscribe();
                    },
                });
                window.grecaptcha?.render ? renderizar() : window.recaptchaFila.push(renderizar);
            });
        },
    }"
    @newsletter-recaptcha-reset.window="id !== null && grecaptcha.reset(id)">
    @if (session()->has('newsletter_success'))
        <div class="alert alert-success mb-2">{{ session('newsletter_success') }}</div>
    @endif
    @if (session()->has('newsletter_error'))
        <div class="alert alert-danger mb-2">{{ session('newsletter_error') }}</div>
    @endif

    <form @submit.prevent="enviar()">
        <div class="form-group position-relative mb-0">
            <input wire:model.defer="email" type="email" required class="form_style" placeholder="Seu e-mail" name="email"
                aria-label="Seu e-mail">
            <button type="submit">Inscrever-se<i class="fa-solid fa-arrow-right"></i></button>
        </div>
        @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
        @error('recaptcha') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </form>

    @if (config('services.recaptcha.site_key'))
        {{-- Confirmação "Não sou um robô". Estilos inline: o componente também
             aparece no rodapé do tema antigo, que não carrega o Tailwind. --}}
        <div data-nosnippet wire:ignore x-show="confirmando" x-transition.opacity style="display: none;"
            @keydown.escape.window="confirmando = false">
        <div style="position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 16px; background: rgba(36, 4, 31, 0.55);"
            @click.self="confirmando = false">
            <div role="dialog" aria-modal="true" aria-labelledby="newsletter-confirmar-titulo"
                style="width: 100%; max-width: 360px; border-radius: 16px; background: #fff; padding: 28px 24px; text-align: center; box-shadow: 0 30px 60px -20px rgba(36, 4, 31, 0.5); font-family: inherit;">
                <p id="newsletter-confirmar-titulo"
                    style="margin: 0; font-size: 20px; font-weight: 600; line-height: 1.3; color: #24041F;">
                    Confirme sua inscrição
                </p>
                <p style="margin: 6px 0 20px; font-size: 15px; line-height: 1.5; color: #6A5D68;">
                    Marque a caixa abaixo para receber nossas novidades.
                </p>
                <div x-ref="widget" style="display: inline-block;"></div>
                <button type="button" @click="confirmando = false"
                    style="display: block; margin: 18px auto 0; border: 0; background: none; font-size: 14px; font-weight: 600; color: #590854; text-decoration: underline; cursor: pointer;">
                    Cancelar
                </button>
            </div>
        </div>
        </div>

        @include('partials.recaptcha-loader')
    @endif
</div>
