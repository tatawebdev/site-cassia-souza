<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $title ?? 'Cassia Souza Advocacia Tributária' }}</title>
    <meta name="description"
        content="Cassia Souza Advocacia Tributária: Especialistas em planejamento, contencioso e consultoria tributária para empresas e pessoas físicas.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="images/logo/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/meanmenu.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/all-animations.css">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
    <div id="preloader">
        <div id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                </div>
            </div>
        </div>
    </div>
    <header>
        <div class="transparent-header header-area">
            <div class="header">
                <div class="header-top pt-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-7  col-lg-7  col-md-7  col-sm-12 col-12 d-flex align-items-center">
                                <div class="header-top-left d-none d-md-block">
                                    <ul class="d-flex align-items-center">
                                        <li>
                                            <a href="tel:+5511987654321"><span class="pr-2"><i
                                                        class="fa-solid fa-phone"></i></span>+55 (11) 98765-4321</a>
                                        </li>
                                        <li class="before-effect">
                                            <a href="mailto:contato@cassiasouzaadv.com.br"><span class="pr-2"><i
                                                        class="fa-regular fa-envelope"></i></span>contato@cassiasouzaadv.com.br</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-5  col-lg-5  col-md-5  col-sm-12 col-12">
                                <ul
                                    class="header-top-right d-flex align-items-center justify-content-md-end justify-content-center">

                                    <li>
                                        <div class="language-area">
                                            <select name="language-picker-select" id="language-picker-select">
                                                <option value="PT-BR" selected>PT-BR</option>
                                                <option value="ENG">ENG</option>
                                            </select>
                                        </div>
                                    </li>

                                    <li class="before-effect pl-0 ml-0">
                                        <div class="currency-area">
                                            <select class="form-select" id="currency" name="currency">
                                                <option value="BRL" selected>BRL </option>
                                                <option value="USD">USD</option>
                                                <option value="EUR">EUR</option>
                                            </select>
                                        </div>
                                    </li>

                                    <li class="ht-login before-effect">
                                        <a href="login.html">Login</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="header-sticky" class="header-bottom">
                    <div class="container">
                        <div class="row align-items-center justify-content-between position-relative">
                            <div class="col-xl-3 col-lg-2 col-md-3 col-sm-5 col-5 pr-0">
                                <div class="logo">
                                    <a href="/" class="d-block"><img src="images/logo/logo-roxo.png"
                                            alt="Cassia Souza Advocacia Tributária"></a>
                                </div>
                            </div>
                            <div
                                class="col-xl-9 col-lg-10 col-md-9 col-sm-7 col-7 pl-0 d-flex justify-content-end position-static">

                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul class="d-block">
                                            <li><a href="/">Home</a>
                                                <ul class="mega-menu mega-dropdown-menu white-bg ml-0">
                                                    <li><a href="/">Home</a></li>
                                                    <li><a href="index2">Home 2 (Se Tiver)</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="sobre">Sobre Nós</a></li>
                                            <li><a href="javascript:void(0);">Serviços</a>
                                                <ul class="mega-menu mega-dropdown-menu white-bg ml-0">
                                                    <li><a href="servicos">Nossos Serviços</a></li>
                                                    <li><a href="servicos-detalhes">Detalhes do Serviço</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="javascript:void(0);">Consultoria</a>
                                                <ul class="mega-menu mega-dropdown-menu white-bg ml-0">
                                                    <li><a href="agendamento">Agendar Consulta</a></li>
                                                    <li><a href="area-cliente">Área do Cliente</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="javascript:void(0);">Notícias</a>
                                                <ul class="mega-menu mega-dropdown-menu white-bg ml-0">
                                                    <li><a href="blog">Artigos e Notícias</a></li>
                                                    <li><a href="blog-details">Detalhes do Artigo</a></li>
                                                    <li><a href="blog-details2">Detalhes do Artigo 2 (Se Tiver)</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="contato">Contato</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="header-right d-flex align-items-center justify-content-end pl-25">

                                    <ul class="social-link header-social d-none d-md-inline-block">
                                        <li class="d-inline-block mr-10">
                                            <a class="facebook-color text-center d-inline-block transition-3"
                                                href="https://www.facebook.com/cassiasouzaadv" target="_blank"><i
                                                    class="fa-brands fa-facebook-f"></i></a>
                                        </li>
                                        <li class="d-inline-block mr-10">
                                            <a class="instagram-color text-center d-inline-block transition-3"
                                                href="https://www.instagram.com/cassiasouzaadv" target="_blank"><i
                                                    class="fa-brands fa-instagram"></i></a>
                                        </li>
                                        <li class="d-inline-block mr-10">
                                            <a class="twitter-color text-center d-inline-block transition-3"
                                                href="https://twitter.com/cassiasouzaadv" target="_blank"><i
                                                    class="fa-brands fa-x-twitter"></i></a>
                                        </li>
                                        <li class="d-inline-block mr-10">
                                            <a class="linked-in-color text-center d-inline-block transition-3"
                                                href="https://www.linkedin.com/in/cassiasouzaadv" target="_blank"><i
                                                    class="fa-brands fa-linkedin-in"></i></a>
                                        </li>
                                    </ul>
                                    <div class="d-block d-lg-none pl-20">
                                        <a class="mobile-menubar theme-color" href="javascript:void(0);"><i
                                                class="fa-solid fa-bars"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="side-mobile-menu white-bg pt-10 pb-30 pl-35 pr-30 pb-100">
        <div class="w-100">
            <div class="close-icon d-inline-block float-right clear-both mt-15 mb-10">
                <a href="javascript:void(0);"><span class="icon-clear theme-color"><i
                            class="fa fa-times"></i></span></a>
            </div>
        </div>

        <div class="side-menu-search header-search-content mt-70 pr-15">
            <form action="#" class="position-relative">
                <input class="w-100 rounded-0 pb-2" type="text" placeholder="Buscar...">
                <a class="position-absolute right-0 top-0 dark-black-color d-block" href="#"><i
                        class="fas fa-search"></i></a>
            </form>
        </div>

        <div class="mobile-menu mt-20 w-100"></div>


        <ul class="pt-45 clear-both">
            <li><a href="tel:+5511987654321" class="main-color mb-10 d-block"><span class="pr-2"><i
                            class="fa-solid fa-phone"></i></span>+55 (11) 98765-4321</a></li>
            <li><a href="mailto:contato@cassiasouzaadv.com.br" class="main-color mb-10 d-block"><span class="pr-2"><i
                            class="fa-regular fa-envelope"></i></span>contato@cassiasouzaadv.com.br</a></li>
        </ul>

        <ul class="social-link pt-10 clear-both">
            <li class="d-inline-block mr-10">
                <a class="facebook-color text-center d-inline-block transition-3"
                    href="https://www.facebook.com/cassiasouzaadv" target="_blank"><i class="fab fa-facebook-f"></i></a>
            </li>
            <li class="d-inline-block mr-10">
                <a class="twitter-color text-center d-inline-block transition-3"
                    href="https://twitter.com/cassiasouzaadv" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
            </li>
            <li class="d-inline-block mr-10">
                <a class="instagram-color text-center d-inline-block transition-3"
                    href="https://www.instagram.com/cassiasouzaadv" target="_blank"><i class="fab fa-instagram"></i></a>
            </li>
            <li class="d-inline-block mr-10">
                <a class="linked-in-color text-center d-inline-block transition-3"
                    href="https://www.linkedin.com/in/cassiasouzaadv" target="_blank"><i
                        class="fab fa-linkedin-in"></i></a>
            </li>
        </ul>
    </div>
    <div class="body-overlay"></div>
    <main class="over-hidden">
        {{ $slot }}
    </main>



    <footer>
        <div class="footer-area">
            <div style="background: #590854" class="footer-top primary-border-bottom pt-110 pb-75 mb-40">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3  col-md-4  col-sm-6 col-6">
                            <div class="footer-widget f-info pb-30">
                                <h6 class="text-capitalize text-white mb-22">Sobre Nós</h6>
                                <ul>
                                    <li>
                                        <a href="sobre" class="d-inline-block mb-2">Quem Somos</a>
                                    </li>
                                    <li>
                                        <a href="equipe" class="d-inline-block mb-2">Nossa Equipe</a>
                                    </li>
                                    <li>
                                        <a href="servicos" class="d-inline-block mb-2">Áreas de Atuação</a>
                                    </li>
                                    <li>
                                        <a href="blog" class="d-inline-block mb-2">Artigos e Notícias</a>
                                    </li>
                                    <li>
                                        <a href="contato" class="d-inline-block mb-2">Fale Conosco</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3  col-md-4  col-sm-6 col-6">
                            <div class="footer-widget f-info pb-30">
                                <h6 class="text-capitalize text-white mb-22">Serviços</h6>
                                <ul>
                                    <li>
                                        <a href="servicos-detalhes.html" class="d-inline-block mb-2">Planejamento
                                            Tributário</a>
                                    </li>
                                    <li>
                                        <a href="servicos-detalhes.html" class="d-inline-block mb-2">Contencioso
                                            Tributário</a>
                                    </li>
                                    <li>
                                        <a href="servicos-detalhes.html" class="d-inline-block mb-2">Consultoria
                                            Fiscal</a>
                                    </li>
                                    <li>
                                        <a href="servicos-detalhes.html" class="d-inline-block mb-2">Compliance
                                            Tributário</a>
                                    </li>
                                    <li>
                                        <a href="servicos-detalhes.html" class="d-inline-block mb-2">Recuperação de
                                            Créditos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-2  col-md-4  col-sm-6 col-6">
                            <div class="footer-widget f-info pb-30">
                                <h6 class="text-capitalize text-white mb-22">Links Rápidos</h6>
                                <ul>
                                    <li>
                                        <a href="area-cliente" class="d-inline-block mb-2">Área do Cliente</a>
                                    </li>
                                    <li>
                                        <a href="agendamento" class="d-inline-block mb-2">Agendar Consulta</a>
                                    </li>
                                    <li>
                                        <a href="termos-de-uso" class="d-inline-block mb-2">Termos de Uso</a>
                                    </li>
                                    <li>
                                        <a href="politica-de-privacidade" class="d-inline-block mb-2">Política de
                                            Privacidade</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4  col-md-12  col-sm-6 col-12">
                            <div class="footer-widget f-adress">
                                <h6 class="text-capitalize text-white mb-20">Endereço</h6>

                                <div class="footer-ad mb-2 d-flex">
                                    <span class="text-white pr-25 mt-1"><i class="fa-solid fa-location-dot"></i></span>
                                    <p class="mb-0">Rua da Advocacia, 123
                                        Centro, Mogi das Cruzes - SP</p>
                                </div>
                                <div class="footer-email mb-2 d-flex">
                                    <span class="text-white pr-25 mt-1"><i class="fas fa-phone-alt"></i></span>
                                    <p class="mb-0">
                                        <a class="text-color primary-hover d-inline-block" href="tel:+5511987654321">+55
                                            (11) 98765-4321
                                            (Celular)</a>
                                        <a class="text-color primary-hover d-inline-block" href="tel:+551123456789">+55
                                            (11) 2345-6789
                                            (Fixo)</a>
                                    </p>
                                </div>
                                <div class="footer-phone mb-15">
                                    <span class="text-white pr-25"><i class="far fa-envelope"></i></span>
                                    <a class="text-color primary-hover"
                                        href="mailto:contato@cassiasouzaadv.com.br">contato@cassiasouzaadv.com.br</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row justify-content-lg-between justify-content-center">
                        <div class="col-xl-6  col-lg-8  col-md-8  col-sm-12 col-12 pr-0">
                            <div class="footer-widget footer-logo pb-35 d-sm-flex align-items-center">
                                <div class="foot-logo mr-30 mb-3 mb-sm-0 text-center text-sm-left">
                                    <img src="images/logo/logo-acinzentado.png" alt="Cassia Souza Advocacia Tributária">
                                </div>
                                <div class="copyright-text">
                                    <p class="mb-0">Todos os direitos reservados
                                        <a href="https://www.etheme.studio/" class="c-theme primary-color f-600"
                                            target="_blank">eThemeStudio</a>
                                        © 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4  col-md-12 col-sm-12 col-12">
                            <div
                                class="footer-widget pb-35 d-flex align-items-center justify-content-lg-end justify-content-center">
                                <h6 class="text-white mr-30 mb-0">Siga-nos</h6>
                                <ul class="social-link">
                                    <li class="d-inline-block mr-10">
                                        <a class="text-white text-center d-inline-block transition-3"
                                            href="https://www.facebook.com/cassiasouzaadv" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li class="d-inline-block mr-10">
                                        <a class="text-white text-center d-inline-block transition-3"
                                            href="https://twitter.com/cassiasouzaadv" target="_blank"><i
                                                class="fa-brands fa-x-twitter"></i></a>
                                    </li>
                                    <li class="d-inline-block mr-10">
                                        <a class="text-white text-center d-inline-block transition-3"
                                            href="https://www.instagram.com/cassiasouzaadv" target="_blank"><i
                                                class="fab fa-instagram"></i></a>
                                    </li>
                                    <li class="d-inline-block mr-10">
                                        <a class="text-white text-center d-inline-block transition-3"
                                            href="https://www.linkedin.com/in/cassiasouzaadv" target="_blank"><i
                                                class="fab fa-linkedin-in"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div id="scroll" class="scroll-up">
        <div class="top text-center"><span class="white-bg theme-color d-block"><i
                    class="fa-solid fa-angles-up"></i></span></div>
    </div>
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/image-loaded.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/waypoint.js"></script>
    <script src="js/counterup-min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.meanmenu.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>