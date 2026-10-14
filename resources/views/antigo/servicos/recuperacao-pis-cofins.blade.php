@php
    // Copiado de resources/views/livewire/services/piscofins-recovery.blade.php
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
                        <h4>Recuperação de PIS/COFINS (Monofásicos)</h4>
                        <div class="span-fa-outer-con"></div>
                        <p class="text-size-16"></p>
                        Muitas empresas acabam pagando <strong>PIS e COFINS monofásicos além do necessário</strong>, sem
                        perceber que esses valores podem ser recuperados de forma legal e estratégica.
                        </p>
                    </div>
                    <div class="content2" data-aos="fade-up" data-aos-duration="700">
                        <figure class="singleblog-quoteimage">
                            <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid"
                                loading="lazy">
                        </figure>
                        <p class="mb-0 text-white text-size-18"><strong>Recupere créditos e melhore seu fluxo de
                                caixa</strong></p>
                    </div>
                    <p class="text text-size-16">
                        Nós analisamos as operações, identificamos <strong>créditos tributários legítimos</strong> e
                        aplicamos a legislação vigente para <strong>transformar pagamentos indevidos em recursos que
                            fortalecem o caixa da sua empresa</strong>.
                    </p>
                    <div class="content3" data-aos="fade-up" data-aos-duration="700">
                        <figure class="image1 mb-3" data-aos="fade-up">
                            <img src="{{ $imagem2 }}" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="text text-size-16">
                            Com <strong>segurança jurídica</strong> e atuação especializada, ajudamos sua empresa a
                            <strong>reduzir custos</strong>, ganhar fôlego financeiro e investir no que realmente
                            importa: o crescimento do seu negócio.
                            <strong> Fale conosco e descubra quanto sua empresa pode recuperar.</strong>
                        </p>
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