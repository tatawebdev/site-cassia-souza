<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Three Column Sidebar | Lawfinity</title>
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
    <link href="/assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/js/bootstrap.min.js">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- StyleSheet link CSS -->
    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/responsive.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/blog.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/owl.theme.default.min.css" rel="stylesheet" type="text/css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
</head>

<body>
    <!-- Back to top button -->
    <a id="button"></a>

    <div class="sub_banner position-relative">
        <figure class="banner-rightimage image mb-0">
            <img src="/assets/images/banner-rightimage.png" alt="image" class="img-fluid">
        </figure>
        <figure class="banner-leftimage image mb-0">
            <img src="/assets/images/banner-leftimage.png" alt="image" class="img-fluid">
        </figure>
        <header class="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                    <a class="navbar-brand" href="index.html">
                        <figure class="logo mb-0"><img width="150px" src="/assets/images/logo-acinzentado.png" alt=""
                                class="img-fluid"></figure>
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
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sobre-nos">Sobre</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle dropdown-color navbar-text-color" href="#"
                                    id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"> Serviços </a>
                                <div class="dropdown-menu drop-down-content">
                                    <ul class="list-unstyled drop-down-pages">
                                        <li class="nav-item"><a class="dropdown-item nav-link"
                                                href="{{ route('servicos.consultoria.tributaria') }}">Consultoria
                                                Tributária</a></li>
                                        <li class="nav-item"><a class="dropdown-item nav-link"
                                                href="{{ route('servicos.defesa.administrativa') }}">Defesa
                                                Administrativa</a></li>
                                        <li class="nav-item"><a class="dropdown-item nav-link"
                                                href="{{ route('servicos.planejamento.tributario') }}">Planejamento
                                                Tributário</a></li>
                                        <li class="nav-item"><a class="dropdown-item nav-link"
                                                href="{{ route('servicos.recuperacao.creditos') }}">Recuperação de
                                                Créditos</a></li>
                                        <li class="nav-item"><a class="dropdown-item nav-link"
                                                href="{{ route('servicos.conformidade.tributaria') }}">Conformidade
                                                Tributária</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://blog.cassiasouzaadvocacia.com.br/">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contato">Contato</a>
                            </li>
                        </ul>
                        <div class="last_list">
                            <figure class="nav-phoneicon mb-0"><img class="img-fluid"
                                    src="/assets/images/nav-phoneicon.png" alt=""></figure>
                            <a class="text-decoration-none last_list_atag" href="tel:+568925896325">+5689 2589 6325</a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        @if (!empty($banner))
            <section class="sub_banner_con position-relative">
                <div class="container position-relative">
                    <div class="row">
                        <div class="col-12">
                            <div class="sub_banner_content" data-aos="fade-up">
                                <h1 class="text-white">{{ $banner['title'] }}</h1>
                                <p class="col-xl-7 col-lg-9 mx-auto text-white text-size-16">{{ $banner['descricao'] }}</p>
                                <div class="box">
                                    @foreach ($breadcrumbs as $index => $breadcrumb)
                                        @if ($index < count($breadcrumbs) - 1)
                                            <a href="{{ $breadcrumb['url'] }}" class="text-decoration-none">
                                                <span class="mb-0">{{ $breadcrumb['label'] }}</span>
                                            </a>
                                            <i class="arrow fa-solid fa-arrow-right"></i>
                                        @else
                                            <span class="mb-0 box_span">{{ $breadcrumb['label'] }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>

    {{  $slot }}



    <!-- Footer -->
    @include('footer')

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
</body>

</html>