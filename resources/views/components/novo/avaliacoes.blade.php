{{-- Avaliações reais do perfil da Cassia no Google, em config/avaliacoes.php
     (gerado por: php artisan avaliacoes:importar pagina.html).

     Carrossel centralizado e infinito: o card do meio em destaque; cada card
     fica na tela um tempo proporcional ao texto, com barra de progresso em
     segmentos (estilo stories). Pausa no hover/foco, no botão de pausa e com
     "reduzir movimento". Todos os cards têm a altura do maior, para a seção
     não mudar de tamanho ao passar. --}}
@php
    $todas = config('avaliacoes.reviews', []);
    $reviews = array_values(array_filter($todas, fn ($r) => $r['rating'] >= 4 && $r['text'] !== ''));
    $nota = config('avaliacoes.rating');
    $total = count($todas);
    // Tempo de leitura: 3,5s + 30ms por caractere, entre 4s e 14s
    $duracoes = array_map(fn ($r) => max(4000, min(14000, 3500 + mb_strlen($r['text']) * 30)), $reviews);
@endphp

@if ($reviews)
    <section aria-labelledby="avaliacoes-titulo" {{ $attributes->merge(['class' => 'overflow-hidden py-[clamp(72px,9vw,128px)]']) }}
        {{-- Loop infinito: o servidor manda os cards uma vez só (o HTML não repete
             o texto) e o init() copia no navegador os últimos cards para antes e
             os primeiros para depois (só os que cabem como vizinhos na tela: copiar
             a lista inteira pesava no celular). A posição (pos) fica nos originais;
             ao sair deles, volta sem animação para o card equivalente. --}}
        x-data="{
            total: {{ count($reviews) }},
            margem: {{ min(3, count($reviews)) }},
            duracoes: @js($duracoes),
            pos: {{ min(3, count($reviews)) }},
            progresso: 0,
            deslocamento: 0,
            semAnimacao: false,
            pausado: false,
            parado: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
            inicioToque: null,
            get atual() { return ((this.pos - this.margem) % this.total + this.total) % this.total },
            init() {
                // Roda antes de o Alpine processar os filhos: as cópias entram
                // no DOM e são inicializadas junto com os originais
                const trilho = this.$el.querySelector('[x-ref=trilho]');
                const originais = [...trilho.children];
                const copia = (lista) => lista.map((li) => {
                    const c = li.cloneNode(true);
                    [':aria-hidden', 'aria-roledescription', 'aria-label'].forEach((a) => c.removeAttribute(a));
                    c.setAttribute('aria-hidden', 'true');
                    c.querySelectorAll('img').forEach((img) => img.alt = '');
                    return c;
                });
                trilho.prepend(...copia(originais.slice(-this.margem)));
                trilho.append(...copia(originais.slice(0, this.margem)));
                [...trilho.children].forEach((li, i) => li.dataset.i = i);

                this.$nextTick(() => this.medir());
                window.addEventListener('resize', () => this.medir());

                // Passagem automática só com a seção na tela (fora dela, nada roda)
                let anterior = null;
                let quadro = null;
                const passo = (agora) => {
                    if (anterior !== null && ! this.pausado && ! this.parado) {
                        this.progresso += (agora - anterior) / this.duracoes[this.atual];
                        if (this.progresso >= 1) this.avancar(1);
                    }
                    anterior = agora;
                    quadro = requestAnimationFrame(passo);
                };
                new IntersectionObserver(([e]) => {
                    if (e.isIntersecting && quadro === null) {
                        anterior = null;
                        quadro = requestAnimationFrame(passo);
                    } else if (! e.isIntersecting && quadro !== null) {
                        cancelAnimationFrame(quadro);
                        quadro = null;
                    }
                }).observe(this.$el);
            },
            ir(p) {
                this.pos = p;
                this.progresso = 0;
                this.medir();
            },
            // Anda d cards; se cliques rápidos já levaram para fora dos originais
            // (antes do fim da transição), volta ao equivalente antes de andar
            avancar(d) {
                this.reposicionar();
                this.ir(this.pos + d);
            },
            medir() {
                const cards = this.$refs.trilho.children;
                const largura = cards[1].offsetLeft - cards[0].offsetLeft;
                this.deslocamento = (this.$refs.janela.clientWidth - cards[0].offsetWidth) / 2 - this.pos * largura;
            },
            reposicionar() {
                if (this.pos >= this.margem && this.pos < this.margem + this.total) return;
                this.semAnimacao = true;
                this.pos = this.margem + this.atual;
                this.medir();
                this.$refs.trilho.offsetHeight;
                requestAnimationFrame(() => requestAnimationFrame(() => this.semAnimacao = false));
            },
            preenchimento(i) {
                if (i < this.atual) return 1;
                return i === this.atual ? Math.min(this.progresso, 1) : 0;
            },
            soltar(x) {
                if (this.inicioToque === null) return;
                const dx = x - this.inicioToque;
                if (Math.abs(dx) > 50) this.avancar(dx < 0 ? 1 : -1);
                this.inicioToque = null;
            },
        }"
        @mouseenter="pausado = true" @mouseleave="pausado = false"
        @focusin="pausado = true" @focusout="pausado = false"
        @keydown.arrow-right="avancar(1)" @keydown.arrow-left="avancar(-1)">
        <div class="cs-wrap">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <h2 id="avaliacoes-titulo" class="max-w-[16em] font-display text-[clamp(34px,4vw,54px)] font-semibold leading-[1.05] tracking-[-0.015em] text-plum-night">
                    O que dizem os clientes atendidos
                </h2>

                @if ($nota)
                    <div class="flex items-center gap-4">
                        <span class="font-display text-5xl font-semibold leading-none text-plum-night">{{ number_format($nota, 1, ',', '') }}</span>
                        <span>
                            <span role="img" class="flex gap-0.5 text-champagne-dark" aria-label="Nota {{ number_format($nota, 1, ',', '') }} de 5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star text-sm {{ $i <= round($nota) ? '' : 'opacity-25' }}" aria-hidden="true"></i>
                                @endfor
                            </span>
                            <span class="mt-1 block text-sm text-ink-soft">
                                <i class="fa-brands fa-google mr-1 text-xs" aria-hidden="true"></i>{{ $total }} avaliações no Google
                            </span>
                        </span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Janela em largura total: os cards vizinhos aparecem nas laterais --}}
        <div x-ref="janela" class="mt-12 touch-pan-y select-none" role="region" aria-roledescription="carrossel"
            aria-label="Avaliações de clientes"
            @pointerdown="inicioToque = $event.clientX" @pointerup="soltar($event.clientX)" @pointerleave="inicioToque = null">
            <ul x-ref="trilho" @transitionend.self="reposicionar()"
                :class="semAnimacao && '!transition-none [&>li]:!transition-none'"
                class="flex items-stretch gap-6 py-6 transition-transform duration-700 ease-out-soft motion-reduce:transition-none"
                :style="`transform: translateX(${deslocamento}px)`">
                @foreach ($reviews as $review)
                    {{-- data-i: posição no trilho, preenchida pelo init() (as cópias
                         criadas no navegador ficam ocultas para leitores de tela) --}}
                    <li @click="pos !== +$el.dataset.i && ir(+$el.dataset.i)"
                        :aria-hidden="(pos !== +$el.dataset.i).toString()"
                        aria-roledescription="avaliação" aria-label="{{ $loop->iteration }} de {{ count($reviews) }}"
                        :class="pos === +$el.dataset.i
                            ? 'scale-100 opacity-100 shadow-[0_40px_80px_-40px_rgba(58,6,55,0.55)]'
                            : 'scale-[0.88] cursor-pointer opacity-45 shadow-none'"
                        class="relative flex w-[82vw] shrink-0 flex-col overflow-hidden rounded-2xl border border-line/80 bg-[radial-gradient(120%_70%_at_0%_0%,#FFF6EA_0%,#FFFFFF_45%,#F8F2F7_100%)] p-7 transition duration-700 ease-out-soft motion-reduce:transition-none sm:w-[440px] sm:p-9">
                        <div class="flex items-start justify-between">
                            <span role="img" class="flex gap-0.5 text-champagne-dark" aria-label="{{ $review['rating'] }} de 5 estrelas">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $review['rating'] ? '' : 'opacity-25' }}" aria-hidden="true"></i>
                                @endfor
                            </span>
                            <i class="fa-solid fa-quote-right -mt-1 text-5xl text-champagne/70" aria-hidden="true"></i>
                        </div>

                        {{-- Todos os cards têm a altura do maior: textos curtos
                             ganham destaque (maiores) e ficam centrados no espaço --}}
                        @php $tamanho = mb_strlen($review['text']); @endphp
                        <blockquote class="my-6 flex flex-1 items-center">
                            <p @class([
                                'whitespace-pre-line',
                                'font-display text-[clamp(24px,2.2vw,30px)] font-semibold leading-[1.25] text-plum-night' => $tamanho <= 90,
                                'text-[20px] leading-relaxed text-ink' => $tamanho > 90 && $tamanho <= 200,
                                'text-[17px] leading-relaxed text-ink' => $tamanho > 200,
                            ])>{{ $review['text'] }}</p>
                        </blockquote>

                        <footer class="flex items-center gap-3 border-t border-line pt-5">
                            @if ($review['photo'])
                                <img src="{{ asset($review['photo']) }}" alt="Foto de {{ $review['author'] }}" width="44" height="44" loading="lazy" draggable="false"
                                    class="h-11 w-11 rounded-full object-cover">
                            @else
                                <span class="grid h-11 w-11 place-items-center rounded-full bg-plum/10 font-semibold text-plum" aria-hidden="true">
                                    {{ mb_substr($review['author'] ?? 'C', 0, 1) }}
                                </span>
                            @endif
                            <span class="min-w-0">
                                <span class="block truncate font-semibold text-plum-night">{{ $review['author'] ?? 'Cliente' }}</span>
                                <span class="block text-sm text-ink-soft">
                                    <i class="fa-brands fa-google mr-1 text-xs" aria-hidden="true"></i>
                                    {{ $review['date'] ? \Illuminate\Support\Carbon::parse($review['date'])->locale('pt_BR')->diffForHumans() : 'Avaliação no Google' }}
                                </span>
                            </span>
                        </footer>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="cs-wrap mt-4">
            {{-- Barra de progresso em segmentos, um por avaliação. Só visual (com
                 dezenas de avaliações, cada segmento fica pequeno demais para
                 toque): o mouse pode clicar, a navegação acessível são as setas. --}}
            <div class="mx-auto flex max-w-[560px] gap-1" aria-hidden="true">
                @foreach ($reviews as $review)
                    <span @click="ir(margem + {{ $loop->index }})" class="group flex-1 cursor-pointer py-2">
                        <span class="block h-1 overflow-hidden rounded-full bg-plum/15 transition-colors group-hover:bg-plum/30">
                            <span class="block h-full origin-left rounded-full bg-plum"
                                :style="`transform: scaleX(${preenchimento({{ $loop->index }})})`"></span>
                        </span>
                    </span>
                @endforeach
            </div>

            <div class="mt-5 flex items-center justify-center gap-4">
                <button type="button" @click="avancar(-1)" aria-label="Avaliação anterior"
                    class="grid h-12 w-12 place-items-center rounded-full border border-plum text-plum transition hover:bg-plum hover:text-white">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                </button>
                <button type="button" @click="parado = !parado"
                    :aria-label="parado ? 'Retomar passagem automática' : 'Pausar passagem automática'"
                    class="grid h-12 w-12 place-items-center rounded-full text-ink-soft transition hover:bg-white hover:text-plum">
                    <i class="fa-solid" :class="parado ? 'fa-play' : 'fa-pause'" aria-hidden="true"></i>
                </button>
                <button type="button" @click="avancar(1)" aria-label="Próxima avaliação"
                    class="grid h-12 w-12 place-items-center rounded-full border border-plum text-plum transition hover:bg-plum hover:text-white">
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </section>
@endif
