{{-- Página de um serviço (tema novo). Recebe $slug da rota; o conteúdo vem de
     config/servicos.php e as perguntas de config/faqs.php (pelos temas do serviço). --}}
@php
    $servico = collect(config('servicos'))->firstWhere('slug', $slug);
    abort_unless($servico, 404);

    $faqs = collect(config('faqs'))->whereIn('tema', $servico['faq'])->values()->all();
    // Minúscula só na primeira letra, para manter siglas como PIS/COFINS e PGFN
    $faqDescricao = 'O que os empresários mais perguntam sobre '.\Illuminate\Support\Str::lcfirst($servico['title']).'.';
    $outros = collect(config('servicos'))->where('slug', '!=', $slug)->values();
    $foto = 'assets/servicos/detalhes/'.$servico['image'];
@endphp

<x-novo.pagina :titulo="$servico['title']" :descricao="$servico['descricao']"
    :imagem="'assets/images/'.$servico['banner']"
    :schema="[\App\Support\Schema::servico($servico), \App\Support\Schema::faq($faqs)]"
    :keywords="mb_strtolower($servico['title']).', advocacia tributária, advogada tributarista, Cassia Souza, Suzano'"
    :breadcrumbs="[
        ['label' => 'Home', 'url' => route('inicio')],
        ['label' => 'Serviços', 'url' => route('servicos')],
        ['label' => $servico['title']],
    ]">

    {{-- O visitante se reconhece: o problema dele é o título --}}
    <section aria-labelledby="problema-titulo" class="bg-white py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap grid items-center gap-14 lg:grid-cols-[1.05fr_0.95fr] lg:gap-20">
            <div>
                <h2 id="problema-titulo" class="font-display text-[clamp(32px,3.8vw,50px)] font-semibold leading-[1.08] tracking-[-0.015em] text-plum-night">
                    “{{ $servico['problem'] }}”
                </h2>
                <div class="mt-7 space-y-5 text-[18px] leading-relaxed">
                    @foreach ($servico['abertura'] as $paragrafo)
                        <p>{{ $paragrafo }}</p>
                    @endforeach
                </div>
                <div class="mt-10 flex flex-wrap items-center gap-x-7 gap-y-4">
                    <x-link-whatsapp rel="nofollow"
                        class="inline-flex items-center gap-2.5 rounded-full bg-plum px-7 py-4 font-semibold text-white transition hover:bg-plum-deep">
                        <i class="fab fa-whatsapp text-xl" aria-hidden="true"></i> Conversar no WhatsApp
                    </x-link-whatsapp>
                    <a href="#contato"
                        class="font-semibold text-plum underline decoration-plum/40 underline-offset-[6px] transition-[color,text-decoration-color,text-underline-offset] hover:decoration-plum hover:underline-offset-[3px]">Enviar uma mensagem</a>
                </div>
            </div>

            <figure class="m-0">
                <img src="{{ asset($foto.'/imagem2.jpg') }}" alt="" width="735" height="314" fetchpriority="high"
                    class="block aspect-[735/314] h-auto w-full rounded-2xl object-cover shadow-[0_40px_80px_-40px_rgba(58,6,55,0.5)]">
            </figure>
        </div>
    </section>

    <section aria-label="Em destaque" class="cs-plum-bg relative overflow-hidden py-[clamp(64px,8vw,112px)] text-white">
        <i class="fa-solid fa-quote-left pointer-events-none absolute left-[6%] top-8 text-[clamp(96px,14vw,200px)] leading-none text-champagne/10" aria-hidden="true"></i>
        <div class="cs-wrap relative text-center">
            <p class="mx-auto max-w-[24ch] font-display text-[clamp(30px,4vw,52px)] font-semibold leading-[1.12] tracking-[-0.02em]">
                {{ $servico['destaque'] }}
            </p>
        </div>
    </section>

    <section aria-labelledby="como-titulo" class="bg-mist py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap grid gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-stretch lg:gap-20">
            <figure class="relative m-0 overflow-hidden rounded-2xl lg:min-h-[420px]">
                <img src="{{ asset($foto.'/imagem1.jpg') }}" alt="" loading="lazy" width="735" height="509"
                    class="block aspect-[735/509] h-auto w-full object-cover lg:absolute lg:inset-0 lg:aspect-auto lg:h-full">
            </figure>

            <div>
                <h2 id="como-titulo" class="font-display text-[clamp(30px,3.4vw,44px)] font-semibold leading-[1.1] tracking-[-0.015em] text-plum-night">
                    {{ $servico['como_titulo'] }}
                </h2>

                @if ($servico['como'])
                    <div class="mt-6 space-y-5 text-[17px] leading-relaxed">
                        @foreach ($servico['como'] as $paragrafo)
                            <p>{{ $paragrafo }}</p>
                        @endforeach
                    </div>
                @endif

                @if ($servico['lista'])
                    <ul class="mt-6 divide-y divide-line border-y border-line">
                        @foreach ($servico['lista'] as $item)
                            <li class="flex gap-4 py-4 text-[17px] leading-relaxed">
                                <span class="mt-1 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-plum text-white" aria-hidden="true">
                                    <i class="fa-solid fa-check text-[10px]"></i>
                                </span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{-- Fechamento da página antiga, como chamada --}}
                <div class="mt-10 rounded-2xl border border-line bg-white p-7">
                    <p class="font-display text-[22px] font-semibold leading-snug text-plum-night">{{ $servico['fechamento'] }}</p>
                    <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-3">
                        <x-link-whatsapp rel="nofollow"
                            class="inline-flex items-center gap-2.5 rounded-full bg-champagne px-6 py-3 font-semibold text-plum-night transition hover:bg-champagne-light">
                            <i class="fab fa-whatsapp text-lg" aria-hidden="true"></i> Falar no WhatsApp
                        </x-link-whatsapp>
                        <a href="#contato" class="font-semibold text-plum underline decoration-plum/40 underline-offset-4 hover:decoration-plum">Ou envie uma mensagem</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-novo.avaliacoes class="bg-white" />

    @if ($faqs)
        <x-novo.faq :faqs="$faqs" class="bg-mist" :descricao="$faqDescricao" />
    @endif

    <section aria-labelledby="outros-titulo" class="bg-white py-[clamp(64px,8vw,104px)]">
        <div class="cs-wrap grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20">
            <h2 id="outros-titulo" class="font-display text-[clamp(28px,3vw,40px)] font-semibold leading-[1.1] text-plum-night">
                Outros serviços
            </h2>
            <ul class="grid gap-x-8 sm:grid-cols-2">
                @foreach ($outros as $outro)
                    <li class="border-b border-line">
                        <a href="{{ route($outro['route']) }}"
                            class="group flex items-center justify-between gap-4 py-5 font-semibold text-plum-night transition-colors hover:text-plum">
                            {{ $outro['title'] }}
                            <i class="fa-solid fa-arrow-right text-sm text-plum transition-transform duration-200 motion-safe:group-hover:translate-x-1" aria-hidden="true"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</x-novo.pagina>
