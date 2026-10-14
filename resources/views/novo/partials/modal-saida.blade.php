{{-- Modal de saída: quando o visitante vai embora, oferece falar com a Cássia.
     Desktop: mouse saindo pelo topo da janela. Celular: rolagem rápida para
     cima depois de ter lido parte da página. Regra por sessão (sessionStorage:
     zera ao fechar a aba ou numa janela anônima nova): nunca nos primeiros 8s da
     página; depois de aparecer, só volta após 2, 5 e 10 minutos, no máximo 4 vezes
     por sessão; quem clicou no WhatsApp/e-mail ou enviou um formulário não vê mais
     na sessão. Não aparece na página de contato. A mesma regra está no blog
     (modal-saida.js do tema). --}}
@unless (request()->routeIs('contato'))
<div x-data="{
        aberto: false,
        chave: 'cs-saida-site',
        // Espera depois da 1ª, 2ª e 3ª vez; depois da 4ª, não aparece mais na sessão
        intervalos: [2 * 60000, 5 * 60000, 10 * 60000],
        // Sem sessionStorage (algumas janelas anônimas), vale só para esta página
        memoria: { vezes: 0, ultima: 0, convertido: false },
        ler() {
            try { return JSON.parse(sessionStorage.getItem(this.chave)) || this.memoria; } catch (e) { return this.memoria; }
        },
        gravar(estado) {
            this.memoria = estado;
            try { sessionStorage.setItem(this.chave, JSON.stringify(estado)); } catch (e) {}
        },
        podeMostrar() {
            if (performance.now() < 8000) return false;
            const s = this.ler();
            if (s.convertido || s.vezes > this.intervalos.length) return false;
            return s.vezes === 0 || Date.now() - s.ultima >= this.intervalos[s.vezes - 1];
        },
        mostrar() {
            if (this.aberto || ! this.podeMostrar()) return;
            this.aberto = true;
            const s = this.ler();
            this.gravar({ vezes: s.vezes + 1, ultima: Date.now(), convertido: s.convertido });
            this.$nextTick(() => this.$refs.fechar.focus());
        },
        nuncaMais() {
            const s = this.ler();
            this.gravar({ vezes: s.vezes, ultima: s.ultima, convertido: true });
        },
        init() {
            try { localStorage.removeItem(this.chave); } catch (e) {} // regra antiga (7 dias)
            // Quem já entrou em contato não precisa do convite
            document.addEventListener('click', (e) => {
                if (e.target.closest('a[href*=\'whatsapp\'], a[href^=\'mailto:\']')) this.nuncaMais();
            });
            document.addEventListener('submit', () => this.nuncaMais());

            document.addEventListener('mouseout', (e) => {
                if (! e.relatedTarget && e.clientY <= 0) this.mostrar();
            });

            let ultimoY = window.scrollY, ultimoT = performance.now();
            window.addEventListener('scroll', () => {
                const y = window.scrollY, t = performance.now();
                const leu = y > document.body.scrollHeight * 0.3;
                if (matchMedia('(pointer: coarse)').matches && leu && ultimoY - y > 250 && t - ultimoT < 400) this.mostrar();
                if (t - ultimoT > 400) { ultimoY = y; ultimoT = t; }
            }, { passive: true });
        },
    }"
    @keydown.escape.window="aberto = false">
    <div x-cloak x-show="aberto" x-transition.opacity.duration.300ms
        class="fixed inset-0 z-[9998] grid place-items-center bg-plum-night/60 p-4 backdrop-blur-[2px]"
        @click.self="aberto = false">
        <div role="dialog" aria-modal="true" aria-labelledby="saida-titulo"
            x-show="aberto" x-transition:enter="transition duration-medio ease-out-soft"
            x-transition:enter-start="opacity-0 motion-safe:translate-y-3 motion-safe:scale-[0.98]"
            x-transition:leave="transition duration-rapido ease-out-soft"
            x-transition:leave-end="opacity-0 motion-safe:scale-[0.98]"
            class="relative w-full max-w-[480px] overflow-hidden rounded-3xl bg-white shadow-[0_40px_80px_-24px_rgba(36,4,31,0.6)]">
            <div class="cs-plum-bg relative px-8 pb-8 pt-10 text-white">
                <img src="/assets/img/sobrenos.png" alt="" width="72" height="72"
                    class="h-[72px] w-[72px] rounded-full border-2 border-champagne/60 object-cover object-[55%_30%]">
                <h2 id="saida-titulo" class="mt-5 font-display text-[30px] font-semibold leading-[1.1]">
                    Antes de ir: quer entender o caso da sua empresa?
                </h2>
                <p class="mt-3 text-[16px] leading-relaxed text-on-plum">
                    Conte o que está acontecendo e a Cássia indica o melhor caminho, seja regime tributário,
                    créditos a recuperar ou débitos com a PGFN.
                </p>
                <button type="button" x-ref="fechar" @click="aberto = false" aria-label="Fechar"
                    class="absolute right-4 top-4 grid h-10 w-10 place-items-center rounded-full text-on-plum transition-colors hover:bg-white/10 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
                </button>
            </div>
            <div class="grid gap-3 p-6 sm:p-8">
                <x-link-whatsapp rel="nofollow"
                    class="inline-flex items-center justify-center gap-2.5 rounded-full bg-[#1f9e4f] px-6 py-4 font-semibold text-white transition hover:bg-[#188a44]">
                    <i class="fab fa-whatsapp text-xl" aria-hidden="true"></i> Conversar no WhatsApp
                </x-link-whatsapp>
                <a href="{{ route('contato') }}" @click="nuncaMais()"
                    class="inline-flex items-center justify-center gap-2 rounded-full border border-plum px-6 py-3.5 font-semibold text-plum transition-colors hover:bg-plum hover:text-white">
                    Enviar uma mensagem
                </a>
                <button type="button" @click="aberto = false"
                    class="mt-1 text-sm font-medium text-ink-soft underline decoration-ink-soft/40 underline-offset-4 hover:text-plum-night">
                    Agora não
                </button>
            </div>
        </div>
    </div>
</div>
@endunless
