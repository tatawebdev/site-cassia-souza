<footer class="bg-plum-night text-on-plum">
    <div class="cs-wrap">
        <div class="grid gap-8 border-b border-white/10 py-14 lg:grid-cols-[1fr_1fr] lg:items-center lg:gap-16">
            <div>
                <p class="font-display text-[28px] font-semibold leading-tight text-white">Receba novidades e dicas tributárias</p>
                <p class="mt-2 text-[15px] text-on-plum/80">Conteúdo sobre Reforma Tributária, créditos e regularização, direto no seu e-mail.</p>
            </div>
            <div class="cs-newsletter">
                <livewire:newsletter-subscribe />
            </div>
        </div>

        <div class="grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-[1.25fr_1fr_0.75fr_1.2fr]">
            <div>
                <img src="/assets/images/logo-acinzentado.png" alt="Cássia Souza Advocacia" width="150" height="80"
                    class="h-auto w-[150px]">
                <p class="mt-5 max-w-[22em] text-[15px] leading-relaxed text-on-plum/80">
                    Escritório especializado em advocacia tributária. Soluções personalizadas para empresas que
                    buscam segurança, economia e regularidade fiscal.
                </p>
                <ul class="mt-6 flex gap-3">
                    @foreach (config('site.social_icons', []) as $item)
                        <li>
                            <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer"
                                aria-label="{{ ucfirst($item['name']) }}"
                                class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-white transition-colors hover:border-champagne hover:text-champagne">
                                <i class="{{ $item['icon_class'] }}" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold text-white">Serviços</p>
                <ul class="mt-4 grid gap-2.5 text-[15px]">
                    @foreach (config('servicos') as $service)
                        <li><a href="{{ route($service['route']) }}" class="transition-colors hover:text-champagne">{{ $service['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold text-white">Escritório</p>
                <ul class="mt-4 grid gap-2.5 text-[15px]">
                    <li><a href="/sobre-nos" class="transition-colors hover:text-champagne">Quem somos</a></li>
                    <li><a href="https://blog.cassiasouzaadvocacia.com.br/" class="transition-colors hover:text-champagne">Blog</a></li>
                    <li><a href="/contato" class="transition-colors hover:text-champagne">Contato</a></li>
                    <li><a href="/politica-de-privacidade" class="transition-colors hover:text-champagne">Política de privacidade</a></li>
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold text-white">Atendimento</p>
                <ul class="mt-4 grid gap-2.5 text-[15px]">
                    <li>Segunda a sexta, 9h às 17h</li>
                    <li>
                        <x-link-whatsapp rel="nofollow" class="inline-flex items-center gap-2 transition-colors hover:text-champagne">
                            <i class="fab fa-whatsapp text-champagne" aria-hidden="true"></i>{{ config('site.whatsapp') }}
                        </x-link-whatsapp>
                    </li>
                    <li>
                        <a href="mailto:cassia_souza@adv.oabsp.org.br" class="inline-flex items-center gap-2 text-[14px] transition-colors hover:text-champagne">
                            <i class="fa-regular fa-envelope text-champagne" aria-hidden="true"></i>cassia_souza@adv.oabsp.org.br
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <p class="border-t border-white/10 py-6 text-sm text-on-plum/60">
            © {{ date('Y') }} Cássia Souza Advocacia. Todos os direitos reservados.
        </p>
    </div>
</footer>
