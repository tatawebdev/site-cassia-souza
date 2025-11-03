@php
    // Copiado de resources/views/livewire/services/tax-training.blade.php
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
                        <h4>Treinamento Tributário para Empresas</h4>
                        <div class="span-fa-outer-con"></div>
                        <p class="text-size-16">
                            <strong>Treinamos sua equipe em gestão tributária com clareza e exemplos práticos.</strong>
                            Capacitação personalizada para <strong>reduzir riscos, evitar autuações e otimizar rotinas
                                fiscais</strong> — presencial ou online.
                        </p>
                    </div>
                    <div class="content2" data-aos="fade-up" data-aos-duration="700">
                        <figure class="singleblog-quoteimage">
                            <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid"
                                loading="lazy">
                        </figure>
                        <p class="mb-0 text-white text-size-18">
                            <strong>Transforme conhecimento em segurança e resultados</strong>
                        </p>
                    </div>
                    <p class="text text-size-16">
                        <strong>Nossos treinamentos são práticos e aplicáveis</strong>, com materiais e exercícios
                        pensados para a realidade do seu departamento fiscal e financeiro.
                        Podemos oferecer <strong>turmas presenciais ou programas online adaptados à sua
                            empresa</strong>.
                    </p>
                    <div class="content3" data-aos="fade-up" data-aos-duration="700">
                        <figure class="image1 mb-3" data-aos="fade-up">
                            <img src="{{ $imagem2 }}" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="text text-size-16">
                            <strong>Capacite sua equipe e minimize erros operacionais que geram autuações e custos
                                desnecessários.</strong>
                            Solicite nossa proposta de treinamento.
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