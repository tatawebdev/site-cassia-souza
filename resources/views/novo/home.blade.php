<x-novo.layout title="Cássia Souza Advocacia Tributária">
    @php
        // Amostra aleatória das perguntas frequentes (config/faqs.php)
        $faqs = collect(config('faqs'))->shuffle()->take(5)->values()->all();
    @endphp

    <div class="cs-plum-bg relative overflow-hidden text-white">
        {{-- Monograma do logo como marca d'água --}}
        <img src="/assets/images/logo-acinzentado.png" alt="" aria-hidden="true"
            class="pointer-events-none absolute -bottom-24 -left-28 w-[720px] max-w-none select-none opacity-[0.05]">

        @include('novo.partials.header')

        <section class="relative lg:min-h-[620px]">
            {{-- Foto sangrando até a borda direita, fundida ao roxo pela esquerda --}}
            <figure class="relative m-0 h-[360px] sm:h-[460px] lg:absolute lg:inset-y-0 lg:right-0 lg:h-auto lg:w-[46%]">
                <img src="/assets/img/sobrenos.png" alt="Cássia Souza, advogada tributarista, em seu escritório"
                    width="1080" height="1080" fetchpriority="high"
                    class="block h-full w-full object-cover object-[60%_28%] motion-safe:animate-unveil">
                <div class="absolute inset-0 bg-gradient-to-t from-plum-deep via-plum-deep/10 to-transparent lg:bg-gradient-to-r lg:from-plum-deep lg:via-plum-deep/10 lg:to-transparent" aria-hidden="true"></div>
            </figure>

            <div class="cs-wrap relative pb-12 pt-8 sm:pb-[150px] lg:pb-[190px] lg:pt-[72px]">
                <div class="max-w-[640px]">
                    <h1 class="font-display text-[clamp(40px,4.7vw,68px)] font-semibold leading-[1.02] tracking-[-0.02em] text-white">
                        <span class="block overflow-hidden pb-[0.06em]"><span class="block motion-safe:animate-rise">Está pagando além</span></span>
                        <span class="block overflow-hidden pb-[0.06em]"><span class="block motion-safe:animate-rise motion-safe:[animation-delay:90ms]">do justo em impostos?</span></span>
                    </h1>
                    <p class="mt-6 max-w-[34em] text-lg leading-relaxed text-on-plum motion-safe:animate-fade">
                        Identificamos reduções legais, regularizamos dívidas, recuperamos tributos e preparamos sua
                        empresa para a Reforma Tributária — com clareza, ética e planejamento.
                    </p>
                    <div class="mt-9 flex flex-wrap items-center gap-x-7 gap-y-4 motion-safe:animate-fade">
                        <x-link-whatsapp rel="nofollow"
                            class="inline-flex w-full items-center justify-center gap-2.5 rounded-full bg-champagne px-7 py-4 text-base font-semibold leading-none text-plum-night shadow-[0_12px_32px_-12px_rgba(239,207,159,0.6)] transition hover:bg-champagne-light hover:text-plum-night active:scale-[0.98] sm:w-auto">
                            <i class="fab fa-whatsapp text-xl" aria-hidden="true"></i> Conversar no WhatsApp
                        </x-link-whatsapp>
                        <a href="#situacoes"
                            class="font-semibold text-white underline decoration-champagne/60 decoration-1 underline-offset-[6px] transition-all hover:text-white hover:underline hover:decoration-champagne hover:underline-offset-[3px]">Ver como podemos ajudar</a>
                    </div>
                </div>
            </div>

            {{-- Faixa com as três frentes mais procuradas --}}
            <div class="relative z-10 border-t sm:absolute sm:inset-x-0 sm:bottom-0 border-white/10 bg-plum-night/60 backdrop-blur-md">
                <ul class="cs-wrap grid sm:grid-cols-3">
                    @foreach ([
                        ['icon' => 'fa-rotate-left', 'title' => 'Créditos dos últimos 5 anos', 'text' => 'Recuperação de PIS/COFINS monofásicos'],
                        ['icon' => 'fa-scale-balanced', 'title' => 'Dívida Ativa negociada', 'text' => 'Transação com descontos em juros e multas'],
                        ['icon' => 'fa-compass', 'title' => 'Reforma Tributária', 'text' => 'Diagnóstico de impactos e adaptação'],
                    ] as $item)
                        <li class="flex items-center gap-4 border-white/10 py-4 sm:py-6 sm:[&:not(:first-child)]:border-l sm:[&:not(:first-child)]:pl-6 max-sm:[&:not(:first-child)]:border-t">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-champagne/15 text-champagne" aria-hidden="true">
                                <i class="fa-solid {{ $item['icon'] }}"></i>
                            </span>
                            <span>
                                <span class="block text-[15px] font-semibold text-white">{{ $item['title'] }}</span>
                                <span class="block text-sm text-on-plum/80">{{ $item['text'] }}</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </div>

    <main>
        <section id="situacoes" aria-labelledby="situacoes-titulo" class="bg-mist py-[clamp(72px,9vw,128px)]">
            <div class="cs-wrap">
                <div class="grid items-end gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16">
                    <h2 id="situacoes-titulo" class="font-display text-[clamp(34px,4vw,54px)] font-semibold leading-[1.05] tracking-[-0.015em] text-plum-night">
                        Qual é a situação da sua empresa?
                    </h2>
                    <p class="max-w-[30em] text-[17px] leading-relaxed text-ink-soft">
                        Atendemos empresários e empresárias que precisam tomar decisões tributárias mais
                        estratégicas. Encontre o seu caso e veja como resolvemos.
                    </p>
                </div>

                <x-novo.servicos-grade class="mt-12" />
            </div>
        </section>

        <section aria-labelledby="sobre-titulo" class="overflow-hidden bg-white py-[clamp(72px,9vw,128px)]">
            <div class="cs-wrap grid items-center gap-14 lg:grid-cols-[0.9fr_1.1fr] lg:gap-20">
                <figure class="relative mx-auto m-0 w-full max-w-[460px]">
                    <img src="/assets/img/parceria.png" alt="Cássia Souza, advogada tributarista, sorrindo em frente ao notebook" loading="lazy"
                        width="860" height="968"
                        class="block aspect-[860/968] h-auto w-full rounded-2xl object-cover shadow-[0_40px_80px_-40px_rgba(58,6,55,0.5)]">
                    <figcaption class="absolute -bottom-6 left-6 right-6 rounded-xl bg-plum-night px-6 py-5 text-white shadow-[0_24px_48px_-16px_rgba(36,4,31,0.45)] sm:-right-8 sm:left-auto sm:max-w-[300px]">
                        <span class="block font-display text-2xl font-semibold leading-tight">“Eu simplifico a tributação.”</span>
                        <span class="mt-2 block text-sm text-on-plum/80">Cássia Souza, advogada tributarista</span>
                    </figcaption>
                </figure>

                <div>
                    <h2 id="sobre-titulo" class="font-display text-[clamp(32px,3.6vw,48px)] font-semibold leading-[1.08] tracking-[-0.015em] text-plum-night">
                        Clareza, regularidade e estratégia para quem empreende
                    </h2>
                    <p class="mt-6 text-[17px] leading-relaxed">
                        O sistema tributário brasileiro é extremamente complexo. Para muitos empresários, lidar com
                        impostos é sinônimo de insegurança e do medo de estar sempre um passo atrás do Fisco.
                        Caminhamos junto com a sua empresa para mudar isso.
                    </p>
                    <ul class="m-0 mt-8 grid list-none gap-4 p-0">
                        @foreach ([
                            'Estratégias tributárias sob medida, pensadas para a realidade da sua empresa.',
                            'Identificação de oportunidades de economia dentro da lei.',
                            'Segurança jurídica para decisões mais estratégicas e resultados consistentes.',
                        ] as $point)
                            <li class="flex gap-4 text-[17px] leading-relaxed">
                                <span class="mt-0.5 grid h-7 w-7 shrink-0 place-items-center rounded-full bg-plum/10 text-plum" aria-hidden="true">
                                    <i class="fa-solid fa-check text-xs"></i>
                                </span>
                                {{ $point }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="/sobre-nos"
                        class="mt-10 inline-flex items-center gap-2 rounded-full border border-plum px-7 py-3.5 font-semibold text-plum transition-colors hover:bg-plum hover:text-white">Conheça o escritório</a>
                </div>
            </div>
        </section>

        <x-novo.avaliacoes class="bg-mist" />

        <x-novo.faq :faqs="$faqs" class="bg-white" />

        <x-novo.contato />
    </main>
</x-novo.layout>
