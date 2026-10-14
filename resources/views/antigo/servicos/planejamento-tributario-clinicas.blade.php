@php
// Copiado de resources/views/livewire/services/medical-dental-tax-planning.blade.php
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
                        <h4>Planejamento Tributário para Clínicas Médicas e Odontológicas</h4>
                        <div class="span-fa-outer-con"></div>
                        <p class="text-size-16">
                            Muitos gestores da área da saúde pagam mais impostos do que deveriam simplesmente por desconhecer oportunidades previstas em lei.
                            Para as clínicas médicas e odontológicas existe a possibilidade de <strong>reduzir de forma significativa a carga tributária</strong> por meio de enquadramentos específicos, como a <strong>equiparação hospitalar</strong> no Lucro Presumido.
                        </p>
                        </div>
                        <div class="content2" data-aos="fade-up" data-aos-duration="700">
                            <figure class="singleblog-quoteimage">
                                <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid" loading="lazy">
                            </figure>
                            <p class="mb-0 text-white text-size-18">
                                <strong>Soluções tributárias para o setor da saúde com foco em resultados</strong>
                            </p>
                        </div>
                        <p class="text text-size-16">
                            Nosso papel é estruturar um <strong>planejamento tributário personalizado</strong>, que garanta <strong>economia real, segurança jurídica e previsibilidade financeira</strong>, sempre com ética e dentro da legalidade.
                        </p><div class="content3" data-aos="fade-up" data-aos-duration="700"></div>
                        <figure class="image1 mb-3" data-aos="fade-up">
                            <img src="{{ $imagem2 }}" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="text text-size-16"><strong> Se a sua clínica busca pagar apenas o justo e aumentar a rentabilidade sem riscos, fale conosco.</strong></p>
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
