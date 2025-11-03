<div>
    <!-- Committed -->
    <section class="committed-con position-relative">
        <figure class="committed-rightimage mb-0">
            <img src="/assets/images/committed-rightimage.png" alt="image" class="img-fluid">
        </figure>
        <figure class="committed-leftimage mb-0">
            <img src="/assets/images/committed-leftimage.png" alt="image" class="img-fluid">
        </figure>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="committed_content" data-aos="fade-up">
                        <h6>Cassia Souza Advocacia Tributária</h6>
                        <h2 class="col-lg-10 col-md-10 col-md-12 p-0">Estratégia, clareza e segurança para empresas que
                            querem crescer do jeito certo.</h2>
                        <p class="col-xl-7 col-lg-8 text-size-16 text1 p-0">A Cassia Souza Advocacia é um escritório
                            especializado em Direito Tributário, focado em oferecer soluções estratégicas para
                            empresas que desejam pagar apenas o justo em tributos, recuperar valores pagos
                            indevidamente e garantir segurança jurídica para crescer com tranquilidade.</p>
                        <p class="col-xl-7 col-lg-8 text-size-16 text2 p-0">Atuamos de forma consultiva e
                            preventiva, identificando oportunidades legais de economia, regularizando pendências e
                            preparando sua empresa para mudanças como a Reforma Tributária. Trabalhamos com
                            linguagem simples, transparência e foco no resultado: economia, previsibilidade e
                            proteção patrimonial.</p>
                        <a href="./practice-area.html" class="text-decoration-none read_more">Saiba mais<i
                                class="fa-solid fa-arrow-right"></i></a>
                        <figure class="committed-image mb-0">
                            <img src="/assets/images/committed-image.png" alt="image" class="img-fluid">
                        </figure>
                    </div>
                </div>
            </div>
            <div class="committed_wrapper" >
                @php
                    $services = [
                        'Consultoria Tributária Mensal',
                        'Planejamento Tributário',
                        'Regularização de Débitos (PGFN)',
                        'Recuperação de PIS/COFINS',
                        'Assessoria para Reforma Tributária',
                        'Treinamentos Tributários',
                        'Consultoria para Clínicas e Profissionais',
                        'Contencioso e Defesa Fiscal',
                    ];
                @endphp
                <div class="d-flex flex-wrap justify-content-center " style="gap: 24px 32px;">
                    @foreach ($services as $service)
                        <div class="committed-box text-center py-2 px-4 shadow-lg rounded-2 bg-white"
                            style="display:inline-block; width:auto; min-width:220px; margin:0; transition:background 0.2s, color 0.2s;">
                            <h5 class="mb-0 text-[#66004d] whitespace-normal" style="transition:color 0.2s;">{{ $service }}</h5>
                        </div>
                        <style>
                            .committed-box:hover {
                                background: #66004d !important;
                                color: #fff !important;
                            }
                            .committed-box:hover h5 {
                                color: #fff !important;
                            }
                        </style>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Consultation -->
    <section class="consultation-con position-relative">
        <figure class="consultation-sideimage mb-0">
            <img src="/assets/images/consultation-sideimage.png" alt="image" class="image-fluid">
        </figure>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="consultation_wrapper position-relative">
                        <figure class="consultation-image mb-0">
                            <img src="/assets/images/consultation-image.jpg" alt="image" class="image-fluid">
                        </figure>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="consultation_content" data-aos="fade-up">
                        <h6>Fale conosco</h6>
                        <h2 class="text-white">Solicite uma análise inicial gratuita</h2>
                        <form id="contactpage" method="post" class="position-relative">
                            <div class="form-group input1 float-left">
                                <input type="text" class="form_style" placeholder="Nome" name="fname"
                                    id="fname">
                            </div>
                            <div class="form-group float-left">
                                <input type="tel" class="form_style" placeholder="Telefone" name="phone"
                                    id="phone">
                            </div>
                            <div class="form-group input1 float-left">
                                <input type="email" class="form_style" placeholder="E-mail" name="email"
                                    id="email">
                            </div>
                            <div class="form-group float-left">
                                <select class="form-control">
                                    <option>Área de interesse</option>
                                    <option>Consultoria Tributária</option>
                                    <option>Planejamento Tributário</option>
                                    <option>Regularização / PGFN</option>
                                </select>
                            </div>
                            <div class="form-group message">
                                <textarea class="form_style" placeholder="Mensagem" rows="3" name="msg"></textarea>
                            </div>
                            <button id="submit" type="submit" class="appointment">Enviar solicitação<i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Case -->
    <section class="case-con">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="case_content text-center" data-aos="fade-up">
                        <h6>Serviços</h6>
                        <h2>Nossas principais <span class="span_borderbootom">atuações</span></h2>
                        <p class="text-size-16 mb-0">Atuamos em consultoria contínua, planejamento,
                            recuperação de créditos e defesa fiscal — com foco em resultados mensuráveis para sua
                            empresa.</p>
                    </div>
                </div>
            </div>
            <div class="row" data-aos="fade-up">
                <div class="col-12">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image1.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Car Insurance</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image2.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Business & Family</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image3.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Taxes & Civil</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image4.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Corporate Security</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image5.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Property & Real Estate</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image1.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Car Insurance</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image2.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Business & Family</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image3.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Taxes & Civil</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image4.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Corporate Security</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image5.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Property & Real Estate</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image1.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Car Insurance</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image2.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Business & Family</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image3.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Taxes & Civil</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image4.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Corporate Security</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="case-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/case-image5.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <span class="field">Property & Real Estate</span>
                                    <span class="law">Law & Attorney</span>
                                    <a href="./case-studies.html" class="text-decoration-none arrow_button"><i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Violence -->
    <section class="violence-con position-relative">
        <div class="container">
            <div class="row">
                <div class="violence_wrapper position-relative">
                    <div class="violence_content" data-aos="fade-up">
                        <h1 class="text-white">Proteção patrimonial e tributária</h1>
                        <p class="text-white text-size-16">Garantimos assessoria estratégica para proteger o
                            patrimônio da empresa e mitigar riscos decorrentes de autuações e cobranças indevidas.
                        </p>
                        <a href="./contact.html" class="text-decoration-none appointment">Fale com nossa equipe<i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Article -->
    <section class="article-con">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="article_content text-center" data-aos="fade-up">
                        <h6>Artigos e notícias</h6>
                        <h2>Conteúdo sobre <span class="span_borderbootom">Direito Tributário</span></h2>
                        <p class="col-xl-8 col-lg-10 mx-auto text-size-16 mb-0">Publicamos análises e atualizações
                            sobre tributos, decisões relevantes e orientações práticas para gestores e
                            profissionais da área fiscal.</p>
                    </div>
                </div>
            </div>
            <div class="row" data-aos="fade-up">
                <div class="col-12">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="article-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/article-image1.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <div class="span_wrapper">
                                        <span>March 18, 2019</span>
                                        <span class="dash">-</span>
                                        <span>0 Comments</span>
                                    </div>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <h5>Maiores alias consequatur perferendis doloribus</h5>
                                    </a>
                                    <p class="text-size-14">Aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum...</p>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="article-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/article-image2.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <div class="span_wrapper">
                                        <span>March 18, 2019</span>
                                        <span class="dash">-</span>
                                        <span>0 Comments</span>
                                    </div>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <h5>Eiusmod tempor incididunt labore aet dolore</h5>
                                    </a>
                                    <p class="text-size-14">Rute irure dolor in reprehenderit in voluptate velit esse
                                        cillum...</p>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="article-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/article-image3.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <div class="span_wrapper">
                                        <span>March 18, 2019</span>
                                        <span class="dash">-</span>
                                        <span>0 Comments</span>
                                    </div>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <h5>Dolore aeu fugiat nulla paria sint occaecat</h5>
                                    </a>
                                    <p class="text-size-14">Gute irure dolor in reprehenderit in voluptate velit esse
                                        cillum...</p>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="article-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/article-image1.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <div class="span_wrapper">
                                        <span>March 18, 2019</span>
                                        <span class="dash">-</span>
                                        <span>0 Comments</span>
                                    </div>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <h5>Maiores alias consequatur perferendis doloribus</h5>
                                    </a>
                                    <p class="text-size-14">Aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum...</p>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="article-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/article-image2.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <div class="span_wrapper">
                                        <span>March 18, 2019</span>
                                        <span class="dash">-</span>
                                        <span>0 Comments</span>
                                    </div>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <h5>Eiusmod tempor incididunt labore aet dolore</h5>
                                    </a>
                                    <p class="text-size-14">Rute irure dolor in reprehenderit in voluptate velit esse
                                        cillum...</p>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="article-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/article-image3.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <div class="span_wrapper">
                                        <span>March 18, 2019</span>
                                        <span class="dash">-</span>
                                        <span>0 Comments</span>
                                    </div>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <h5>Dolore aeu fugiat nulla paria sint occaecat</h5>
                                    </a>
                                    <p class="text-size-14">Gute irure dolor in reprehenderit in voluptate velit esse
                                        cillum...</p>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="article-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/article-image1.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <div class="span_wrapper">
                                        <span>March 18, 2019</span>
                                        <span class="dash">-</span>
                                        <span>0 Comments</span>
                                    </div>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <h5>Maiores alias consequatur perferendis doloribus</h5>
                                    </a>
                                    <p class="text-size-14">Aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum...</p>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="article-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/article-image2.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <div class="span_wrapper">
                                        <span>March 18, 2019</span>
                                        <span class="dash">-</span>
                                        <span>0 Comments</span>
                                    </div>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <h5>Eiusmod tempor incididunt labore aet dolore</h5>
                                    </a>
                                    <p class="text-size-14">Rute irure dolor in reprehenderit in voluptate velit esse
                                        cillum...</p>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="article-box">
                                <figure class="mb-0">
                                    <img src="/assets/images/article-image3.jpg" alt="image" class="img-fluid">
                                </figure>
                                <div class="box-content">
                                    <div class="span_wrapper">
                                        <span>March 18, 2019</span>
                                        <span class="dash">-</span>
                                        <span>0 Comments</span>
                                    </div>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <h5>Dolore aeu fugiat nulla paria sint occaecat</h5>
                                    </a>
                                    <p class="text-size-14">Gute irure dolor in reprehenderit in voluptate velit esse
                                        cillum...</p>
                                    <a href="single-blog.html" class="text-decoration-none">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
