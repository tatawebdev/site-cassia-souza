<x-novo.pagina tipo-pagina="AboutPage"
    titulo="Sobre a Cássia Souza Advocacia"
    imagem="assets/images/banner-sobre-nos.jpg"
    descricao="Escritório de Direito Tributário focado em estratégia, segurança jurídica e resultados reais para empresas de todos os portes."
    :breadcrumbs="[['label' => 'Home', 'url' => route('inicio')], ['label' => 'Sobre']]">

    <section aria-labelledby="quem-titulo" class="overflow-hidden bg-white py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap grid items-center gap-14 lg:grid-cols-[0.95fr_1.05fr] lg:gap-20">
            <figure class="relative m-0 mx-auto w-full max-w-[520px]">
                <img src="/assets/img/sobrenos.png" alt="Cássia Souza, advogada tributarista, em seu escritório"
                    width="1080" height="1080" fetchpriority="high"
                    class="block aspect-square h-auto w-full rounded-2xl object-cover object-[55%_30%] shadow-[0_40px_80px_-40px_rgba(58,6,55,0.5)]">
                <figcaption class="absolute -bottom-6 left-6 right-6 rounded-xl bg-plum-night px-6 py-5 text-white shadow-[0_24px_48px_-16px_rgba(36,4,31,0.45)] sm:-right-8 sm:left-auto sm:max-w-[300px]">
                    <span class="block font-display text-2xl font-semibold leading-tight">“Eu simplifico a tributação.”</span>
                    <span class="mt-2 block text-sm text-on-plum/80">Cássia Souza, advogada tributarista</span>
                </figcaption>
            </figure>

            <div>
                <h2 id="quem-titulo" class="font-display text-[clamp(32px,3.6vw,48px)] font-semibold leading-[1.08] tracking-[-0.015em] text-plum-night">
                    Especialistas em advocacia tributária
                </h2>
                <div class="mt-6 space-y-5 text-[17px] leading-relaxed">
                    <p>
                        O sistema tributário brasileiro é extremamente complexo. Para muitos empresários, lidar com
                        impostos é sinônimo de insegurança, ansiedade e medo de estar sempre “um passo atrás” do Fisco.
                    </p>
                    <p>
                        Nós sabemos disso, porque estamos ao lado de empresas que já viveram essa realidade. Mas
                        acreditamos em outro caminho: o da clareza, da regularidade e da estratégia.
                    </p>
                    <p>
                        Não somos apenas um escritório de advocacia ou de consultoria tributária. Somos parceiros que
                        caminham junto com você, ajudando a reduzir impostos de forma legal, recuperar tributos pagos
                        indevidamente, regularizar dívidas e preparar sua empresa para as transformações que já estão
                        acontecendo, como a Reforma Tributária.
                    </p>
                </div>

                {{-- Quem atende: só fatos confirmados (OAB/SP pelo e-mail institucional,
                     Suzano pelo perfil no Google) --}}
                <dl class="mt-9 grid gap-x-8 gap-y-5 border-t border-line pt-7 sm:grid-cols-3">
                    <div>
                        <dt class="text-sm text-ink-soft">Advogada responsável</dt>
                        <dd class="mt-1 font-semibold text-plum-night">Cássia Souza</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-ink-soft">Inscrição</dt>
                        <dd class="mt-1 font-semibold text-plum-night">OAB/SP</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-ink-soft">Base</dt>
                        <dd class="mt-1 font-semibold text-plum-night">Suzano, SP</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    <section aria-labelledby="publico-titulo" class="bg-white pb-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap">
            <h2 id="publico-titulo" class="max-w-[18em] font-display text-[clamp(32px,3.6vw,48px)] font-semibold leading-[1.08] tracking-[-0.015em] text-plum-night">
                Empresas de todos os portes e segmentos
            </h2>
            <p class="mt-5 max-w-[40em] text-[17px] leading-relaxed text-ink-soft">
                Comércio, serviços, indústria ou saúde: do pequeno negócio no Simples Nacional à empresa com
                contabilidade estruturada. Algumas situações que aparecem com frequência:
            </p>
            <div class="mt-12 grid gap-x-10 gap-y-10 md:grid-cols-3">
                @foreach ([
                    ['fa-store', 'No Simples Nacional', 'Quem vende produtos monofásicos pode ter PIS/COFINS a recuperar; quem tem débitos pode negociar com a PGFN.'],
                    ['fa-building', 'Com contabilidade estruturada', 'Consultoria mensal e planejamento contínuo para decidir com segurança e atravessar a Reforma Tributária.'],
                    ['fa-stethoscope', 'Na área da saúde', 'Clínicas médicas e odontológicas podem reduzir a carga com a equiparação hospitalar no Lucro Presumido.'],
                ] as [$icone, $titulo, $texto])
                    <div class="border-t-2 border-plum pt-6">
                        <h3 class="flex items-center gap-3 font-display text-2xl font-semibold leading-tight text-plum-night">
                            <i class="fa-solid {{ $icone }} text-lg text-gold-ink" aria-hidden="true"></i>{{ $titulo }}
                        </h3>
                        <p class="mt-3 text-[17px] leading-relaxed text-ink-soft">{{ $texto }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Missão: a frase da Cássia em destaque, sem rótulo acima --}}
    <section aria-label="Nossa missão" class="cs-plum-bg relative overflow-hidden py-[clamp(72px,9vw,128px)] text-white">
        <i class="fa-solid fa-quote-left pointer-events-none absolute left-[6%] top-10 text-[clamp(96px,14vw,200px)] leading-none text-champagne/10" aria-hidden="true"></i>
        <div class="cs-wrap relative text-center">
            <p class="mx-auto max-w-[23ch] font-display text-[clamp(32px,4.4vw,58px)] font-semibold leading-[1.1] tracking-[-0.02em] [text-wrap:balance]">
                <span class="text-champagne">Nossa missão é simples:</span>
                ajudar os empresários a tomar decisões mais estratégicas para o seu negócio.
            </p>
        </div>
    </section>

    <section aria-labelledby="compromisso-titulo" class="bg-white py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap grid gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:gap-20">
            <div>
                <h2 id="compromisso-titulo" class="font-display text-[clamp(32px,3.6vw,48px)] font-semibold leading-[1.08] tracking-[-0.015em] text-plum-night">
                    Comprometidos em gerar resultados reais
                </h2>
                <p class="mt-6 text-[17px] leading-relaxed">
                    Cada empresa tem sua própria história, desafios e sonhos. Por isso, não existe solução única
                    quando o assunto é tributação. Nosso papel é caminhar ao lado do empresário com estratégias
                    jurídicas personalizadas, que tragam tranquilidade, previsibilidade e crescimento sustentável.
                </p>
                <a href="{{ route('inicio') }}#situacoes"
                    class="mt-10 inline-flex items-center gap-2 rounded-full border border-plum px-7 py-3.5 font-semibold text-plum transition-colors hover:bg-plum hover:text-white">Conheça os serviços</a>
            </div>

            <ul class="divide-y divide-line border-y border-line">
                @foreach ([
                    ['Sob medida', 'Estratégias tributárias pensadas para a realidade da sua empresa, não modelos prontos.'],
                    ['Economia dentro da lei', 'Identificação de oportunidades de economia com base na legislação vigente.'],
                    ['Segurança jurídica', 'Decisões mais estratégicas e resultados consistentes, sem surpresas com o Fisco.'],
                ] as [$titulo, $texto])
                    <li class="grid gap-2 py-7 sm:grid-cols-[15rem_1fr] sm:gap-8">
                        <span class="font-display text-2xl font-semibold text-plum-night">{{ $titulo }}</span>
                        <span class="text-[17px] leading-relaxed text-ink-soft">{{ $texto }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section aria-labelledby="areas-titulo" class="bg-mist py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20">
            <div>
                <h2 id="areas-titulo" class="font-display text-[clamp(32px,3.6vw,48px)] font-semibold leading-[1.08] tracking-[-0.015em] text-plum-night">
                    Áreas de atuação
                </h2>
                <p class="mt-5 max-w-[26em] text-[17px] leading-relaxed text-ink-soft">
                    Da consultoria mensal às frentes específicas de recuperação de créditos e regularização de dívidas.
                </p>
            </div>
            <ul class="grid gap-x-8 sm:grid-cols-2">
                @foreach (config('servicos') as $servico)
                    <li class="border-b border-line">
                        <a href="{{ route($servico['route']) }}"
                            class="group flex items-center justify-between gap-4 py-5 font-semibold text-plum-night transition-colors hover:text-plum">
                            {{ $servico['title'] }}
                            <i class="fa-solid fa-arrow-right text-sm text-plum transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <x-novo.avaliacoes class="bg-white" />

    <section aria-labelledby="conteudo-titulo" class="bg-white pb-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap">
            <div class="flex flex-col gap-8 rounded-2xl border border-line bg-[radial-gradient(120%_80%_at_100%_0%,#FFF6EA_0%,#F5F1F4_60%)] p-8 sm:p-10 xl:flex-row xl:items-center xl:justify-between">
                <div class="max-w-[30em]">
                    <h2 id="conteudo-titulo" class="font-display text-[clamp(26px,2.8vw,36px)] font-semibold leading-tight text-plum-night">
                        Tributação explicada sem complicação
                    </h2>
                    <p class="mt-3 text-[17px] leading-relaxed text-ink-soft">
                        A Cássia compartilha conteúdo sobre Reforma Tributária, créditos e regularização nas redes e no blog.
                    </p>
                </div>
                <ul class="flex shrink-0 flex-wrap gap-3 xl:flex-nowrap">
                    @foreach (config('site.social_icons', []) as $rede)
                        <li>
                            <a href="{{ $rede['url'] }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-full border border-plum/30 bg-white px-5 py-3 font-semibold text-plum transition-colors hover:border-plum hover:bg-plum hover:text-white">
                                <i class="{{ $rede['icon_class'] }}" aria-hidden="true"></i>{{ ucfirst($rede['name'] === 'linkedin' ? 'LinkedIn' : ($rede['name'] === 'tiktok' ? 'TikTok' : $rede['name'])) }}
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="https://blog.cassiasouzaadvocacia.com.br/"
                            class="inline-flex items-center gap-2 rounded-full bg-plum px-5 py-3 font-semibold text-white transition-colors hover:bg-plum-deep">
                            <i class="fa-solid fa-book-open" aria-hidden="true"></i>Blog
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</x-novo.pagina>
