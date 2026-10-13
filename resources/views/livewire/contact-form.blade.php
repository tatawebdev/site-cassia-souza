<div>
    @if (session()->has('contact_success'))
        <div class="alert alert-success">{{ session('contact_success') }}</div>
    @endif
    @if (session()->has('contact_error'))
        <div class="alert alert-danger">{{ session('contact_error') }}</div>
    @endif

    <form wire:submit.prevent="submit" class="position-relative">
        <div class="form-group input1 float-left">
            <input wire:model.defer="nome" type="text" class="form_style" placeholder="Nome">
            @error('nome') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group float-left">
            <input wire:model.defer="phone" type="tel" class="form_style" placeholder="Telefone">
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group input1 float-left">
            <input wire:model.defer="email" type="email" class="form_style" placeholder="E-mail">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group float-left">
            <select wire:model.defer="area" class="form-control">
                <option value="">Área de interesse</option>
                <option>Planejamento Tributário</option>
                <option>Recuperação de PIS/COFINS monofásicos</option>
                <option>Regularização de débitos (PGFN)</option>
                <option>Reforma Tributária</option>
                <option>Planejamento para clínicas</option>
                <option>Consultoria Tributária mensal</option>
                <option>Treinamento Tributário</option>
                <option>Outro assunto</option>
            </select>
            @error('area') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group message">
            <textarea wire:model.defer="msg" class="form_style" placeholder="Mensagem" rows="3"></textarea>
            @error('msg') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        @if ($siteKey = config('services.recaptcha.site_key'))
            {{-- reCAPTCHA v2 ("Não sou um robô"), renderizado pelo Alpine para
                 sobreviver às atualizações do Livewire (wire:ignore) --}}
            <div class="form-group recaptcha">
                <div wire:ignore x-data="{ id: null }"
                    x-init="
                        const renderizar = () => id = grecaptcha.render($el, {
                            sitekey: @js($siteKey),
                            callback: (token) => $wire.recaptcha = token,
                            'expired-callback': () => $wire.recaptcha = '',
                        });
                        window.grecaptcha?.render ? renderizar() : window.recaptchaFila.push(renderizar);
                    "
                    @recaptcha-reset.window="id !== null && grecaptcha.reset(id)"></div>
                @error('recaptcha') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            @include('partials.recaptcha-loader')
        @endif

        <button type="submit" class="appointment">Enviar solicitação<i class="fa-solid fa-arrow-right"></i></button>
    </form>
</div>
