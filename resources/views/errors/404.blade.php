{{-- Página não encontrada (tema novo). --}}
<x-novo.layout title="Página não encontrada | Cassia Souza Advocacia Tributária"
    description="O endereço acessado não existe ou mudou de lugar.">
    <div class="cs-plum-bg relative overflow-hidden text-white">
        @include('novo.partials.header')

        <section class="cs-wrap relative grid gap-12 pb-[clamp(64px,8vw,112px)] pt-[clamp(32px,5vw,72px)] lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div>
                <p class="font-display text-[clamp(72px,10vw,140px)] font-semibold leading-none text-champagne/90">404</p>
                <h1 class="mt-4 max-w-[16em] font-display text-[clamp(34px,4.4vw,54px)] font-semibold leading-[1.08] tracking-[-0.02em]">
                    Esta página não existe ou mudou de lugar.
                </h1>
                <p class="mt-5 max-w-[34em] text-lg leading-relaxed text-on-plum">
                    Confira o endereço ou siga por um dos caminhos abaixo. Se procurava ajuda com a tributação da sua
                    empresa, fale com a Cassia.
                </p>
                <div class="mt-9 flex flex-wrap items-center gap-x-7 gap-y-4">
                    <a href="{{ route('inicio') }}"
                        class="inline-flex items-center gap-2.5 rounded-full bg-champagne px-7 py-4 font-semibold text-plum-night transition hover:bg-champagne-light">
                        Voltar para o início
                    </a>
                    <x-link-whatsapp rel="nofollow"
                        class="font-semibold text-white underline decoration-champagne/60 underline-offset-[6px] hover:decoration-champagne">
                        Conversar no WhatsApp
                    </x-link-whatsapp>
                </div>
            </div>

            <nav aria-label="Páginas do site" class="rounded-2xl border border-white/15 bg-white/5 p-6 sm:p-8">
                <p class="text-sm font-semibold text-champagne">Talvez você procure</p>
                <ul class="mt-4 grid gap-1">
                    @foreach (config('servicos') as $servico)
                        <li>
                            <a href="{{ route($servico['route']) }}"
                                class="group flex items-center justify-between gap-4 rounded-lg px-3 py-2.5 text-[15px] font-medium text-on-plum transition-colors hover:bg-white/10 hover:text-white">
                                {{ $servico['title'] }}
                                <i class="fa-solid fa-arrow-right text-xs text-champagne transition-transform motion-safe:group-hover:translate-x-1" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endforeach
                    <li class="mt-2 border-t border-white/10 pt-2">
                        <a href="https://blog.cassiasouzaadvocacia.com.br/" class="flex items-center justify-between gap-4 rounded-lg px-3 py-2.5 text-[15px] font-medium text-on-plum transition-colors hover:bg-white/10 hover:text-white">
                            Artigos do blog <i class="fa-solid fa-arrow-right text-xs text-champagne" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </section>
    </div>
</x-novo.layout>
