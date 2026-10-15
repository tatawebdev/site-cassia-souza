{{-- Grade de serviços do tema novo (home e /servicos): cards com foto, o
     problema que o visitante reconhece e o serviço; o primeiro e o último em destaque. --}}
@props(['servicos' => config('servicos')])

<ul {{ $attributes->merge(['class' => 'grid list-none gap-6 p-0 md:grid-cols-2 lg:grid-cols-3']) }}>
    @foreach ($servicos as $service)
        @php $featured = $loop->first || $loop->last; @endphp
        <li class="{{ $featured ? 'md:col-span-2' : '' }}" data-revelar>
            <a href="{{ route($service['route']) }}"
                class="group grid h-full overflow-hidden rounded-2xl border border-line bg-white shadow-[0_24px_48px_-32px_rgba(58,6,55,0.45)] transition duration-medio motion-safe:hover:-translate-y-1 motion-safe:active:translate-y-0 active:duration-100 hover:shadow-[0_32px_64px_-32px_rgba(58,6,55,0.6)] {{ $featured ? 'lg:grid-cols-2' : '' }} {{ $loop->last ? 'lg:[&>figure]:order-2' : '' }}">
                <figure class="relative m-0 h-52 overflow-hidden {{ $featured ? 'lg:h-full lg:min-h-[300px]' : '' }}">
                    @php $foto = asset('assets/servicos/detalhes/' . $service['image'] . '/imagem1'); @endphp
                    <picture class="contents">
                        <source type="image/webp" srcset="{{ $foto }}-480.webp 480w, {{ $foto }}.webp 735w"
                            sizes="{{ $featured ? '(min-width: 1024px) 560px, (min-width: 768px) 90vw, 100vw' : '(min-width: 1024px) 360px, (min-width: 768px) 45vw, 100vw' }}">
                        <img src="{{ $foto }}.jpg"
                            alt="" loading="lazy" width="735" height="509"
                            class="h-full w-full object-cover transition-transform duration-500 ease-out-soft motion-safe:group-hover:scale-[1.04]">
                    </picture>
                    <div class="absolute inset-0 bg-gradient-to-t from-plum-night/40 to-transparent" aria-hidden="true"></div>
                </figure>
                <div class="flex flex-col p-6 sm:p-7 {{ $featured ? 'lg:justify-center lg:p-10' : '' }}">
                    <h3 class="text-sm font-semibold text-gold-ink">{{ $service['title'] }}</h3>
                    <span class="mt-2 font-display font-semibold leading-tight tracking-[-0.01em] text-plum-night {{ $featured ? 'text-[clamp(24px,2.4vw,32px)]' : 'text-[22px]' }}">{{ $service['problem'] }}</span>
                    <span class="mt-3 text-[15px] leading-relaxed text-ink-soft">{{ $service['text'] }}</span>
                    <span class="mt-auto flex items-center gap-3 pt-6 text-[15px] font-semibold text-plum">
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-plum text-white transition-transform motion-safe:group-hover:translate-x-1" aria-hidden="true">
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </span>
                        Ver solução
                    </span>
                </div>
            </a>
        </li>
    @endforeach
</ul>
