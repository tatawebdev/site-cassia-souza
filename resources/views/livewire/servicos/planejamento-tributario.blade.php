@php
// Copiado de resources/views/livewire/services/tax-planning.blade.php
@endphp
<section class="singleblog-section blogpage-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="main-box">
                    <figure class="image1 mb-3" data-aos="fade-up" data-aos-duration="700">
                        <img src="{{ $imagem1 }}" alt="image" class="img-fluid" loading="lazy">
                    </figure>
                    <div class="content1" data-aos="fade-up" data-aos-duration="700">
                        <h4>Planejamento Tributário</h4>
                        <div class="span-fa-outer-con"></div>
                        <p class="text-size-16">
                            Pagar tributos de forma inteligente não é apenas reduzir custos — é <strong>ganhar segurança, previsibilidade e liberdade para crescer.</strong>
                            <br><br>
                            Nosso planejamento tributário é estruturado sob medida para que sua empresa <strong>pague apenas o que é devido</strong>, sem riscos de autuações e com total conformidade legal.
                        </p>
                        </div>
                        <div class="content2" data-aos="fade-up" data-aos-duration="700">
                            <figure class="singleblog-quoteimage">
                                <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid" loading="lazy">
                            </figure>
                            <p class="mb-0 text-white text-size-18"><strong>Segurança e previsibilidade tributária para decisões confiantes</strong></p>
                        </div>
                        <p class="text text-size-16">
                            Apoiamos desde a <strong>escolha do regime tributário mais vantajoso</strong> (inclusive para novos CNPJs) até a <strong>reestruturação de empresas em operação</strong>, identificando oportunidades de economia e fortalecendo a saúde financeira do negócio.
                        </p>
                        <div class="content3" data-aos="fade-up" data-aos-duration="700">
                            <figure class="image1 mb-3" data-aos="fade-up">
                                <img src="{{ $imagem2 }}" alt="image" class="img-fluid" loading="lazy">
                            </figure>
                            <p class="text text-size-16">
                                Com a estratégia certa, você transforma os tributos em aliados do crescimento.
                                <br><br>
                                <strong>Fale conosco e descubra como otimizar sua carga tributária com inteligência e segurança.</strong>
                            </p>
                    </div>
                    <div class="content4" data-aos="fade-up" data-aos-duration="700">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="tag">
                                    <h4>Assuntos relacionados</h4>
                                    <ul class="mb-0 list-unstyled ">
                                        <li><a class="button text-decoration-none" href="/servicos/planejamento-tributario-clinicas">Planejamento Clínicas</a></li>
                                        <li><a class="button button2 text-decoration-none" href="/contato">Solicitar diagnóstico</a></li>
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
                        <a href="/servicos" class="prev"><span class="prev-text">Voltar</span></a>
                        <a href="/contato" class="next"><span class="next-text">Solicitar diagnóstico</span></a>
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
            </div>
        </div>
    </div>
</section>
