@php
// Copiado de resources/views/livewire/services/tax-reform-advisory.blade.php
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
                        <h4>Assessoria para a Reforma Tributária</h4>
                        <div class="span-fa-outer-con"></div>
                        <p class="text-size-16">
                            A Reforma Tributária está transformando o sistema tributário brasileiro.<br><br>
                            <strong>A questão é: sua empresa está preparada para as mudanças?</strong>
                        </p>
                        <p class="text-size-16">
                            Oferecemos assessoria jurídica especializada para ajudar empresários a compreender os impactos da Reforma e a se adaptar com <strong>segurança, clareza e orientações estratégicas.</strong>
                        </p>
                        <div class="content2" data-aos="fade-up" data-aos-duration="700">
                            <figure class="singleblog-quoteimage">
                                <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid" loading="lazy">
                            </figure>
                            <p class="mb-0 text-white text-size-18">
                                Com nossa assessoria, você terá apoio em:
                            </p>
                        </div>
                        <ul class="text text-size-16">
                            <li>Análise dos principais pontos da Reforma Tributária e seus efeitos diretos na sua empresa;</li>
                            <li>Avaliação dos impactos na carga tributária e no fluxo financeiro;</li>
                            <li>Estratégias de transição para o novo modelo tributário;</li>
                            <li>Identificação de riscos e oportunidades no novo cenário;</li>
                            <li>Treinamentos e materiais práticos para gestores e equipes.</li>
                        </ul>
                        <div class="content3" data-aos="fade-up" data-aos-duration="700">
                            <figure class="image1 mb-3" data-aos="fade-up">
                                <img src="{{ $imagem2 }}" alt="image" class="img-fluid" loading="lazy">
                            </figure>
                            <p class="text text-size-16">
                                Antecipe-se às mudanças e transforme a Reforma Tributária em oportunidade.<br>
                                <strong>Fale conosco e garanta que sua empresa avance com confiança.</strong>
                            </p>
                        </div>
                    </div>
                    <div class="content4" data-aos="fade-up" data-aos-duration="700">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="tag">
                                    <h4>Assuntos relacionados</h4>
                                    <ul class="mb-0 list-unstyled ">
                                        <li><a class="button text-decoration-none" href="/contato">Avaliação de impacto</a></li>
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
                        <a href="/contato" class="next"><span class="next-text">Solicitar assessoria</span></a>
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
