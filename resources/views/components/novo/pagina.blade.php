{{-- Layout padrão das páginas internas do tema novo: header, banner roxo com
     breadcrumb, título e descrição, o conteúdo da página e, por padrão, a seção
     de contato no fim. Equivale ao "banner" + "breadcrumbs" do layout antigo.

     <x-novo.pagina titulo="Sobre" descricao="..." :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'Sobre']]">
         ...seções...
     </x-novo.pagina>
--}}
@props([
    'titulo',
    'descricao' => null,
    // Último item é a página atual (sem url)
    'breadcrumbs' => [],
    // Título da aba; padrão: "<titulo> | Cassia Souza Advocacia Tributária"
    'tituloAba' => null,
    // Foto de fundo do banner (a mesma da página antiga, em /assets/images)
    'imagem' => null,
    'contato' => true,
    // Meta description diferente do texto do banner (padrão: a própria descrição)
    'descricaoSeo' => null,
    'canonical' => null,
    'robots' => null,
    // Dados estruturados: tipo da página (WebPage, AboutPage, ContactPage) e nós extras
    'tipoPagina' => 'WebPage',
    'schema' => [],
    // Campos extras do nó da página (o name já é o título do banner)
    'paginaSchema' => [],
    // Palavras-chave da página (padrão: as gerais do layout)
    'keywords' => null,
])

<x-novo.layout :title="$tituloAba ?? $titulo.' | Cassia Souza Advocacia Tributária'" :description="$descricaoSeo ?? $descricao ?? 'Cassia Souza Advocacia Tributária'" :canonical="$canonical" :robots="$robots"
    :breadcrumbs="$breadcrumbs" :tipo-pagina="$tipoPagina" :schema="$schema"
    :pagina-schema="array_merge(['name' => $titulo], $paginaSchema)"
    :keywords="$keywords ?? 'advocacia tributária, advogada tributarista, planejamento tributário, recuperação de PIS/COFINS, regularização de débitos PGFN, Reforma Tributária, Suzano'">
    {{-- Com imagem: roxo denso à esquerda (texto) e mais transparente à direita (foto) --}}
    <div @class(['relative overflow-hidden bg-plum bg-cover bg-center text-white', 'cs-plum-bg' => ! $imagem])
        @if ($imagem)
            style="background-image: linear-gradient(100deg, rgba(36, 4, 31, 0.94) 0%, rgba(89, 8, 84, 0.88) 45%, rgba(89, 8, 84, 0.55) 100%), url('{{ asset($imagem) }}');"
        @endif>

        @include('novo.partials.header')

        <section class="cs-wrap relative pb-[clamp(56px,7vw,96px)] pt-[clamp(24px,4vw,56px)]">
            @if ($breadcrumbs)
                <nav aria-label="Você está em">
                    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-on-plum/80">
                        @foreach ($breadcrumbs as $item)
                            <li class="flex items-center gap-2">
                                @if (! $loop->last && ! empty($item['url']))
                                    <a href="{{ $item['url'] }}" class="transition-colors hover:text-champagne">{{ $item['label'] }}</a>
                                    <i class="fa-solid fa-chevron-right text-[9px] opacity-60" aria-hidden="true"></i>
                                @else
                                    <span aria-current="page" class="font-medium text-champagne">{{ $item['label'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            <h1 class="mt-5 max-w-[18em] font-display text-[clamp(38px,5vw,64px)] font-semibold leading-[1.04] tracking-[-0.02em] text-white">
                {{ $titulo }}
            </h1>

            @if ($descricao)
                <p class="mt-5 max-w-[40em] text-lg leading-relaxed text-on-plum">{{ $descricao }}</p>
            @endif
        </section>
    </div>

    <main>
        {{ $slot }}

        @if ($contato)
            <x-novo.contato />
        @endif
    </main>
</x-novo.layout>
