<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $title ?? 'Cassia Souza Advocacia Tributária' }}</title>
    <!-- /SEO Ultimate -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Latest compiled and minified CSS -->
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/js/bootstrap.min.js">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- StyleSheet link CSS -->
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.theme.default.min.css" rel="stylesheet" type="text/css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
</head>
<body>
<!-- Back to top button -->
<a id="button"></a>

<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <a class="navbar-brand" href="/">
                <figure class="logo mb-0"><img width="150px" src="./assets/images/logo-acinzentado.png" alt="logo" class="img-fluid"></figure>
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Página Inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">Quem Somos</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-color navbar-text-color" href="#" id="navbarDropdownArea" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Área de Atuação
                        </a>
                        <div class="dropdown-menu drop-down-content" aria-labelledby="navbarDropdownArea">
                            <ul class="list-unstyled drop-down-pages">
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Consultoria Tributária</a></li>
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Defesa Administrativa</a></li>
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Planejamento Fiscal</a></li>
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Recuperação de Créditos</a></li>
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Compliance Tributário</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contato</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

{{ $slot }}

<!-- Footer -->
<section class="footer-con position-relative" id="footer">
    <div class="container position-relative">
        <div class="row">
            <div class="col-12">
                <div class="upper_portion" data-aos="fade-up">
                    <div class="heading">
                        <h6 class="text-white" style="font-family: Arial, sans-serif; font-size: 14px;">Newsletter</h6>
                        <h3 class="text-white mb-0" style="font-family: 'Times New Roman', serif; font-size: 24px;">Receba novidades e dicas tributárias</h3>
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
                            <figure  class="mb-0" style="width: 250px;"><img style="width: 250px;" src="./assets/images/logo-acinzentado.png" alt="logo"></figure>
                        </a>
                        <p class="text-size-14">
                            
                        </p>
                        <ul class="list-unstyled mb-0 social-icons">
                            <li><a href="https://www.facebook.com/login/" class="text-decoration-none"><i class="fa-brands fa-facebook-f social-networks"></i></a></li>
                            <li><a href="https://twitter.com/i/flow/login" class="text-decoration-none"><i class="fa-brands fa-x-twitter social-networks"></i></a></li>
                            <li><a href="https://www.linkedin.com/login" class="text-decoration-none"><i class="fa-brands fa-linkedin social-networks"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-2 col-md-4 col-sm-4 col-6">
                    <div class="links">
                        <h4 class="heading">Links Úteis</h4>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/" class=" text-size-14 text text-decoration-none">Início</a></li>
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/about" class=" text-size-14 text text-decoration-none">Quem Somos</a></li>
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/blog-details" class=" text-size-14 text text-decoration-none">Soluções</a></li>
                             <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-color navbar-text-color" href="#" id="navbarDropdownArea" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Área de Atuação
                        </a>
                        <div class="dropdown-menu drop-down-content" aria-labelledby="navbarDropdownArea">
                            <ul class="list-unstyled drop-down-pages">
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Consultoria Tributária</a></li>
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Defesa Administrativa</a></li>
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Planejamento Fiscal</a></li>
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Recuperação de Créditos</a></li>
                                <li class="nav-item"><a class="dropdown-item nav-link" href="#">Compliance Tributário</a></li>
                            </ul>
                        </div>
                    </li>
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/blog" class=" text-size-14 text text-decoration-none">Blog</a></li>

                            <li><i class="fa-solid fa-arrow-right"></i><a href="/contact" class=" text-size-14 text text-decoration-none">Contato</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                    <div class="timing">
                        <h4 class="heading">Horário de Atendimento</h4>
                        <ul class="list-unstyled mb-0">
                            <li><p>Segunda a Sexta</p></li>
                            <li><span>09:00 – 18:00</span></li>
                            <li><p>Sábado</p></li>
                            <li><span>09:00 – 13:00</span></li>
                            <li><p>Domingo</p></li>
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
                            <li class="text">
                                <i class="fa-solid fa-location-dot"></i>
                                
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
        <p class="mb-0">Copyright © cassiasouzaadvocacia.com.brT, Todos os direitos reservados 2025 - Desenvolvido por Tata Web</p>
    </div>
</section>
<!-- PRE LOADER -->
<div class="loader-mask">
    <div class="loader">
        <div></div>
        <div></div>
    </div>
</div>
<!-- Latest compiled JavaScript -->
<script src="/assets/js/jquery-3.7.1.min.js"></script>
<script src="/assets/js/popper.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="/assets/js/owl.carousel.js"></script>
<script src="/assets/js/carousel.js"></script>
<script src="/assets/js/animation.js"></script>
<script src="/assets/js/video-popup.js"></script>
<script src="/assets/js/video.js"></script>
<script src="/assets/js/back-to-top-button.js"></script>
<script src="/assets/js/preloader.js"></script>
<script src="/assets/js/popup-image.js"></script>
<script src="/assets/js/contact-form.js"></script>
<script src="/assets/js/contact-validate.js"></script>
<script src="/assets/js/counter.js"></script>
</body>
</html>