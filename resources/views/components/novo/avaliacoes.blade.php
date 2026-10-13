{{-- Avaliações reais do perfil da Cássia no Google, em config/avaliacoes.php
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
        {{-- Loop infinito: os cards são renderizados 3 vezes e a posição (pos)
             fica na cópia do meio; ao sair dela, volta sem animação para o card
             equivalente, então sempre há vizinhos dos dois lados. --}}
        x-data="{
            total: {{ count($reviews) }},
            duracoes: @js($duracoes),
            pos: {{ count($reviews) }},
            progresso: 0,
            deslocamento: 0,
            semAnimacao: false,
            pausado: false,
            parado: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
            inicioToque: null,
            get atual() { return this.pos % this.total },
            init() {
                this.$nextTick(() => this.medir());
                window.addEventListener('resize', () => this.medir());

                let anterior = performance.now();
                const passo = (agora) => {
                    if (! this.pausado && ! this.parado) {
                        this.progresso += (agora - anterior) / this.duracoes[this.atual];
                        if (this.progresso >= 1) this.ir(this.pos + 1);
                    }
                    anterior = agora;
                    requestAnimationFrame(passo);
                };
                requestAnimationFrame(passo);
            },
            ir(p) {
                this.pos = p;
                this.progresso = 0;
                this.medir();
            },
            medir() {
                const cards = this.$refs.trilho.children;
                const largura = cards[1].offsetLeft - cards[0].offsetLeft;
                this.deslocamento = (this.$refs.janela.clientWidth - cards[0].offsetWidth) / 2 - this.pos * largura;
            },
            reposicionar() {
                if (this.pos >= this.total && this.pos < 2 * this.total) return;
                this.semAnimacao = true;
                this.pos = this.total + this.atual;
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
                if (Math.abs(dx) > 50) this.ir(this.pos + (dx < 0 ? 1 : -1));
                this.inicioToque = null;
            },
        }"
        @mouseenter="pausado = true" @mouseleave="pausado = false"
        @focusin="pausado = true" @focusout="pausado = false"
        @keydown.arrow-right="ir(pos + 1)" @keydown.arrow-left="ir(pos - 1)">
        <div class="cs-wrap">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <h2 id="avaliacoes-titulo" class="max-w-[16em] font-display text-[clamp(34px,4vw,54px)] font-semibold leading-[1.05] tracking-[-0.015em] text-plum-night">
                    O que dizem os clientes atendidos
                </h2>

                @if ($nota)
                    <div class="flex items-center gap-4">
                        <span class="font-display text-5xl font-semibold leading-none text-plum-night">{{ number_format($nota, 1, ',', '') }}</span>
                        <span>
                            <span class="flex gap-0.5 text-champagne-dark" aria-label="Nota {{ number_format($nota, 1, ',', '') }} de 5">
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
                @foreach ([0, 1, 2] as $copia)
                @foreach ($reviews as $review)
                    @php $k = $copia * count($reviews) + $loop->index; @endphp
                    <li @click="pos !== {{ $k }} && ir({{ $k }})"
                        {{-- Só a cópia do meio existe para leitores de tela --}}
                        @if ($copia === 1)
                            :aria-hidden="(pos !== {{ $k }}).toString()"
                            aria-roledescription="avaliação" aria-label="{{ $loop->iteration }} de {{ count($reviews) }}"
                        @else
                            aria-hidden="true"
                        @endif
                        :class="pos === {{ $k }}
                            ? 'scale-100 opacity-100 shadow-[0_40px_80px_-40px_rgba(58,6,55,0.55)]'
                            : 'scale-[0.88] cursor-pointer opacity-45 shadow-none'"
                        class="relative flex w-[82vw] shrink-0 flex-col overflow-hidden rounded-2xl border border-line/80 bg-[radial-gradient(120%_70%_at_0%_0%,#FFF6EA_0%,#FFFFFF_45%,#F8F2F7_100%)] p-7 transition duration-700 ease-out-soft motion-reduce:transition-none sm:w-[440px] sm:p-9">
                        <div class="flex items-start justify-between">
                            <span class="flex gap-0.5 text-champagne-dark" aria-label="{{ $review['rating'] }} de 5 estrelas">
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
                                <img src="{{ asset($review['photo']) }}" alt="" width="44" height="44" loading="lazy" draggable="false"
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
                @endforeach
            </ul>
        </div>

        <div class="cs-wrap mt-4">
            {{-- Barra de progresso em segmentos, um por avaliação --}}
            <div class="mx-auto flex max-w-[560px] gap-1" role="group" aria-label="Escolher avaliação">
                @foreach ($reviews as $review)
                    <button type="button" @click="ir(total + {{ $loop->index }})"
                        aria-label="Ir para a avaliação {{ $loop->iteration }}"
                        :aria-current="(atual === {{ $loop->index }}).toString()"
                        class="group flex-1 py-2">
                        <span class="block h-1 overflow-hidden rounded-full bg-plum/15 transition-colors group-hover:bg-plum/30">
                            <span class="block h-full origin-left rounded-full bg-plum"
                                :style="`transform: scaleX(${preenchimento({{ $loop->index }})})`"></span>
                        </span>
                    </button>
                @endforeach
            </div>

            <div class="mt-5 flex items-center justify-center gap-4">
                <button type="button" @click="ir(pos - 1)" aria-label="Avaliação anterior"
                    class="grid h-12 w-12 place-items-center rounded-full border border-plum text-plum transition hover:bg-plum hover:text-white">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                </button>
                <button type="button" @click="parado = !parado"
                    :aria-label="parado ? 'Retomar passagem automática' : 'Pausar passagem automática'"
                    class="grid h-12 w-12 place-items-center rounded-full text-ink-soft transition hover:bg-white hover:text-plum">
                    <i class="fa-solid" :class="parado ? 'fa-play' : 'fa-pause'" aria-hidden="true"></i>
                </button>
                <button type="button" @click="ir(pos + 1)" aria-label="Próxima avaliação"
                    class="grid h-12 w-12 place-items-center rounded-full border border-plum text-plum transition hover:bg-plum hover:text-white">
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </section>
@endif
