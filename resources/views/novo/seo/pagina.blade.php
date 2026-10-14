{{-- Página de SEO /{termo}/{localidade}. Os textos vêm de App\Services\PaginaSeo::montar()
     (banco: seo_termos, seo_localidades, seo_paginas, seo_blocos); aqui só o layout. --}}
@php
    // Perguntas do serviço do termo e as da Reforma Tributária (a página também fala dela)
    $faqs = $servico ? collect(config('faqs'))->whereIn('tema', array_merge($servico['faq'], ['reforma']))->values()->all() : [];
    $termoLinks = $termo->canonical ?: $termo->slug;
    $foto = $servico ? 'assets/servicos/detalhes/'.$servico['image'].'/imagem1.jpg' : null;
@endphp

<x-novo.pagina :titulo="$h1" :descricao="$subtitulo" :descricao-seo="$descricao_seo" :titulo-aba="$titulo_seo"
    :canonical="$canonical" :robots="$robots"
    :keywords="mb_strtolower($termo->nome).' em '.$local->nome.', '.mb_strtolower($termo->nome).', advocacia tributária '.$local->nome.', advogada tributarista, advogado tributarista, Cassia Souza'"
    :schema="[$servico ?\App\Support\Schema::servico($servico, $local->tipo === 'municipio' ? $local->nome : null) : null, \App\Support\Schema::faq($faqs)]"
    :imagem="'assets/images/'.($servico['banner'] ?? 'banner-servicos.jpg')"
    :breadcrumbs="[
        ['label' => 'Home', 'url' => route('inicio')],
        ['label' => $termo->nome, 'url' => url('/'.$termo->slug)],
        ['label' => $local->nome],
    ]">

    <section aria-labelledby="abertura-titulo" class="bg-white py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap grid items-start gap-14 lg:grid-cols-[1.1fr_0.9fr] lg:gap-20">
            <div>
                <h2 id="abertura-titulo" class="font-display text-[clamp(30px,3.6vw,46px)] font-semibold leading-[1.08] tracking-[-0.015em] text-plum-night">
                    {{ $termo->nome }} para empresas de {{ $local->nome }}
                </h2>
                <div class="mt-7 space-y-5 text-[18px] leading-relaxed">
                    @foreach ($introducao as $paragrafo)
                        <p>{{ $paragrafo }}</p>
                    @endforeach
                </div>

                @if ($homonimos->isNotEmpty())
                    <div class="mt-9 rounded-2xl border border-line bg-mist p-6">
                        <p class="font-semibold text-plum-night">Há mais de uma cidade chamada {{ $local->nome }}. Qual é a sua?</p>
                        <ul class="mt-4 flex flex-wrap gap-2">
                            @foreach ($homonimos as $cidade)
                                <li>
                                    <a href="{{ url('/'.$termoLinks.'/'.$cidade->slug) }}"
                                        class="inline-flex rounded-full border border-line bg-white px-4 py-2 text-[15px] font-semibold text-plum transition-colors hover:border-plum">
                                        {{ $cidade->nome }} ({{ $cidade->uf }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-10 flex flex-wrap items-center gap-x-7 gap-y-4">
                    <x-link-whatsapp rel="nofollow"
                        class="inline-flex items-center gap-2.5 rounded-full bg-plum px-7 py-4 font-semibold text-white transition hover:bg-plum-deep">
                        <i class="fab fa-whatsapp text-xl" aria-hidden="true"></i> Conversar no WhatsApp
                    </x-link-whatsapp>
                    <a href="#contato"
                        class="font-semibold text-plum underline decoration-plum/40 underline-offset-[6px] transition-[color,text-decoration-color,text-underline-offset] hover:decoration-plum hover:underline-offset-[3px]">Enviar uma mensagem</a>
                </div>
            </div>

            {{-- Como é o atendimento: presencial no Alto Tietê, online no resto do país --}}
            <aside aria-labelledby="atendimento-titulo" class="overflow-hidden rounded-2xl bg-white shadow-[0_40px_80px_-40px_rgba(58,6,55,0.5)] lg:sticky lg:top-10">
                @if ($foto)
                    <img src="{{ asset($foto) }}" alt="" width="735" height="509" loading="lazy" class="block aspect-[735/360] h-auto w-full object-cover">
                @endif
                <div class="cs-plum-bg relative p-8 text-white">
                    <h2 id="atendimento-titulo" class="font-display text-[26px] font-semibold leading-snug">{{ $atendimento['titulo'] }}</h2>
                    <div class="mt-4 space-y-3 text-[15px] leading-relaxed text-on-plum">
                        @foreach ($atendimento['paragrafos'] as $paragrafo)
                            <p>{{ $paragrafo }}</p>
                        @endforeach
                    </div>
                    <x-link-whatsapp rel="nofollow"
                        class="mt-6 inline-flex items-center gap-2.5 rounded-full bg-champagne px-6 py-3 font-semibold text-plum-night transition hover:bg-champagne-light hover:text-plum-night">
                        <i class="fab fa-whatsapp text-lg" aria-hidden="true"></i> {{ config('site.whatsapp') }}
                    </x-link-whatsapp>
                </div>
            </aside>
        </div>
    </section>

    @if ($secoes)
        <section aria-label="Mais sobre o atendimento em {{ $local->nome }}" class="bg-mist py-[clamp(72px,9vw,128px)]">
            <div class="cs-wrap divide-y divide-line">
                @foreach ($secoes as $secao)
                    <div class="grid gap-6 py-10 first:pt-0 last:pb-0 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20">
                        <h2 class="font-display text-[clamp(26px,2.8vw,36px)] font-semibold leading-[1.12] tracking-[-0.01em] text-plum-night">
                            {{ $secao['titulo'] }}
                        </h2>
                        <div class="space-y-5 text-[17px] leading-relaxed">
                            @foreach ($secao['paragrafos'] as $paragrafo)
                                <p>{{ $paragrafo }}</p>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section aria-labelledby="servicos-titulo" class="bg-white py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap">
            <div class="grid items-end gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16">
                <h2 id="servicos-titulo" class="font-display text-[clamp(34px,4vw,54px)] font-semibold leading-[1.05] tracking-[-0.015em] text-plum-night">
                    Qual é a situação da sua empresa?
                </h2>
                <p class="max-w-[30em] text-[17px] leading-relaxed text-ink-soft">
                    Os mesmos serviços para empresas de {{ $local->nome }} e de qualquer cidade do país. Encontre o seu caso.
                </p>
            </div>

            <x-novo.servicos-grade class="mt-12" />
        </div>
    </section>

    <x-novo.avaliacoes class="bg-mist" />

    @if ($faqs)
        <x-novo.faq :faqs="$faqs" class="bg-white" />
    @endif

    {{-- Em outros lugares: outros serviços nesta cidade, cidades vizinhas e
         cidades em destaque. Links só para os termos principais (os sinônimos
         apontam para eles pelo canonical). --}}
    @php
        $nomeCidade = fn ($c) => $c->nome.($c->uf && $c->uf !== 'SP' ? ' ('.$c->uf.')' : '');
        $grupos = array_filter([
            'Alto Tietê' => $destaques->where('presencial', true),
            'Grande São Paulo' => $destaques->where('uf', 'SP')->where('capital', false)->where('presencial', false),
            'Capitais' => $destaques->where('capital', true),
        ], fn ($cidades) => $cidades->isNotEmpty());
    @endphp
    <section aria-labelledby="lugares-titulo" class="bg-mist py-[clamp(64px,8vw,104px)]">
        <div class="cs-wrap">
            <h2 id="lugares-titulo" class="max-w-[20em] font-display text-[clamp(28px,3vw,40px)] font-semibold leading-[1.1] text-plum-night">
                Atendimento em {{ $local->nome }} e em outros lugares
            </h2>

            <div class="mt-10 grid gap-12 lg:grid-cols-2 lg:gap-16">
                @if ($outrosTermos->isNotEmpty())
                    <div>
                        <h3 class="text-sm font-semibold text-gold-ink">Outros serviços em {{ $local->nome }}</h3>
                        <ul class="mt-3 border-t border-line">
                            @foreach ($outrosTermos as $outro)
                                <li class="border-b border-line">
                                    <a href="{{ url('/'.$outro->slug.'/'.$local->slug) }}"
                                        class="group flex items-center justify-between gap-4 py-3.5 font-semibold text-plum-night transition-colors hover:text-plum">
                                        {{ $outro->nome }} em {{ $local->nome }}
                                        <i class="fa-solid fa-arrow-right text-sm text-plum transition-transform duration-200 motion-safe:group-hover:translate-x-1" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($vizinhas->isNotEmpty())
                    <div>
                        <h3 class="text-sm font-semibold text-gold-ink">
                            {{ ($local->presencial || ! $local->microrregiao) ? 'No Alto Tietê' : 'Na região de '.$local->microrregiao }}
                        </h3>
                        <ul class="mt-3 border-t border-line">
                            @foreach ($vizinhas as $vizinha)
                                <li class="border-b border-line">
                                    <a href="{{ url('/'.$termoLinks.'/'.$vizinha->slug) }}"
                                        class="group flex items-center justify-between gap-4 py-3.5 font-semibold text-plum-night transition-colors hover:text-plum">
                                        {{ $termo->nome }} em {{ $vizinha->nome }}
                                        <i class="fa-solid fa-arrow-right text-sm text-plum transition-transform duration-200 motion-safe:group-hover:translate-x-1" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            @foreach ($grupos as $grupo => $cidades)
                <div class="mt-12">
                    <h3 class="text-sm font-semibold text-gold-ink">{{ $termo->nome }}: {{ $grupo }}</h3>
                    <ul class="mt-4 flex flex-wrap gap-2">
                        @foreach ($cidades as $cidade)
                            <li>
                                <a href="{{ url('/'.$termoLinks.'/'.$cidade->slug) }}"
                                    class="inline-flex rounded-full border border-line bg-white px-4 py-2 text-[15px] font-medium text-plum-night transition-colors hover:border-plum hover:text-plum">
                                    {{ $nomeCidade($cidade) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </section>
</x-novo.pagina>
