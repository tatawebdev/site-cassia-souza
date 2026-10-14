{{-- Grade de serviços do tema novo (home e /servicos): cards com foto, o
     problema que o visitante reconhece e o serviço; o primeiro e o último em destaque. --}}
@props(['servicos' => config('servicos')])

<ul {{ $attributes->merge(['class' => 'grid list-none gap-6 p-0 md:grid-cols-2 lg:grid-cols-3']) }}>
    @foreach ($servicos as $service)
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
