{{-- Perguntas frequentes do tema novo, com o bloco de contato pelo WhatsApp ao lado. --}}
@props([
    'faqs',
    'titulo' => 'Perguntas frequentes',
    'descricao' => 'As dúvidas que mais ouvimos de empresários sobre regime tributário, créditos e dívidas.',
])

<section aria-labelledby="faq-titulo" {{ $attributes->merge(['class' => 'py-[clamp(72px,9vw,128px)]']) }}>
    <div class="cs-wrap grid items-start gap-12 lg:grid-cols-[0.85fr_1.15fr] lg:gap-16">
        <div class="lg:sticky lg:top-10">
            <h2 id="faq-titulo" class="font-display text-[clamp(34px,4vw,54px)] font-semibold leading-[1.05] tracking-[-0.015em] text-plum-night">
                {{ $titulo }}
            </h2>
            <p class="mt-5 max-w-[26em] text-[17px] leading-relaxed text-ink-soft">
                {{ $descricao }}
            </p>
            <div class="cs-plum-bg relative mt-10 overflow-hidden rounded-2xl p-8 text-white">
                <p class="font-display text-2xl font-semibold leading-snug">Não encontrou a sua dúvida?</p>
                <p class="mt-2 text-[15px] leading-relaxed text-on-plum">Conte o seu caso e respondemos pessoalmente.</p>
                <x-link-whatsapp rel="nofollow"
                    class="mt-6 inline-flex items-center gap-2.5 rounded-full bg-champagne px-6 py-3 font-semibold text-plum-night transition hover:bg-champagne-light hover:text-plum-night">
                    <i class="fab fa-whatsapp text-lg" aria-hidden="true"></i> Perguntar no WhatsApp
                </x-link-whatsapp>
            </div>
        </div>

        <div class="cs-faq border-t border-line">
            @foreach ($faqs as $faq)
                <details id="{{ \Illuminate\Support\Str::slug($faq['question']) }}" class="group border-b border-line" @if ($loop->first) open @endif>
                    <summary class="grid cursor-pointer list-none grid-cols-[minmax(0,1fr)_32px] items-center gap-6 py-6 [&::-webkit-details-marker]:hidden">
                        <h3 class="font-display text-[22px] font-semibold leading-snug text-plum-night transition-colors group-hover:text-plum">{{ $faq['question'] }}</h3>
                        <span class="relative grid h-8 w-8 place-items-center rounded-full bg-mist transition duration-200 ease-out-soft group-open:rotate-45 group-open:bg-plum" aria-hidden="true">
                            <span class="absolute h-0.5 w-3 bg-plum group-open:bg-white"></span>
                            <span class="absolute h-3 w-0.5 bg-plum group-open:bg-white"></span>
                        </span>
                    </summary>
                    <p class="max-w-[42em] pb-7 text-base leading-relaxed text-ink-soft">{{ preg_replace('/\s+/u', ' ', $faq['answer']) }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
