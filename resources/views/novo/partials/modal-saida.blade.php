{{-- Modal de saída: quando o visitante vai embora, oferece falar com a Cássia.
     Desktop: mouse saindo pelo topo da janela. Celular: rolagem rápida para
     cima depois de ter lido parte da página. Aparece no máximo 1 vez a cada
     7 dias, nunca nos primeiros 8s e nunca para quem já clicou no WhatsApp ou
     enviou o formulário. Não aparece na página de contato. --}}
@unless (request()->routeIs('contato'))
<div x-data="{
        aberto: false,
        chave: 'cs-saida-site',
        podeMostrar() {
            if (performance.now() < 8000) return false;
            try {
                const visto = Number(localStorage.getItem(this.chave) || 0);
                return Date.now() - visto > 7 * 24 * 60 * 60 * 1000;
            } catch (e) { return false; }
        },
        mostrar() {
            if (this.aberto || ! this.podeMostrar()) return;
            this.aberto = true;
            try { localStorage.setItem(this.chave, Date.now()); } catch (e) {}
            this.$nextTick(() => this.$refs.fechar.focus());
        },
        nuncaMais() {
            try { localStorage.setItem(this.chave, Date.now() + 365 * 24 * 60 * 60 * 1000); } catch (e) {}
        },
        init() {
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
    <div x-cloak x-show="aberto" x-transition.opacity.duration.200ms
        class="fixed inset-0 z-[9998] grid place-items-center bg-plum-night/60 p-4 backdrop-blur-[2px]"
        @click.self="aberto = false">
        <div role="dialog" aria-modal="true" aria-labelledby="saida-titulo"
            x-show="aberto" x-transition:enter="transition duration-300 ease-out-soft"
            x-transition:enter-start="translate-y-3 scale-[0.98] opacity-0"
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
