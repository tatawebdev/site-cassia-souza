{{-- Cabeçalho do tema novo. Fica dentro do hero de cada página, sobre o fundo roxo. --}}
<header x-data="{ menu: false, servicos: false }" class="relative z-20 text-white">
    <div class="cs-wrap flex flex-wrap items-center justify-between py-5">
        <a href="{{ route('inicio') }}" aria-label="Cássia Souza Advocacia — início">
            <img src="/assets/images/logo-acinzentado.png" alt="Cássia Souza Advocacia" width="128" height="68"
                class="block h-auto w-[128px]">
        </a>

        <button type="button" @click="menu = !menu" :aria-expanded="menu.toString()" aria-controls="csNav"
            aria-label="Abrir menu"
            class="relative h-11 w-11 rounded-full border border-white/20 bg-white/5 lg:hidden">
            <span class="absolute inset-x-3 top-[17px] h-0.5 bg-white transition-transform duration-200 ease-out-soft"
                :class="menu && 'translate-y-1 rotate-45'"></span>
            <span class="absolute inset-x-3 top-[25px] h-0.5 bg-white transition-transform duration-200 ease-out-soft"
                :class="menu && '-translate-y-1 -rotate-45'"></span>
        </button>

        <nav id="csNav" aria-label="Principal" :class="menu && '!flex cs-aberto'"
            class="hidden basis-full flex-col items-start gap-5 pb-2 pt-4 lg:!flex lg:basis-auto lg:flex-row lg:items-center lg:gap-10 lg:p-0">
            <ul class="flex w-full flex-col gap-1 lg:w-auto lg:flex-row lg:gap-8">
                <li><a href="{{ route('inicio') }}" @if (request()->routeIs('inicio')) aria-current="page" @endif
                        class="inline-block py-2 text-[15px] font-medium text-on-plum transition-colors hover:text-champagne aria-[current=page]:text-white aria-[current=page]:underline aria-[current=page]:decoration-champagne aria-[current=page]:decoration-2 aria-[current=page]:underline-offset-8">Home</a></li>
                <li><a href="{{ route('sobre') }}" @if (request()->routeIs('sobre')) aria-current="page" @endif
                        class="inline-block py-2 text-[15px] font-medium text-on-plum transition-colors hover:text-champagne aria-[current=page]:text-white aria-[current=page]:underline aria-[current=page]:decoration-champagne aria-[current=page]:decoration-2 aria-[current=page]:underline-offset-8">Sobre</a></li>
                <li class="relative" @click.outside="servicos = false" @keydown.escape.window="servicos = false">
                    <button type="button" @click="servicos = !servicos" :aria-expanded="servicos.toString()"
                        aria-controls="csServicos" @if (request()->routeIs('servicos*')) data-atual @endif
                        class="group inline-flex items-center gap-1.5 py-2 text-[15px] font-medium text-on-plum transition-colors hover:text-champagne data-[atual]:text-white">
                        {{-- Sublinhado só no texto: no botão inteiro ele pegava também a seta --}}
                        <span class="group-data-[atual]:underline group-data-[atual]:decoration-champagne group-data-[atual]:decoration-2 group-data-[atual]:underline-offset-8">Serviços</span>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform"
                            :class="servicos && 'rotate-180'" aria-hidden="true"></i>
                    </button>
                    <div id="csServicos" x-cloak x-show="servicos"
                        x-transition:enter="transition duration-rapido ease-out-soft"
                        x-transition:enter-start="opacity-0 motion-safe:-translate-y-1 motion-safe:scale-[0.98]"
                        x-transition:leave="transition duration-150 ease-out-soft"
                        x-transition:leave-end="opacity-0 motion-safe:-translate-y-1"
                        class="z-30 mt-2 w-full origin-top rounded-xl bg-white p-2 shadow-[0_24px_48px_-12px_rgba(36,4,31,0.45)] lg:absolute lg:left-1/2 lg:w-max lg:-translate-x-1/2">
                        @foreach (config('servicos') as $service)
                            <a href="{{ route($service['route']) }}"
                                class="block rounded-lg px-4 py-2.5 text-[15px] lg:whitespace-nowrap font-medium text-plum-night transition-colors hover:bg-mist hover:text-plum">{{ $service['title'] }}</a>
                        @endforeach
                    </div>
                </li>
                <li><a href="https://blog.cassiasouzaadvocacia.com.br/" class="inline-block py-2 text-[15px] font-medium text-on-plum transition-colors hover:text-champagne">Blog</a></li>
                <li><a href="{{ route('contato') }}" @if (request()->routeIs('contato')) aria-current="page" @endif
                        class="inline-block py-2 text-[15px] font-medium text-on-plum transition-colors hover:text-champagne aria-[current=page]:text-white aria-[current=page]:underline aria-[current=page]:decoration-champagne aria-[current=page]:decoration-2 aria-[current=page]:underline-offset-8">Contato</a></li>
            </ul>
            <x-link-whatsapp rel="nofollow"
                class="inline-flex items-center gap-2 rounded-full border border-white/25 px-4 py-2 text-[15px] font-semibold tabular-nums text-white transition-colors hover:border-champagne">
                <i class="fab fa-whatsapp text-lg text-champagne" aria-hidden="true"></i>
                <span>{{ config('site.whatsapp') }}</span>
            </x-link-whatsapp>
        </nav>
    </div>
</header>
