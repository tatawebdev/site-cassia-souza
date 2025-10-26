<div>
    <section class="practice-con">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="practice_content text-center" data-aos="fade-up">
                        <h6>Our Expertise</h6>
                        <h2>Our Legal Practice Areas</h2>
                        <p class="col-xl-8 col-lg-10 mx-auto text-size-16 mb-0">Nucimus qui blanditiis praesentium
                            voluptatum deleniti atque corrupti quos dolores ruas molestias excepturi
                            sint occaecati cupiditate non provident.
                        </p>
                    </div>
                </div>
            </div>
            @php
            // Adicionei a chave 'route' para cada serviço. As rotas usadas foram mapeadas conforme as rotas existentes
            // fornecidas: servicos.consultoria.tributaria, servicos.defesa.administrativa,
            // servicos.planejamento.tributario, servicos.recuperacao.creditos, servicos.conformidade.tributaria
            // Mapeamentos são suposições razoáveis com base nos títulos dos serviços.
            $services = [
                [
                    'icon' => 'practice-icon1.png',
                    'alt' => 'Regularização PGFN',
                    'title' => 'Regularização PGFN',
                    'text' => 'Atuação completa em processos de regularização junto à PGFN, renegociação e parcelamentos administrativos.',
                    'route' => 'servicos.defesa.administrativa',
                ],
                [
                    'icon' => 'practice-icon2.png',
                    'alt' => 'Planejamento Tributário',
                    'title' => 'Planejamento Tributário',
                    'text' => 'Estratégias fiscais personalizadas para redução de carga tributária dentro da legalidade e segurança jurídica.',
                    'route' => 'servicos.planejamento.tributario',
                ],
                [
                    'icon' => 'practice-icon3.png',
                    'alt' => 'Planejamento Clínicas',
                    'title' => 'Planejamento Clínicas',
                    'text' => 'Consultoria especializada para clínicas e profissionais de saúde, abrangendo aspectos tributários e societários.',
                    'route' => 'servicos.consultoria.tributaria',
                ],
                [
                    'icon' => 'practice-icon4.png',
                    'alt' => 'Assessoria Reforma',
                    'title' => 'Assessoria Reforma',
                    'text' => 'Assessoria em processos de reforma societária, reorganizações e adaptações contratuais.',
                    'route' => 'servicos.conformidade.tributaria',
                ],
                [
                    'icon' => 'practice-icon5.png',
                    'alt' => 'Treinamento Tributário',
                    'title' => 'Treinamento Tributário',
                    'text' => 'Capacitação para equipes financeiras e administrativas sobre compliance tributário e melhores práticas.',
                    'route' => 'servicos.consultoria.tributaria',
                ],
                [
                    'icon' => 'practice-icon6.png',
                    'alt' => 'Recuperação PIS/COFINS',
                    'title' => 'Recuperação PIS/COFINS',
                    'text' => 'Análise e recuperação de créditos de PIS/COFINS, incluindo estudos e procedimentos administrativos e judiciais.',
                    'route' => 'servicos.recuperacao.creditos',
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
                            <h6>About us</h6>
                            <h2 class="text-white">Providing Top-Notch Legal Representation</h2>
                            <p class="text-white text-size-16">Quis autem vel eum iure reprehenderit rui in ea volurate
                                veli esse ruam nihil molestiae conseauatur vel illum rui dolorema
                                eum fugiat ruo voluetas nulla pariatur.
                            </p>
                            <ul class="list-unstyled">
                                <li>
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <p class="mb-0 text-size-16">Excepteur sint occaecat cupidatat noru even.</p>
                                </li>
                                <li>
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <p class="mb-0 text-size-16">Duis aute irure dolor in reprehenderit in voluta facis.
                                    </p>
                                </li>
                                <li>
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <p class="mb-0 text-size-16">Rerum hic tenetur a sapiente delectus au occae.</p>
                                </li>
                            </ul>
                            <a href="./about.html" class="text-decoration-none read_more">Read More<i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ -->
    <section class="faq-con practicearea-faq position-relative">
        <div class="container">
            <div class="faq">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="left_column" data-aos="fade-up">
                            <div class="faq_content mb-0">
                                <h6>Faq’s</h6>
                                <h2>Frequently Asked Questions</h2>
                                <p class="text-size-16">Nucimus qui blanditiis praesentium voluptatum deleniti atque
                                    corrupti quos dolores ruas molestias.
                                </p>
                            </div>
                            <div class="accordian-section-inner position-relative">
                                <div class="accordian-inner">
                                    <div id="faq_accordion1">
                                        <div class="accordion-card">
                                            <div class="card-header" id="headingOne">
                                                <a href="#" class="btn btn-link collapsed" data-toggle="collapse"
                                                    data-target="#collapseOne" aria-expanded="false"
                                                    aria-controls="collapseOne">
                                                    <h5>How do I choose a personal injury lawyer?</h5>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                                                <div class="card-body">
                                                    <p class="text-size-14 text-left mb-0">Labore et dolore magna aliqua
                                                        quis ipsum suspendis seultrices gravida risus commo ddolore.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-card">
                                            <div class="card-header" id="headingTwo">
                                                <a href="#" class="btn btn-link collapsed" data-toggle="collapse"
                                                    data-target="#collapseTwo" aria-expanded="false"
                                                    aria-controls="collapseTwo">
                                                    <h5>What should I do if I am involved in a car accident?</h5>
                                                </a>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo">
                                                <div class="card-body">
                                                    <p class="text-size-14 text-left mb-0">Labore et dolore magna aliqua
                                                        quis ipsum suspendis seultrices gravida risus commo ddolore.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-card">
                                            <div class="card-header" id="headingThree">
                                                <a href="#" class="btn btn-link collapsed" data-toggle="collapse"
                                                    data-target="#collapseThree" aria-expanded="false"
                                                    aria-controls="collapseThree">
                                                    <h5>How much does legal representation cost?</h5>
                                                </a>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree">
                                                <div class="card-body">
                                                    <p class="text-size-14 text-left mb-0">Labore et dolore magna aliqua
                                                        quis ipsum suspendis seultrices gravida risus commo ddolore.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-card">
                                            <div class="card-header" id="headingFour">
                                                <a href="#" class="btn btn-link collapsed" data-toggle="collapse"
                                                    data-target="#collapseFour" aria-expanded="false"
                                                    aria-controls="collapseFour">
                                                    <h5>How Do I Choose the Right Attorney?</h5>
                                                </a>
                                            </div>
                                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour">
                                                <div class="card-body">
                                                    <p class="text-size-14 text-left mb-0">Labore et dolore magna aliqua
                                                        quis ipsum suspendis seultrices gravida risus commo ddolore.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="practicearea_wrapper position-relative" data-aos="zoom-in">
                            <figure class="practicearea-faqimage mb-0">
                                <img src="/assets/images/practicearea-faqimage.png" alt="image" class="image-fluid">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>