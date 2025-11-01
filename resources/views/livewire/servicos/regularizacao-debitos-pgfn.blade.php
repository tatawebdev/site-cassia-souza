@php
// View para Regularização de Débitos (PGFN)
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
                        <h4>Regularização de Débitos (PGFN)</h4>
                        <div class="span-fa-outer-con"></div>
                        <p class="text-size-16">Negociação de débitos em Dívida Ativa com descontos, parcelamentos e pedidos de revisão, para recuperar fôlego financeiro e evitar bloqueios.</p>
                    </div>
                    <div class="content2" data-aos="fade-up" data-aos-duration="700">
                        <figure class="singleblog-quoteimage">
                            <img src="/assets/images/singleblog-quoteimage.png" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="mb-0 text-white text-size-18">Negociação e soluções para dívidas ativas</p>
                    </div>
                    <p class="text text-size-16">Atuamos na negociação, parcelamento e revisão de débitos inscritos em Dívida Ativa, com foco em preservar a operação e reduzir encargos.</p>
                    <div class="content3" data-aos="fade-up" data-aos-duration="700">
                        <figure class="image1 mb-3" data-aos="fade-up">
                            <img src="{{ $imagem2 }}" alt="image" class="img-fluid" loading="lazy">
                        </figure>
                        <p class="text text-size-16">Analisamos possibilidades de parcelamento, pedidos de transação, e revisão de débitos para recuperar a saúde financeira da empresa.</p>
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
