{{-- Cabeçalho do tema novo, sobre o fundo roxo do banner. Com $sobreposto, fica fora do
     <main> e por cima do banner (que reserva a altura dele com um espaçador de 108.125px:
     py-5 + logo de 128px de largura na proporção 558x297), para o h1 ficar dentro do <main>. --}}
<header x-data="{ menu: false, servicos: false }" @class([
    'z-20 text-white',
    'absolute inset-x-0 top-0' => $sobreposto ?? false,
    'relative' => ! ($sobreposto ?? false),
])>
    <div class="cs-wrap flex flex-wrap items-center justify-between py-5">
        <a href="{{ route('inicio') }}" aria-label="Cassia Souza Advocacia Tributária, início">
            <img src="/assets/images/logo-acinzentado.png" alt="Cassia Souza Advocacia Tributária" width="128" height="68"
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

        <nav aria-label="Principal"
            class="hidden lg:flex lg:flex-row lg:items-center lg:gap-10">
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

    {{-- Menu do celular: painel de tela cheia (o do computador é o <nav> acima). Vai para o
         fim do <body> (x-teleport) para ficar acima de tudo, inclusive do botão do WhatsApp. --}}
    <template x-teleport="body">
    <div id="csNav" x-cloak x-show="menu" role="dialog" aria-modal="true" aria-label="Menu"
        x-effect="document.documentElement.classList.toggle('overflow-hidden', menu)"
        @keydown.escape.window="menu = false" @resize.window="if (innerWidth >= 1024) menu = false"
        x-transition:enter="transition duration-medio ease-out-soft"
        x-transition:enter-start="opacity-0 motion-safe:translate-y-2"
        x-transition:leave="transition duration-rapido ease-out-soft"
        x-transition:leave-end="opacity-0"
        class="cs-plum-bg fixed inset-0 z-[60] flex flex-col overflow-y-auto lg:hidden">
        <div class="cs-wrap flex items-center justify-between py-5">
            <a href="{{ route('inicio') }}" aria-label="Cassia Souza Advocacia Tributária, início">
                <img src="/assets/images/logo-acinzentado.png" alt="Cassia Souza Advocacia Tributária" width="128" height="68" class="block h-auto w-[128px]">
            </a>
            <button type="button" @click="menu = false" aria-label="Fechar menu"
                class="grid h-11 w-11 place-items-center rounded-full border border-white/20 bg-white/5 text-white">
                <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
            </button>
        </div>

        <nav aria-label="Principal no celular" class="cs-wrap flex flex-1 flex-col pb-10 pt-4">
            @php
                $linkCel = 'flex items-center justify-between py-4 font-display text-[28px] font-semibold leading-tight text-white transition-colors hover:text-champagne aria-[current=page]:text-champagne';
            @endphp
            <ul class="divide-y divide-white/10 border-y border-white/10">
                <li><a href="{{ route('inicio') }}" @if (request()->routeIs('inicio')) aria-current="page" @endif class="{{ $linkCel }}">Home</a></li>
                <li><a href="{{ route('sobre') }}" @if (request()->routeIs('sobre')) aria-current="page" @endif class="{{ $linkCel }}">Sobre</a></li>
                <li x-data="{ aberto: {{ request()->routeIs('servicos*') ? 'true' : 'false' }} }">
                    <button type="button" @click="aberto = !aberto" :aria-expanded="aberto.toString()" aria-controls="csServicosCel"
                        class="{{ $linkCel }} w-full text-left @if (request()->routeIs('servicos*')) !text-champagne @endif">
                        Serviços
                        <i class="fa-solid fa-chevron-down text-base transition-transform duration-rapido" :class="aberto && 'rotate-180'" aria-hidden="true"></i>
                    </button>
                    <ul id="csServicosCel" x-show="aberto" x-collapse.duration.300ms class="pb-4">
                        <li><a href="{{ route('servicos') }}" class="block py-2 text-[16px] font-semibold text-champagne">Ver todos os serviços</a></li>
                        @foreach (config('servicos') as $service)
                            <li>
                                <a href="{{ route($service['route']) }}" @if (request()->routeIs($service['route'])) aria-current="page" @endif
                                    class="block py-2 text-[16px] text-on-plum transition-colors hover:text-white aria-[current=page]:font-semibold aria-[current=page]:text-white">{{ $service['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="https://blog.cassiasouzaadvocacia.com.br/" class="{{ $linkCel }}">Blog</a></li>
                <li><a href="{{ route('contato') }}" @if (request()->routeIs('contato')) aria-current="page" @endif class="{{ $linkCel }}">Contato</a></li>
            </ul>

            <div class="mt-auto pt-10">
                <x-link-whatsapp rel="nofollow"
                    class="flex w-full items-center justify-center gap-2.5 rounded-full bg-champagne px-6 py-4 font-semibold text-plum-night transition hover:bg-champagne-light active:scale-[0.98]">
                    <i class="fab fa-whatsapp text-xl" aria-hidden="true"></i> Conversar no WhatsApp
                </x-link-whatsapp>
                <a href="mailto:cassia_souza@adv.oabsp.org.br" class="mt-4 block text-center text-[15px] text-on-plum [overflow-wrap:anywhere] hover:text-white">cassia_souza@adv.oabsp.org.br</a>
                <ul class="mt-6 flex justify-center gap-3" aria-label="Redes sociais da Cassia">
                    @foreach (config('site.social_icons', []) as $item)
                        <li>
                            <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer"
                                aria-label="{{ $redeCel = ['instagram' => 'Instagram', 'tiktok' => 'TikTok', 'linkedin' => 'LinkedIn'][$item['name']] ?? ucfirst($item['name']) }} da Cassia Souza"
                                title="{{ $redeCel }} da Cassia Souza"
                                class="grid h-11 w-11 place-items-center rounded-full border border-white/20 text-white transition-colors hover:border-champagne hover:text-champagne">
                                <i class="{{ str_replace(' social-networks', '', $item['icon_class']) }}" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
    </template>
</header>
