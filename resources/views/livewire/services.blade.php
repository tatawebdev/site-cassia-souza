<div>
    <section class="practice-con">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="practice_content text-center" data-aos="fade-up">
                        <h6>Sobre a Cassia Souza Adv</h6>
                        <h2>Nossa atuação em Direito Tributário</h2>
                        <p class="col-xl-8 col-lg-10 mx-auto text-size-16 mb-0">A Cassia Souza Adv é um escritório especializado em Direito Tributário, com foco em estratégia, segurança jurídica e resultados concretos para empresas de todos os portes. Com uma abordagem moderna e transparente, transformamos a complexidade do sistema tributário em soluções práticas, éticas e seguras.</p>
                    </div>
                </div>
            </div>
            @php
            // Serviços oferecidos pela Cassia Souza Adv — mapeados para as rotas nomeadas
            $services = [
                [
                    'icon' => 'practice-icon1.png',
                    'alt' => 'Consultoria Tributária',
                    'title' => 'Consultoria Tributária',
                    'text' => 'Nossa consultoria acompanha sua empresa mês a mês, revisando movimentações fiscais, prevenindo riscos e identificando oportunidades para garantir conformidade e economia.',
                    'route' => 'servicos.consultoria.tributaria',
                ],
                [
                    'icon' => 'practice-icon2.png',
                    'alt' => 'Regularização de Débitos - PGFN',
                    'title' => 'Regularização de Débitos (PGFN)',
                    'text' => 'Negociação de débitos em Dívida Ativa com descontos, parcelamentos e pedidos de revisão, para recuperar fôlego financeiro e evitar bloqueios.',
                    'route' => 'servicos.regularizacao.debitos.pgfn',
                ],
                [
                    'icon' => 'practice-icon3.png',
                    'alt' => 'Planejamento Tributário',
                    'title' => 'Planejamento Tributário',
                    'text' => 'Estruturamos estratégias sob medida para reduzir a carga tributária dentro da legalidade, garantindo previsibilidade e segurança para o crescimento.',
                    'route' => 'servicos.planejamento.tributario',
                ],
                [
                    'icon' => 'practice-icon4.png',
                    'alt' => 'Planejamento para Clínicas',
                    'title' => 'Planejamento Tributário para Clínicas',
                    'text' => 'Soluções tributárias específicas para clínicas médicas e odontológicas, buscando economia legal, previsibilidade e maior rentabilidade.',
                    'route' => 'servicos.planejamento.tributario.clinicas',
                ],
                [
                    'icon' => 'practice-icon5.png',
                    'alt' => 'Assessoria Reforma Tributária',
                    'title' => 'Assessoria para Reforma Tributária',
                    'text' => 'Acompanhamos as mudanças da reforma tributária, reduzindo riscos e ajudando sua empresa a aproveitar oportunidades com segurança.',
                    'route' => 'servicos.assessoria.reforma.tributaria',
                ],
                [
                    'icon' => 'practice-icon6.png',
                    'alt' => 'Treinamento Tributário',
                    'title' => 'Treinamento Tributário para Empresas',
                    'text' => 'Capacitamos equipes com conteúdo prático e objetivo — presencial ou online — para reduzir riscos e otimizar rotinas fiscais.',
                    'route' => 'servicos.treinamento.tributario',
                ],
                [
                    'icon' => 'practice-icon1.png',
                    'alt' => 'Recuperação PIS/COFINS',
                    'title' => 'Recuperação de PIS/COFINS (Monofásicos)',
                    'text' => 'Analisamos operações para identificar créditos de PIS/COFINS monofásicos e recuperamos valores pagos indevidamente de forma legal.',
                    'route' => 'servicos.recuperacao.pis.cofins.monofasicos',
                ],
            ];
            @endphp

            <div class="row" data-aos="fade-up">
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="box">
                            <div class="practice-box">
                                <figure class="icon">
                                    <img src="/assets/images/{{ $service['icon'] }}" alt="{{ $service['alt'] }}" class="img-fluid">
                                </figure>
                                <h5>{{ $service['title'] }}</h5>
                                <p class="text-size-14">{{ $service['text'] }}</p>
                                <a href="{{ route($service['route']) }}" class="text-decoration-none"><i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- About -->
    <section class="about-con position-relative">
        <figure class="about-sideimage mb-0">
            <img src="/assets/images/about-sideimage.png" alt="image" class="image-fluid">
        </figure>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <div class="about_wrapper position-relative">
                        <figure class="about-image mb-0">
                            <img src="/assets/images/about-image.jpg" alt="image" class="image-fluid">
                        </figure>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="about_content" data-aos="fade-up">
                        <div class="content">
                            <h6>Sobre a Cassia Souza Adv</h6>
                            <h2 class="text-white" style="font-size:2.2rem; font-weight:700;">Clareza, Ética e Estratégia</h2>
                            <p class="text-white text-size-16">Somos um escritório especializado em Direito Tributário que atuamos com foco em estratégias, segurança jurídica e resultados reais para empresas de todos os portes. Mais do que prestar serviços, somos parceiros estratégicos na gestão tributária, oferecendo suportes contínuos e personalizados.</p>

                            <h5 class="text-white mt-3">Nossa missão</h5>
                            <p class="text-white text-size-16">Garantir clareza e segurança tributária para que empresários tomem decisões com confiança, pagando apenas o necessário e mantendo suas empresas protegidas e competitivas.</p>

                            <h5 class="text-white mt-3">Nossos valores</h5>
                            <p class="text-white text-size-16">Ética, transparência, comunicação clara, responsabilidade, parceria com o cliente e inovação jurídica.</p>

                            <a href="/contato" class="text-decoration-none read_more">Fale com a gente<i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>