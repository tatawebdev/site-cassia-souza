@php
// Copiado de resources/views/livewire/services/credit-recovery.blade.php
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
                        <h4>Recuperação de Crédito</h4>
                        <div class="span-fa-outer-con"></div>
                        <p class="text-size-16">Atuamos na identificação e recuperação de créditos e valores pagos indevidamente, por meio de análises contábeis e fiscais e de medidas administrativas e judiciais quando necessárias.</p>
                    </div>
                    <div class="content2" data-aos="fade-up" data-aos-duration="700">
                        <figure class="singleblog-quoteimage">
                            <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="mb-0 text-white text-size-18">Recupere valores e fortaleça seu caixa</p>
                    </div>
                    <p class="text text-size-16">Realizamos levantamento documental, análise de oportunidades de crédito e adotamos as medidas cabíveis para assegurar a recuperação de valores com segurança jurídica.</p>
                    <div class="content3" data-aos="fade-up" data-aos-duration="700">
                        <figure class="image1 mb-3" data-aos="fade-up">
                            <img src="{{ $imagem2 }}" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="text text-size-16">Nosso trabalho devolve recursos ao caixa da empresa e contribui para a saúde financeira e a capacidade de investimento do negócio.</p>
                    </div>
                    <div class="content4" data-aos="fade-up" data-aos-duration="700">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="tag">
                                    <h4>Assuntos relacionados</h4>
                                    <ul class="mb-0 list-unstyled ">
                                        <li><a class="button text-decoration-none" href="/contato">Solicitar análise</a></li>
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
                        <a href="/contato" class="next"><span class="next-text">Solicitar análise</span></a>
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
