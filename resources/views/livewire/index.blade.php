<div>
    <div class="legal_matter position-relative">
        <header class="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                    <a class="navbar-brand" href="index.html">
                        <figure class="logo mb-0"><img width="150px" src="/assets/images/logo-acinzentado.png"
                                alt="" class="img-fluid"></figure>
                    </a>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        <span class="navbar-toggler-icon"></span>
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sobre-nos">Sobre</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle dropdown-color navbar-text-color" href="#"
                                    id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"> Serviços </a>
                                <div class="dropdown-menu drop-down-content">
                                    <ul class="list-unstyled drop-down-pages">
                                        <li class="nav-item">
                                            <a class="dropdown-item nav-link"
                                                href="{{ route('servicos.consultoria.tributaria') }}">
                                                Consultoria Tributária
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item nav-link"
                                                href="{{ route('servicos.regularizacao.debitos.pgfn') }}">
                                                Regularização de Débitos Federais (PGFN)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item nav-link"
                                                href="{{ route('servicos.planejamento.tributario') }}">
                                                Planejamento Tributário
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item nav-link"
                                                href="{{ route('servicos.planejamento.tributario.clinicas') }}">
                                                Planejamento Tributário para Clínicas Médicas/Odontológicas
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item nav-link"
                                                href="{{ route('servicos.assessoria.reforma.tributaria') }}">
                                                Assessoria para Reforma Tributária
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item nav-link"
                                                href="{{ route('servicos.treinamento.tributario') }}">
                                                Treinamento Tributário
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item nav-link"
                                                href="{{ route('servicos.recuperacao.pis.cofins.monofasicos') }}">
                                                Recuperação de PIS/COFINS Monofásicos
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" target="_blank"
                                    href="https://blog.cassiasouzaadvocacia.com.br/">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contato">Contato</a>
                            </li>
                        </ul>
                        <div class="last_list">
                            <x-link-whatsapp class="float" rel="nofollow">
                                <i class="fab fa-whatsapp my-float" style="font-size: 24px;"></i>
                                <span style="margin-left: 8px;">{{ config('site.whatsapp') }}</span>
                            </x-link-whatsapp>
                        </div>
                    </div>
                </nav>
            </div>
        </header>


        <section class="legal_matter_banner position-relative">
            <div class="container position-relative">
                <div class="row">
                    <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="banner_content" data-aos="fade-up">
                            <h2 class="text-white text-size-28 mb-3">
                                Está pagando além do justo em impostos? </h2>
                            <p class="text-white text-size-16 mb-3">
                                Nossa consultoria tributária identifica reduções legais, regulariza dívidas, recupera
                                tributos <strong>e prepara sua empresa para a Reforma Tributária.</strong>
                            </p>

                            <p class="text-white text-size-16 mb-3">
                                Tudo isso com clareza, ética e planejamento, para que sua empresa tenha
                                <strong>previsibilidade, economia e segurança!</strong>
                            </p>


                            <a href="./contact" class="text-decoration-none appointment">Fale conosco<i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="banner_wrapper position-relative">
                            <figure class="banner-image mb-0" data-aos="fade-up">
                                <img src="/assets/img/banner-novo1.png" alt="advogada trabalhando" class="img-fluid">
                            </figure>
                            <figure class="banner-background mb-0">
                                <img src="/assets/images/banner3-background.jpg" alt="fundo do banner"
                                    class="img-fluid">
                            </figure>
                        </div>
                    </div>
                </div>
                @include('components.social-icons', [
                    'wrapper' => 'ul',
                    'wrapperClass' => 'list-unstyled mb-0 social-icons',
                ])
            </div>
        </section>
    </div>

    @include('sobre-nos')

    <!-- Fale Conosco -->
    <section class="consultation-con position-relative">
        <figure class="consultation-sideimage mb-0">
            <img src="assets/images/consultation-sideimage.png" alt="imagem lateral" class="image-fluid">
        </figure>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="consultation_wrapper position-relative">
                        <figure class="consultation-image mb-0">
                            <img src="/assets/img/contato.png" alt="imagem principal" class="image-fluid">
                        </figure>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="consultation_content" data-aos="fade-up">
                        <h6>Fale conosco</h6>
                        <h2 class="text-white">Agende sua consulta agora!</h2>
                        <form id="contactpage" method="post" class="position-relative">
                            <div class="form-group input1 float-left">
                                <input type="text" class="form_style" placeholder="Nome" name="fname"
                                    id="fname">
                            </div>
                            <div class="form-group float-left">
                                <input type="tel" class="form_style" placeholder="Telefone" name="phone"
                                    id="phone">
                            </div>
                            <div class="form-group input1 float-left">
                                <input type="email" class="form_style" placeholder="E-mail" name="email"
                                    id="email">
                            </div>
                            <div class="form-group float-left">
                                <select class="form-control">
                                    <option>Área de interesse</option>
                                    <option>Consultoria Tributária</option>
                                    <option>Planejamento Fiscal</option>
                                    <option>Contencioso Tributário</option>
                                </select>
                            </div>
                            <div class="form-group message">
                                <textarea class="form_style" placeholder="Mensagem" rows="3" name="msg"></textarea>
                            </div>
                            <button id="submit" type="submit" class="appointment">Agendar Consulta<i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Expertise -->
    <section class="practice-con">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="practice_content text-center" data-aos="fade-up">
                        <h2>Nossas soluções tributárias</h2>
                        <p class="col-xl-8 col-lg-10 mx-auto text-size-16 mb-0">Somos um escritório de
                            <strong>advocacia tributária</strong> dedicado a servir empresários e empresárias para que
                            tomem <strong>decisões tributárias mais estratégicas</strong>, impulsionando o
                            <strong>crescimento de seus negócios</strong>.
                        </p>
                    </div>
                </div>
            </div>
            @php
                // Serviços oferecidos pela Cassia Souza Adv — mapeados para as rotas nomeadas
                $services = [
                    [
                        // ícones mapeados para arquivos reais em public/assets/servicos
                        'icon' => 'consultoria_tributaria.png',
                        'alt' => 'Consultoria Tributária',
                        'title' => 'Consultoria Tributária',
                        'text' =>
                            'Nossa consultoria acompanha sua empresa mês a mês, revisando movimentações fiscais, prevenindo riscos e identificando oportunidades para garantir conformidade e economia.',
                        'route' => 'servicos.consultoria.tributaria',
                    ],
                    [
                        'icon' => 'regularizacao_pgfn.png',
                        'alt' => 'Regularização de Débitos - PGFN',
                        'title' => 'Regularização de Débitos (PGFN)',
                        'text' =>
                            'Negociação de débitos em Dívida Ativa com descontos, parcelamentos e pedidos de revisão, para recuperar fôlego financeiro e evitar bloqueios.',
                        'route' => 'servicos.regularizacao.debitos.pgfn',
                    ],
                    [
                        'icon' => 'planejamento_tributario.png',
                        'alt' => 'Planejamento Tributário',
                        'title' => 'Planejamento Tributário',
                        'text' =>
                            'Estruturamos estratégias personalizadas para que sua empresa pague apenas o devido, evitando riscos e fortalecendo sua saúde financeira.',
                        'route' => 'servicos.planejamento.tributario',
                    ],
                    [
                        'icon' => 'planejamento_clinicas.png',
                        'alt' => 'Planejamento para Clínicas',
                        'title' => 'Planejamento Tributário para Clínicas',
                        'text' =>
                            'Clínicas médicas e odontológicas podem reduzir a carga tributária com planejamento personalizado.',
                        'route' => 'servicos.planejamento.tributario.clinicas',
                    ],
                    [
                        'icon' => 'assessoria_reforma_tributaria.png',
                        'alt' => 'Assessoria Reforma Tributária',
                        'title' => 'Assessoria para Reforma Tributária',
                        'text' =>
                            'Nossa assessoria especializada ajuda sua empresa a entender impactos, reduzir riscos e se adaptar com segurança às mudanças da Reforma Tributária.',
                        'route' => 'servicos.assessoria.reforma.tributaria',
                    ],
                    [
                        'icon' => 'treinamento_tributario.png',
                        'alt' => 'Treinamento Tributário',
                        'title' => 'Treinamento Tributário para Empresas',
                        'text' =>
                            'Capacitação personalizada para reduzir riscos, evitar autuações e otimizar rotinas tributárias — presencial ou online.',
                        'route' => 'servicos.treinamento.tributario',
                    ],
                    [
                        'icon' => 'recuperacao_pis_cofins.png',
                        'alt' => 'Recuperação PIS/COFINS',
                        'title' => 'Recuperação de PIS/COFINS (Monofásicos)',
                        'text' =>
                            'Analisamos operações, identificamos créditos legítimos e recuperamos valores de forma legal, garantindo fôlego financeiro e mais recursos para o crescimento da sua empresa.',
                        'route' => 'servicos.recuperacao.pis.cofins.monofasicos',
                    ],
                ];
            @endphp

            <div class="row" data-aos="fade-up">
                @foreach ($services as $service)
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="box">
                            <div class="practice-box">
                                <figure class="icon">
                                    <img src="{{ asset('assets/servicos/' . $service['icon']) }}"
                                        alt="{{ $service['alt'] }}" class="img-fluid service-icon">
                                </figure>
                                <h5>{{ $service['title'] }}</h5>
                                <p class="text-size-14">{{ $service['text'] }}</p>
                                <a href="{{ route($service['route']) }}" class="text-decoration-none"><i
                                        class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="about-con position-relative">

        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <div class="about_wrapper position-relative">
                        <figure class="about-image mb-0">
                            <img src="assets/img/parceria.png" alt="imagem principal" style="width: unset;" class="image-fluid">
                        </figure>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="about_content" data-aos="fade-up">
                        <div class="content">
                            <h6>Sobre a Cassia Souza Adv</h6>
                            <h2 class="text-white" style="font-size:2.2rem; font-weight:700;">Clareza, Ética e
                                Estratégia</h2>
                            <p class="text-white text-size-16">Somos um escritório especializado em Direito Tributário
                                que atuamos com foco em estratégias, segurança jurídica e resultados reais para empresas
                                de todos os portes. Mais do que prestar serviços, somos parceiros estratégicos na gestão
                                tributária, oferecendo suportes contínuos e personalizados.</p>

                            <h5 class="text-white mt-3">Nossa missão</h5>
                            <p class="text-white text-size-16">Garantir clareza e segurança tributária para que
                                empresários tomem decisões com confiança, pagando apenas o necessário e mantendo suas
                                empresas protegidas e competitivas.</p>

                            <h5 class="text-white mt-3">Nossos valores</h5>
                            <p class="text-white text-size-16">Ética, transparência, comunicação clara,
                                responsabilidade, parceria com o cliente e inovação jurídica.</p>

                            <a href="/contato" class="text-decoration-none read_more">Fale com a gente<i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Faq Testimonial -->




    @php
        $faqs = [
            [
                'question' => 'Como saber se meu regime tributário é o mais vantajoso para minha empresa?',
                'answer' =>
                    'A escolha do regime ideal depende do seu faturamento, das suas margens de lucro e da sua atividade. Fazemos uma análise personalizada para simular o custo de cada regime e mostrar qual alternativa traz mais economia sem riscos.',
            ],
            [
                'question' => 'O que muda para minha empresa com a Reforma Tributária?',
                'answer' =>
                    'A Reforma vai alterar toda a tributação sobre o consumo. Teremos novas bases de cálculo, formas de apuração, alíquotas e obrigações acessórias. Isso significa que o que hoje é vantajoso pode deixar de ser — ou vice‑versa. Nossa assessoria ajuda a entender quais mudanças vão afetar sua empresa e como ajustar a estrutura para manter segurança e evitar surpresas.',
            ],
            [
                'question' => 'Consultoria tributária mensal realmente vale a pena para resultados consistentes?',
                'answer' =>
                    'Sim, quando feita com constância. O acompanhamento regular permite identificar erros operacionais cedo, ajustar práticas conforme novas normas, evitar autuações e identificar oportunidades de economia, mantendo a tranquilidade tributária enquanto sua empresa cresce.',
            ],
            [
                'question' =>
                    'Minha empresa do Simples Nacional pode recuperar PIS e COFINS monofásicos pagos indevidamente?',
                'answer' =>
                    'Sim — em muitos casos. Se você comercializa produtos sujeitos à tributação monofásica e os recolhimentos foram feitos nesses casos, pode haver crédito a recuperar. O primeiro passo é revisar suas notas fiscais, identificar produtos monofásicos e verificar se houve pagamento indevido no seu DAS.',
            ],
            [
                'question' => 'Qual é o prazo para recuperar tributos pagos indevidamente de PIS e COFINS monofásicos?',
                'answer' => 'O direito de restituição ou compensação abrange os últimos 5 anos (60 meses).',
            ],
            [
                'question' => 'Quais produtos estão sujeitos à tributação monofásica de PIS e COFINS?',
                'answer' =>
                    'A lista inclui medicamentos, cosméticos, certos produtos farmacêuticos, bebidas frias, entre outros, de acordo com a NCM usada nas notas fiscais.',
            ],
            [
                'question' => 'Como negociar débitos federais inscritos em Dívida Ativa da União?',
                'answer' =>
                    'É possível aderir a programas de transação tributária que concedem descontos nos juros e nas multas e parcelamento especial. O primeiro passo é estudar o débito, verificar a capacidade de pagamento e entender se a empresa se enquadra nos critérios exigidos nos editais.',
            ],
        ];

        $faqs = collect($faqs)->shuffle()->take(5)->values()->all();
    @endphp


    <section class="faq-con practicearea-faq legal_situation_faq position-relative">
        <div class="container" style="    padding: 0px 100px 0px 150px;
    margin: 0px;
    max-width: 100%;">
            <div class="faq">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="left_column" data-aos="fade-up">
                            <div class="faq_content mb-0">
                                <h6>Faq’s</h6>
                                <h2>Perguntas Frequentes – FAQ</h2>
                            </div>
                            <div class="accordian-section-inner position-relative">
                                <div class="accordian-inner">
                                    <div id="faq_accordion1" role="tablist" aria-multiselectable="true">
                                        @foreach ($faqs as $faq)
                                            @if (!empty($faq['answer']))
                                                <div class="accordion-card mb-3">
                                                    <div class="card-header" id="heading{{ $loop->index }}"
                                                        role="tab">
                                                        <a href="#"
                                                            class="btn btn-link {{ $loop->first ? '' : 'collapsed' }}"
                                                            data-toggle="collapse"
                                                            data-target="#collapse{{ $loop->index }}"
                                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                            aria-controls="collapse{{ $loop->index }}">
                                                            <h5 style="line-height: 1.3; margin: 0;">
                                                                {{ $faq['question'] }}</h5>
                                                        </a>
                                                    </div>

                                                    <div id="collapse{{ $loop->index }}"
                                                        class="collapse {{ $loop->first ? 'show' : '' }}"
                                                        aria-labelledby="heading{{ $loop->index }}"
                                                        data-parent="#faq_accordion1" role="tabpanel">
                                                        <div class="card-body">
                                                            <p class="text-size-14 text-left mb-0">
                                                                {!! nl2br(e($faq['answer'])) !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 d-flex justify-content-center align-items-center">
                        <div class="practicearea_wrapper text-center" data-aos="zoom-in"
                            style="width: 100%; display: flex; height: 100%; justify-content: center; align-items: center;">
                            <figure class="practicearea-faqimage mb-4" style="margin: 0;">
                                <img src="assets/images/practicearea-faqimage.png" alt="image" class="img-fluid"
                                    style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</div>
