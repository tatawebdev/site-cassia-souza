<x-novo.layout title="Cássia Souza Advocacia Tributária">
    @php
        $faqs = [
            [
                'question' => 'Como saber se meu regime tributário é o mais vantajoso para minha empresa?',
                'answer' => 'A escolha do regime ideal depende do seu faturamento, das suas margens de lucro e da sua atividade. Fazemos uma
    análise personalizada para simular o custo de cada regime e mostrar qual alternativa traz mais economia sem
    riscos.',
            ],
            [
                'question' => 'O que muda para minha empresa com a Reforma Tributária?',
                'answer' => 'A Reforma vai alterar toda a tributação sobre o consumo. Teremos novas bases de cálculo, formas de apuração,
    alíquotas e obrigações acessórias. Isso significa que o que hoje é vantajoso pode deixar de ser — ou vice‑versa.
    Nossa assessoria ajuda a entender quais mudanças vão afetar sua empresa e como ajustar a estrutura para manter
    segurança e evitar surpresas.',
            ],
            [
                'question' => 'Consultoria tributária mensal realmente vale a pena para resultados consistentes?',
                'answer' => 'Sim, quando feita com constância. O acompanhamento regular permite identificar erros operacionais cedo, ajustar
    práticas conforme novas normas, evitar autuações e identificar oportunidades de economia, mantendo a tranquilidade
    tributária enquanto sua empresa cresce.',
            ],
            [
                'question' =>
                    'Minha empresa do Simples Nacional pode recuperar PIS e COFINS monofásicos pagos indevidamente?',
                'answer' => 'Sim — em muitos casos. Se você comercializa produtos sujeitos à tributação monofásica e os recolhimentos foram
    feitos nesses casos, pode haver crédito a recuperar. O primeiro passo é revisar suas notas fiscais, identificar
    produtos monofásicos e verificar se houve pagamento indevido no seu DAS.',
            ],
            [
                'question' => 'Qual é o prazo para recuperar tributos pagos indevidamente de PIS e COFINS monofásicos?',
                'answer' => 'O direito de restituição ou compensação abrange os últimos 5 anos (60 meses).',
            ],
            [
                'question' => 'Quais produtos estão sujeitos à tributação monofásica de PIS e COFINS?',
                'answer' => 'A lista inclui medicamentos, cosméticos, certos produtos farmacêuticos, bebidas frias, entre outros, de acordo com
    a NCM usada nas notas fiscais.',
            ],
            [
                'question' => 'Como negociar débitos federais inscritos em Dívida Ativa da União?',
                'answer' => 'É possível aderir a programas de transação tributária que concedem descontos nos juros e nas multas e parcelamento
    especial. O primeiro passo é estudar o débito, verificar a capacidade de pagamento e entender se a empresa se
    enquadra nos critérios exigidos nos editais.',
            ],
        ];

        $faqs = collect($faqs)->shuffle()->take(5)->values()->all();
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

                <ul class="m-0 mt-12 grid list-none gap-6 p-0 md:grid-cols-2 lg:grid-cols-3">
                    @foreach (config('servicos') as $service)
                        @php $featured = $loop->first || $loop->last; @endphp
                        <li class="{{ $featured ? 'md:col-span-2' : '' }}">
                            <a href="{{ route($service['route']) }}"
                                class="group grid h-full overflow-hidden rounded-2xl border border-line bg-white shadow-[0_24px_48px_-32px_rgba(58,6,55,0.45)] transition duration-300 ease-out-soft hover:-translate-y-1 hover:shadow-[0_32px_64px_-32px_rgba(58,6,55,0.6)] {{ $featured ? 'lg:grid-cols-2' : '' }} {{ $loop->last ? 'lg:[&>figure]:order-2' : '' }}">
                                <figure class="relative m-0 h-52 overflow-hidden {{ $featured ? 'lg:h-full lg:min-h-[300px]' : '' }}">
                                    <img src="{{ asset('assets/servicos/detalhes/' . $service['image'] . '/imagem1.jpg') }}"
                                        alt="" loading="lazy" width="735" height="509"
                                        class="h-full w-full object-cover transition-transform duration-500 ease-out-soft group-hover:scale-[1.04]">
                                    <div class="absolute inset-0 bg-gradient-to-t from-plum-night/40 to-transparent" aria-hidden="true"></div>
                                </figure>
                                <div class="flex flex-col p-6 sm:p-7 {{ $featured ? 'lg:justify-center lg:p-10' : '' }}">
                                    <span class="text-sm font-semibold text-gold-ink">{{ $service['title'] }}</span>
                                    <span class="mt-2 font-display font-semibold leading-tight tracking-[-0.01em] text-plum-night {{ $featured ? 'text-[clamp(24px,2.4vw,32px)]' : 'text-[22px]' }}">{{ $service['problem'] }}</span>
                                    <span class="mt-3 text-[15px] leading-relaxed text-ink-soft">{{ $service['text'] }}</span>
                                    <span class="mt-auto flex items-center gap-3 pt-6 text-[15px] font-semibold text-plum">
                                        <span class="grid h-9 w-9 place-items-center rounded-full bg-plum text-white transition-transform duration-200 ease-out-soft group-hover:translate-x-1" aria-hidden="true">
                                            <i class="fa-solid fa-arrow-right text-sm"></i>
                                        </span>
                                        Ver solução
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
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

        <section aria-labelledby="faq-titulo" class="bg-white py-[clamp(72px,9vw,128px)]">
            <div class="cs-wrap grid items-start gap-12 lg:grid-cols-[0.85fr_1.15fr] lg:gap-16">
                <div class="lg:sticky lg:top-10">
                    <h2 id="faq-titulo" class="font-display text-[clamp(34px,4vw,54px)] font-semibold leading-[1.05] tracking-[-0.015em] text-plum-night">
                        Perguntas frequentes
                    </h2>
                    <p class="mt-5 max-w-[26em] text-[17px] leading-relaxed text-ink-soft">
                        As dúvidas que mais ouvimos de empresários sobre regime tributário, créditos e dívidas.
                    </p>
                    <div class="cs-plum-bg relative mt-10 overflow-hidden rounded-2xl p-8 text-white">
                        <p class="font-display text-2xl font-semibold leading-snug">Não encontrou a sua dúvida?</p>
                        <p class="mt-2 text-[15px] leading-relaxed text-on-plum">Conte o seu caso e respondemos pessoalmente.</p>
                        <x-link-whatsapp rel="nofollow"
                            class="mt-6 inline-flex items-center gap-2.5 rounded-full bg-champagne px-6 py-3 font-semibold text-plum-night transition hover:bg-champagne-light hover:text-plum-night">
                            <i class="fab fa-whatsapp text-lg" aria-hidden="true"></i> Perguntar no WhatsApp
                        </x-link-whatsapp>
                    </div>
                </div>

                <div class="border-t border-line">
                    @foreach ($faqs as $faq)
                        <details class="group border-b border-line" @if ($loop->first) open @endif>
                            <summary class="grid cursor-pointer list-none grid-cols-[minmax(0,1fr)_32px] items-center gap-6 py-6 [&::-webkit-details-marker]:hidden">
                                <h3 class="font-display text-[22px] font-semibold leading-snug text-plum-night transition-colors group-hover:text-plum">{{ $faq['question'] }}</h3>
                                <span class="relative grid h-8 w-8 place-items-center rounded-full bg-mist transition duration-200 ease-out-soft group-open:rotate-45 group-open:bg-plum" aria-hidden="true">
                                    <span class="absolute h-0.5 w-3 bg-plum group-open:bg-white"></span>
                                    <span class="absolute h-3 w-0.5 bg-plum group-open:bg-white"></span>
                                </span>
                            </summary>
                            <p class="max-w-[42em] pb-7 text-base leading-relaxed text-ink-soft">{{ preg_replace('/\s+/u', ' ', $faq['answer']) }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <x-novo.contato />
    </main>
</x-novo.layout>
