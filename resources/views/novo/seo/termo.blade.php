{{-- Página do termo sem localidade (/advocacia-tributaria): o serviço ligado e as
     cidades em destaque (Alto Tietê, Grande SP e capitais). Dados de PaginaSeo::montarTermo(). --}}
@php $termoLinks = $termo->canonical ?: $termo->slug; @endphp

<x-novo.pagina :titulo="$termo->nome"
    descricao="Atendimento online para empresas de todo o Brasil e presencial em Suzano e no Alto Tietê."
    :descricao-seo="$termo->nome.' para empresas: planejamento, créditos, débitos com a PGFN e Reforma Tributária. Atendimento online em todo o Brasil.'"
    :titulo-aba="$termo->nome.' | Cassia Souza Advocacia Tributária'"
    :canonical="$canonical" :robots="$robots"
    :imagem="'assets/images/'.($servico['banner'] ?? 'banner-servicos.jpg')"
    :breadcrumbs="[['label' => 'Home', 'url' => route('inicio')], ['label' => $termo->nome]]">

    <section aria-labelledby="servicos-titulo" class="bg-mist py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap">
            <div class="grid items-end gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16">
                <h2 id="servicos-titulo" class="font-display text-[clamp(34px,4vw,54px)] font-semibold leading-[1.05] tracking-[-0.015em] text-plum-night">
                    Qual é a situação da sua empresa?
                </h2>
                <p class="max-w-[30em] text-[17px] leading-relaxed text-ink-soft">
                    Cada serviço começa pelo problema que ele resolve. Encontre o seu caso e veja como trabalhamos.
                </p>
            </div>

            <x-novo.servicos-grade class="mt-12" />
        </div>
    </section>

    <section aria-labelledby="cidades-titulo" class="bg-white py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap">
            <h2 id="cidades-titulo" class="max-w-[18em] font-display text-[clamp(30px,3.4vw,44px)] font-semibold leading-[1.1] tracking-[-0.015em] text-plum-night">
                {{ $termo->nome }} perto de você
            </h2>

            <div class="mt-12 grid gap-12 lg:grid-cols-3">
                @foreach ($grupos as $grupo => $cidades)
                    @if ($cidades->isNotEmpty())
                        <div>
                            <h3 class="text-sm font-semibold text-gold-ink">{{ $grupo }}</h3>
                            <ul class="mt-3 border-t border-line">
                                @foreach ($cidades as $cidade)
                                    <li class="border-b border-line">
                                        <a href="{{ url('/'.$termoLinks.'/'.$cidade->slug) }}"
                                            class="group flex items-center justify-between gap-4 py-3 font-semibold text-plum-night transition-colors hover:text-plum">
                                            {{ $cidade->nome }}{{ $cidade->uf !== 'SP' ? ' ('.$cidade->uf.')' : '' }}
                                            <i class="fa-solid fa-arrow-right text-xs text-plum transition-transform duration-200 motion-safe:group-hover:translate-x-1" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <x-novo.avaliacoes class="bg-mist" />
</x-novo.pagina>
