@php
// Copiado de resources/views/livewire/services/tax-consulting.blade.php
@endphp
<section class="singleblog-section blogpage-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="main-box">
                    <figure class="image1 mb-3" data-aos="fade-up" data-aos-duration="700">
                        <img src="/assets/images/singleblog-image1.jpg" alt="image" class="img-fluid" loading="lazy">
                    </figure>
                    <div class="content1" data-aos="fade-up" data-aos-duration="700">
                        <h4>Consultoria Tributária</h4>
                        <div class="span-fa-outer-con"></div>
                        <p class="text-size-16">
                            Nossa consultoria acompanha sua empresa mês a mês, revisando movimentações fiscais, prevenindo riscos e identificando oportunidades. Assim, você evita autuações, garante regularidade e toma decisões seguras para crescer com tranquilidade.
                        </p>
                    </div>
                    <div class="content2" data-aos="fade-up" data-aos-duration="700">
                        <figure class="singleblog-quoteimage">
                            <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="mb-0 text-white text-size-18">Tranquilidade fiscal para sua empresa crescer com segurança e sem surpresas</p>
                    </div>
                    <p class="text text-size-16">Oferecemos revisão periódica de tributos, análise de operações, orientação sobre incentivos fiscais e suporte para tomada de decisões do dia a dia. Relatórios claros e recomendações práticas que geram impacto no caixa e reduzem riscos.</p>
                    <div class="content3" data-aos="fade-up" data-aos-duration="700">
                        <figure class="image1 mb-3" data-aos="fade-up">
                            <img src="/assets/images/singleblog-image2.jpg" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="text text-size-16">Conte com atendimento personalizado: entregamos estratégia, clareza e ação para que sua empresa tenha mais previsibilidade financeira.</p>
                    </div>
                    <div class="content4" data-aos="fade-up" data-aos-duration="700">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="tag">
                                    <h4>Assuntos relacionados</h4>
                                    <ul class="mb-0 list-unstyled ">
                                        <li><a class="button text-decoration-none" href="/servicos/planejamento-tributario">Planejamento Tributário</a></li>
                                        <li><a class="button button2 text-decoration-none" href="/servicos/consultoria-tributaria">Consultoria</a></li>
                                        <li><a class="button button3 text-decoration-none" href="/contato">Fale conosco</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="icon">
                                    <h4>Compartilhar</h4>
                                    <div class="social-icons position-absolute">
                                        @include('components.social-icons', ['wrapper' => 'ul', 'wrapperClass' => 'mb-0 list-unstyled '])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buttons aos-init aos-animate" data-aos="fade-up">
                        <a href="/servicos" class="prev">
                            <span class="prev-text">Voltar para serviços</span>
                        </a>
                        <a href="/contato" class="next">
                            <span class="next-text">Fale conosco</span>
                        </a>
                    </div>
                    <div class="content5" data-aos="fade-up" data-aos-duration="700">
                        <figure class="singleblog-review1 mb-0">
                            <img src="/assets/images/singleblog-review1.png" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <div class="content">
                            <h4>Equipe Cassia Souza Adv</h4>
                            <span class="text-size-16">Consultoria Tributária</span>
                            <p class="text-size-16">Acompanhamento contínuo e orientações práticas que transformam números em decisões seguras para o crescimento do negócio.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 column">
                <div class="box1 box3" data-aos="fade-up" data-aos-duration="700">
                    <h4>Siga-nos</h4>
                    <div class="social-icons">
                        @include('components.social-icons', ['wrapper' => 'ul', 'wrapperClass' => 'mb-0 list-unstyled '])
                    </div>
                </div>
                <div class="box1 box2" data-aos="fade-up" data-aos-duration="700">
                    <h4>Categorias populares</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="text-size-16"><a href="/servicos">Conheça nossos serviços</a></li>
                        <li class="text-size-16"><a href="/contato">Solicite uma proposta</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
