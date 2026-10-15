{{-- Seção de contato do tema novo (formulário + canais), usada no fim das páginas. --}}
    <section id="contato" aria-labelledby="contato-titulo" class="cs-plum-bg relative overflow-hidden py-[clamp(72px,9vw,128px)] text-white">
        <div class="cs-wrap relative grid items-center gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:gap-20">
            <div>
                <h2 id="contato-titulo" class="font-display text-[clamp(34px,4vw,54px)] font-semibold leading-[1.05] tracking-[-0.015em] text-white">
                    Conte o que está acontecendo na sua empresa
                </h2>
                <p class="mt-6 max-w-[30em] text-[17px] leading-relaxed text-on-plum">
                    Analisamos o seu caso e indicamos o melhor caminho. Atendimento de segunda a sexta, das 9h
                    às 17h.
                </p>
                <address class="not-italic">
                <ul class="m-0 mt-9 grid list-none gap-3 p-0">
                    <li>
                        <x-link-whatsapp rel="nofollow"
                            class="inline-flex items-center gap-3 rounded-xl border border-white/15 bg-white/5 px-5 py-4 font-semibold text-white transition-colors hover:border-champagne/60 hover:text-white">
                            <i class="fab fa-whatsapp w-5 text-xl text-champagne" aria-hidden="true"></i>
                            {{ config('site.whatsapp') }}
                        </x-link-whatsapp>
                    </li>
                    <li>
                        <a href="mailto:cassia_souza@adv.oabsp.org.br"
                            class="inline-flex items-center gap-3 rounded-xl border border-white/15 bg-white/5 px-5 py-4 font-semibold text-white transition-colors [overflow-wrap:anywhere] hover:border-champagne/60 hover:text-white">
                            <i class="fa-regular fa-envelope w-5 text-lg text-champagne" aria-hidden="true"></i>
                            cassia_souza@adv.oabsp.org.br
                        </a>
                    </li>
                </ul>
                </address>
            </div>
            <div class="cs-form rounded-2xl bg-white p-6 text-ink shadow-[0_40px_80px_-32px_rgba(0,0,0,0.5)] sm:p-9">
                <p class="mb-6 font-display text-2xl font-semibold text-plum-night">Solicite uma análise</p>
                <livewire:contact-form />
            </div>
        </div>
    </section>
