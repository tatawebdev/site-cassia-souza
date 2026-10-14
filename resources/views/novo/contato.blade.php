<x-novo.pagina tipo-pagina="ContactPage" :schema="[\App\Support\Schema::faq(config('faqs'))]"
    titulo="Fale conosco"
    descricao="Tire dúvidas ou agende uma consulta gratuita. Estamos prontos para ajudar sua empresa a conquistar segurança tributária."
    imagem="assets/images/banner-contatos.jpg"
    :contato="false"
    :breadcrumbs="[['label' => 'Home', 'url' => route('inicio')], ['label' => 'Contato']]">

    <section aria-labelledby="canais-titulo" class="bg-mist py-[clamp(64px,8vw,112px)]">
        <div class="cs-wrap grid items-start gap-12 lg:grid-cols-[0.95fr_1.05fr] lg:gap-16">
            <div>
                <h2 id="canais-titulo" class="font-display text-[clamp(32px,3.6vw,48px)] font-semibold leading-[1.08] tracking-[-0.015em] text-plum-night">
                    Como prefere falar com a gente?
                </h2>
                <p class="mt-5 max-w-[32em] text-[17px] leading-relaxed text-ink-soft">
                    Pelo WhatsApp, por e-mail ou pelo formulário: conte o que está acontecendo na sua empresa e
                    indicamos o melhor caminho.
                </p>

                <ul class="mt-9 grid gap-3">
                    <li>
                        <x-link-whatsapp rel="nofollow"
                            class="cs-plum-bg group flex items-center gap-5 rounded-2xl p-5 text-white shadow-[0_24px_48px_-28px_rgba(58,6,55,0.7)] transition hover:-translate-y-0.5 sm:p-6">
                            <span class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-champagne text-2xl text-plum-night" aria-hidden="true">
                                <i class="fab fa-whatsapp"></i>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-sm text-on-plum">WhatsApp</span>
                                <span class="block font-display text-[26px] font-semibold leading-tight tabular-nums">{{ config('site.whatsapp') }}</span>
                            </span>
                            <i class="fa-solid fa-arrow-right text-champagne transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true"></i>
                        </x-link-whatsapp>
                    </li>
                    <li>
                        <a href="mailto:cassia_souza@adv.oabsp.org.br"
                            class="group flex items-center gap-3.5 rounded-2xl border border-line bg-white p-4 transition hover:border-plum/40 sm:gap-5 sm:p-6">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-plum/10 text-lg text-plum sm:h-14 sm:w-14 sm:text-xl" aria-hidden="true">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-sm text-ink-soft">E-mail</span>
                                <span class="block text-[14px] font-semibold text-plum-night [overflow-wrap:anywhere] min-[400px]:text-base sm:text-lg">cassia_souza@adv.oabsp.org.br</span>
                            </span>
                            <i class="fa-solid fa-arrow-right text-plum transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>

                <dl class="mt-8 grid gap-6 border-t border-line pt-7 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm text-ink-soft">Atendimento</dt>
                        <dd class="mt-1 font-semibold text-plum-night">Segunda a sexta, das 9h às 17h</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-ink-soft">Base</dt>
                        <dd class="mt-1 font-semibold text-plum-night">Suzano, SP</dd>
                    </div>
                </dl>

                <ul class="mt-8 flex flex-wrap gap-3" aria-label="Redes sociais">
                    @foreach (config('site.social_icons', []) as $rede)
                        <li>
                            <a href="{{ $rede['url'] }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-full border border-plum/30 bg-white px-5 py-2.5 font-semibold text-plum transition-colors hover:border-plum hover:bg-plum hover:text-white">
                                <i class="{{ $rede['icon_class'] }}" aria-hidden="true"></i>{{ ['instagram' => 'Instagram', 'tiktok' => 'TikTok', 'linkedin' => 'LinkedIn'][$rede['name']] ?? ucfirst($rede['name']) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="cs-form rounded-2xl bg-white p-6 shadow-[0_40px_80px_-40px_rgba(58,6,55,0.45)] sm:p-9" id="contato">
                <h2 class="font-display text-[28px] font-semibold leading-tight text-plum-night">Solicite uma análise</h2>
                <p class="mb-7 mt-2 text-[15px] leading-relaxed text-ink-soft">Respondemos em horário comercial.</p>
                <livewire:contact-form />
            </div>
        </div>
    </section>

    <section aria-labelledby="assina-titulo" class="overflow-hidden bg-white py-[clamp(64px,8vw,112px)]">
        <div class="cs-wrap grid items-center gap-10 md:grid-cols-[0.8fr_1.2fr] lg:gap-20">
            <figure class="m-0 mx-auto w-full max-w-[400px] overflow-hidden rounded-2xl border border-line shadow-[0_40px_80px_-40px_rgba(58,6,55,0.45)]">
                <img src="/assets/img/parceria.png" alt="Cássia Souza, advogada tributarista, sorrindo ao notebook"
                    width="860" height="968" loading="lazy" class="block aspect-[860/968] h-auto w-full object-cover">
            </figure>
            <div>
                <p id="assina-titulo" class="font-display text-[clamp(34px,4.4vw,58px)] font-semibold leading-[1.08] tracking-[-0.02em] text-plum-night">
                    “Eu simplifico a tributação.”
                </p>
                <p class="mt-5 text-[17px] text-ink-soft">Cássia Souza, advogada tributarista, OAB/SP</p>
                <a href="{{ route('sobre') }}"
                    class="mt-8 inline-flex items-center gap-2 rounded-full border border-plum px-7 py-3.5 font-semibold text-plum transition-colors hover:bg-plum hover:text-white">Conheça o escritório</a>
            </div>
        </div>
    </section>

    <x-novo.faq :faqs="config('faqs')" class="bg-mist"
        descricao="Talvez a sua dúvida já esteja respondida aqui." />
</x-novo.pagina>
