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
                        <p class="text-size-16">Muitas empresas acabam pagando PIS e COFINS monofásicos além do necessário, sem perceber que esses valores podem ser recuperados de forma legal e estratégica. </p>
                    </div>
                    <div class="content2" data-aos="fade-up" data-aos-duration="700">
                        <figure class="singleblog-quoteimage">
                            <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="mb-0 text-white text-size-18">Recupere créditos e melhore seu fluxo de caixa</p>
                    </div>
                    <p class="text text-size-16">Nós analisamos as operações, identificamos créditos tributários legítimos e aplicamos a legislação vigente para transformar pagamentos indevidos em recursos que fortalecem o caixa da sua empresa. </p>
                    <div class="content3" data-aos="fade-up" data-aos-duration="700">
                        <figure class="image1 mb-3" data-aos="fade-up">
                            <img src="{{ $imagem2 }}" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="text text-size-16">
Com segurança jurídica e atuação especializada, ajudamos sua empresa a reduzir custos, ganhar fôlego financeiro e investir no que realmente importa: o crescimento do seu negócio.

<strong> Fale conosco e descubra quanto sua empresa pode recuperar.</strong></p>
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
