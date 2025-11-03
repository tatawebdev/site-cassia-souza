@php
// Copiado de resources/views/livewire/services/tax-compliance.blade.php
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
                        <h4>Compliance Tributário</h4>
                        <div class="span-fa-outer-con"></div>
                        <p class="text-size-16">Soluções em compliance tributário para sua empresa: processos, controles e monitoramento que evitam riscos e garantem conformidade.</p>
                    </div>
                    <div class="content2" data-aos="fade-up" data-aos-duration="700">
                        <figure class="singleblog-quoteimage">
                            <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="mb-0 text-white text-size-18">Controle, governança e redução de riscos fiscais</p>
                    </div>
                    <p class="text text-size-16">Implementamos políticas e rotinas fiscais, verificamos obrigações acessórias e oferecemos monitoramento contínuo para garantir que sua empresa esteja alinhada às exigências legais.</p>
                    <div class="content3" data-aos="fade-up" data-aos-duration="700">
                        <figure class="image1 mb-3" data-aos="fade-up">
                            <img src="{{ $imagem2 }}" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="text text-size-16">Nossos serviços de compliance reduzem a exposição a autuações e proporcionam segurança nas decisões operacionais e estratégicas.</p>
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
