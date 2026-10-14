<div>
    <section class="sub_banner_con position-relative">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12">
                    <div class="sub_banner_content" data-aos="fade-up">
                        <h1 class="text-white">Fale Conosco</h1>
                        <p class="col-xl-7 col-lg-9 mx-auto text-white text-size-16">
                            Entre em contato para tirar dúvidas ou agendar uma consulta gratuita. Nossa equipe está
                            pronta para ajudar sua empresa a conquistar segurança tributária.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-con position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact_content text-center" data-aos="fade-up">
                        <h6>Informações de contato</h6>
                        <h2>Nossos canais de atendimento</h2>
                        <p class="col-xl-8 col-lg-10 mx-auto mb-0 text-size-16">
                            Entre em contato pelo nosso WhatsApp e e-mail para ter um atendimento personalizado e também
                            conheça nossas redes sociais. Eu simplifico a tributação.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row" data-aos="fade-up">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="contact-box">
                        <figure class="contact-icon">
                            <i class="fa-brands fa-tiktok fa-2x"></i>
                        </figure>
                        <h5>Redes Sociais:</h5>
                        <div class="text">
                            <a href="https://www.tiktok.com/@cassia.souza.adv?_t=ZM-90f26k8kEKh&_r=1" target="_blank"
                                class="mb-0 text-decoration-none text-size-14 d-block">TikTok</a>
                            <a href="https://www.linkedin.com/company/cassia-souza-advocacia/" target="_blank"
                                class="mb-0 text-decoration-none text-size-14 d-block">LinkedIn</a>
                            <a href="https://www.instagram.com/cassiasouza.adv/" target="_blank"
                                class="mb-0 text-decoration-none text-size-14 d-block">Instagram</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="contact-box">
                        <figure class="contact-icon">
                            <i class="fa-solid fa-phone fa-2x"></i>
                        </figure>
                        <h5>Telefone:</h5>
                        <div class="text">
                            <a href="{{ config('site.whatsapp_link') }}" target="_blank" rel="noopener noreferrer"
                                class="mb-0 text-decoration-none text-size-14">{{ config('site.whatsapp') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="contact-box mb-0">
                        <figure class="contact-icon">
                            <i class="fa-solid fa-envelope fa-2x"></i>
                        </figure>
                        <h5>E-mail:</h5>
                        <div class="text">
                            <a href="mailto:cassia_souza@adv.oabsp.org.br"
                                class="mb-0 text-decoration-none text-size-14">cassia_souza@adv.oabsp.org.br</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="consultation-con position-relative">
        <figure class="consultation-sideimage mb-0">
            <img src="/assets/images/consultation-sideimage.png" alt="imagem lateral" class="image-fluid">
        </figure>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="consultation_wrapper position-relative">
                        <figure class="consultation-image mb-0">
                            <img src="/assets/img/contato2.png" alt="imagem principal" class="image-fluid">
                        </figure>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="consultation_content" data-aos="fade-up">
                        <h6> Converse com nossa equipe</h6>
                        <h2 class="text-white">Fale Conosco</h2>
                        <livewire:contact-form />
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>