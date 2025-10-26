<section class="footer-con position-relative" id="footer">
    <div class="container position-relative">
        <div class="row">
            <div class="col-12">
                <div class="upper_portion" data-aos="fade-up">
                    <div class="heading">
                        <h6 class="text-white" style="font-family: Arial, sans-serif; font-size: 14px;">Newsletter
                        </h6>
                        <h3 class="text-white mb-0" style="font-family: 'Times New Roman', serif; font-size: 24px;">
                            Receba novidades e dicas tributárias</h3>
                    </div>
                    <form action="javascript:;">
                        <div class="form-group position-relative mb-0">
                            <input type="text" class="form_style" placeholder="Seu e-mail" name="email">
                            <button>Inscrever-se<i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="middle_portion">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="logo-content">
                        <a href="/" class="footer-logo">
                            <figure class="mb-0" style="width: 250px;"><img style="width: 250px;"
                                    src="./assets/images/logo-acinzentado.png" alt="logo"></figure>
                        </a>
                        <p class="text-size-14">
                            Escritório especializado em advocacia tributária. Soluções personalizadas para empresas
                            que buscam segurança, economia e regularidade fiscal.
                        </p>
                        @include('components.social-icons', ['wrapper' => 'ul', 'wrapperClass' => 'list-unstyled mb-0 social-icons'])
                    </div>
                </div>
                <div class="col-xl-3 col-lg-2 col-md-4 col-sm-4 col-6">
                    <div class="links">
                        <h4 class="heading">Links Úteis</h4>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fa-solid fa-arrow-right"></i>
                                <a href="/" class=" text-size-14 text text-decoration-none">Início</a>
                            </li>
                            <li><i class="fa-solid fa-arrow-right"></i>
                                <a href="/sobre-nos" class=" text-size-14 text text-decoration-none">Quem Somos</a>
                            </li>
                            <li><i class="fa-solid fa-arrow-right"></i>
                                <a href="http://blog.cassiasouzaadvocacia.com.br/" target="_blank"
                                    class=" text-size-14 text text-decoration-none">Blog</a>
                            </li>
                            <li><i class="fa-solid fa-arrow-right"></i>
                                <a href="/contact" class=" text-size-14 text text-decoration-none">Contato</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                    <div class="timing">
                        <h4 class="heading">Horário de Atendimento</h4>
                        <ul class="list-unstyled mb-0">
                            <li>
                                <p>Segunda a Sexta</p>
                            </li>
                            <li><span>09:00 – 18:00</span></li>
                            <li>
                                <p>Sábado</p>
                            </li>
                            <li><span>09:00 – 13:00</span></li>
                            <li>
                                <p>Domingo</p>
                            </li>
                            <li><span class="mb-0">Fechado</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                    <div class="icon">
                        <h4 class="heading">Contato</h4>
                        <ul class="list-unstyled mb-0">
                            <li class="text">
                                <i class="fa-solid fa-phone"></i>
                                <a href="tel:+5511915201084" class="text-decoration-none">+55 11 91520 1084</a>
                            </li>
                            <li class="text">
                                <i class="fa-solid fa-envelope"></i>
                                <a href="mailto:contato@cassiasouzaadvocacia.com.br"
                                    class="text-decoration-none">contato@cassiasouzaadvocacia.com.br</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="fixed-form-container">
        <div class="image">
            <figure class="footer-contactimage mb-0">
                <img src="./assets/images/footer-contactimage.png" alt="imagem" class="img-fluid">
            </figure>
        </div>
        <div class="body" style="display: none;">
            <form action="javascript:;">
                <div class="form-group mb-0">
                    <input type="text" class="form_style" placeholder="Nome" name="name">
                </div>
                <div class="form-group mb-0">
                    <input type="email" class="form_style" placeholder="E-mail" name="emailid">
                </div>
                <div class="form-group mb-0">
                    <input type="tel" class="form_style" placeholder="Telefone" name="phone">
                </div>
                <div class="form-group mb-0">
                    <textarea class="form_style" placeholder="Mensagem" rows="3" name="msg"></textarea>
                </div>
                <button type="submit" class="submit_now text-decoration-none">Enviar</button>
            </form>
        </div>
    </div>
    <div class="copyright">
        <p class="mb-0">Copyright © cassiasouzaadvocacia.com.br, Todos os direitos reservados 2025</p>
    </div>
</section>