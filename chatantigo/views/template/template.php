<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Cassia Souza Advocacia - Bootstrap 5 Admin Template &amp; UI Framework</title>

    <meta name="description" content="Cassia Souza Advocacia - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Cassia Souza Advocacia - Bootstrap 5 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="Cassia Souza Advocacia">
    <meta property="og:description" content="Cassia Souza Advocacia - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="/assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Dashmix framework -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="/assets/alertifyjs/alertify.css" />

    <link rel="stylesheet" id="css-main" href="/assets/css/dashmix.min.css">
    <style>
        /* Estilizando a mensagem de erro */
        .ajs-message.ajs-error {
            background-color: #f44336;
            /* Cor de fundo vermelha para erro */
            color: white;
            /* Cor do texto */
            border: 1px solid #d32f2f;
            /* Borda vermelha mais escura */
            font-size: 16px;
            /* Tamanho da fonte */
            border-radius: 5px;
            /* Bordas arredondadas */
            padding: 15px;
            /* Espaçamento interno */
            position: relative;
            /* Para posicionar elementos internos */
            margin: 10px 0;
            /* Margem superior e inferior */
        }

        /* Estilizando a mensagem visível */
        .ajs-message.ajs-visible {
            opacity: 1;
            /* Garantindo que a mensagem esteja visível */
            transition: opacity 0.3s ease;
            /* Efeito suave para transição */
        }

        /* Adicionando um botão de fechar (se aplicável) */
        .ajs-message .ajs-close {
            color: white;
            /* Cor do botão de fechar */
            position: absolute;
            /* Posicionando o botão no canto superior direito */
            top: 10px;
            /* Distância do topo */
            right: 10px;
            /* Distância da direita */
            cursor: pointer;
            /* Mão ao passar o mouse */
        }

        /* Efeito ao passar o mouse no botão de fechar */
        .ajs-message .ajs-close:hover {
            color: #ffeb3b;
            /* Cor ao passar o mouse */
        }
    </style>
</head>

<body>
    <!-- Page Container -->
    <!--
      Available classes for #page-container:

      GENERIC

        'remember-theme'                            Remembers active color theme and dark mode between pages using localStorage when set through
                                                    - Theme helper buttons [data-toggle="theme"],
                                                    - Layout helper buttons [data-toggle="layout" data-action="dark_mode_[on/off/toggle]"]
                                                    - ..and/or Dashmix.layout('dark_mode_[on/off/toggle]')

      SIDEBAR & SIDE OVERLAY

        'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
        'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
        'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
        'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
        'sidebar-dark'                              Dark themed sidebar

        'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
        'side-overlay-o'                            Visible Side Overlay by default

        'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

        'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

      HEADER

        ''                                          Static Header if no class is added
        'page-header-fixed'                         Fixed Header


      FOOTER

        ''                                          Static Footer if no class is added
        'page-footer-fixed'                         Fixed Footer (please have in mind that the footer has a specific height when is fixed)

      HEADER STYLE

        ''                                          Classic Header style if no class is added
        'page-header-dark'                          Dark themed Header
        'page-header-glass'                         Light themed Header with transparency by default
                                                    (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
        'page-header-glass page-header-dark'         Dark themed Header with transparency by default
                                                    (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

      MAIN CONTENT LAYOUT

        ''                                          Full width Main Content if no class is added
        'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
        'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)

      DARK MODE

        'sidebar-dark page-header-dark dark-mode'   Enable dark mode (light sidebar/header is not supported with dark mode)
    -->
    <div id="page-container" class="page-header-fixed page-header-dark main-content-boxed">

        <!-- Header -->
        <header id="page-header">
            <!-- Header Content -->
            <div class="content-header">
                <!-- Left Section -->
                <div class="d-flex align-items-center">
                    <!-- Logo -->
                    <a class="fw-semibold text-dual tracking-wide" href="index.html">
                        Cassia Souza Advocacia
                    </a>
                    <!-- END Logo -->
                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div>
                    <!-- Open Search Section -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-alt-secondary ms-2" data-toggle="layout" data-action="header_search_on">
                        <i class="fa fa-search"></i>
                    </button>
                    <!-- END Open Search Section -->

                    <!-- User Dropdown -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-circle"></i>
                            <i class="fa fa-angle-down opacity-50 ms-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
                            <div class="rounded-top fw-semibold text-white bg-image" style="background-image: url('assets/media/photos/photo20.jpg');">
                                <div class="p-3 bg-black-50 rounded-top">
                                    <div class="d-flex align-items-center">
                                        <img class="img-avatar img-avatar48 img-avatar-thumb" src="/assets/media/avatars/avatar1.jpg" alt="">
                                        <div class="ms-3">
                                            <a class="text-white fw-semibold" href="javascript:void(0)">Admin</a>
                                            <div class="fs-sm text-white-75">admin@example.com</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:void(0)">
                                    <div>
                                        <i class="fa fa-fw fa-globe text-muted me-1"></i>
                                        Projects
                                    </div>
                                    <span class="badge rounded-pill bg-primary">3</span>
                                </a>
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:void(0)">
                                    <div>
                                        <i class="fa fa-fw fa-sync-alt text-muted me-1"></i>
                                        Servers
                                    </div>
                                    <span class="badge rounded-pill bg-primary">3</span>
                                </a>
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:void(0)">
                                    <div>
                                        <i class="fa fa-fw fa-users text-muted me-1"></i>
                                        Customers
                                    </div>
                                    <span class="badge rounded-pill bg-primary">3</span>
                                </a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-user-circle text-muted me-1"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)">
                                    <i class="fab fa-fw fa-paypal text-muted me-1"></i>
                                    Billing
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-wrench text-muted me-1"></i>
                                    Preferences
                                </a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item d-flex align-items-center mb-0" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-sign-out-alt text-danger me-1"></i>
                                    Log Out
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- END User Dropdown -->
                </div>
                <!-- END Right Section -->
            </div>
            <!-- END Header Content -->

            <!-- Header Search -->
            <div id="page-header-search" class="overlay-header bg-sidebar-dark">
                <div class="content-header">
                    <form class="w-100" method="POST">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search your projects.." id="page-header-search-input" name="page-header-search-input">
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <button type="button" class="btn btn-alt-danger" data-toggle="layout" data-action="header_search_off">
                                <i class="fa fa-fw fa-times-circle"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Header Search -->

            <!-- Header Loader -->
            <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
            <div id="page-header-loader" class="overlay-header bg-sidebar-dark">
                <div class="content-header">
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-2x fa-spinner fa-spin text-primary"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container">
            <!-- Navigation -->
            <div class="bg-sidebar-dark">
                <div class="content">
                    <!-- Toggle Main Navigation -->
                    <div class="d-lg-none push">
                        <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
                        <button type="button" class="btn w-100 btn-primary d-flex justify-content-between align-items-center" data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
                            Menu
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <!-- END Toggle Main Navigation -->

                    <!-- Main Navigation -->
                    <!-- Main Navigation -->
                    <div id="main-navigation" class="d-none d-lg-block push">
                        <ul class="nav-main nav-main-horizontal nav-main-hover nav-main-dark">
                            <li class="nav-main-item">
                                <a class="nav-main-link active" href="/">
                                    <i class="nav-main-link-icon fa fa-rocket"></i>
                                    <span class="nav-main-link-name">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="/flows">
                                    <i class="nav-main-link-icon fa fa-cogs"></i>
                                    <span class="nav-main-link-name">Configurar Fluxo</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="/user-settings">
                                    <i class="nav-main-link-icon fa fa-users"></i>
                                    <span class="nav-main-link-name">Configurações de Usuário</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" target="_blank" href="/chat">
                                    <i class="nav-main-link-icon fa fa-comments"></i>
                                    <span class="nav-main-link-name">Mensagens</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="/analytics">
                                    <i class="nav-main-link-icon fa fa-chart-bar"></i>
                                    <span class="nav-main-link-name">Análises</span>
                                </a>
                            </li>
                            <li class="nav-main-item ms-lg-auto">
                                <a class="nav-main-link" href="/help">
                                    <i class="nav-main-link-icon fa fa-question-circle"></i>
                                    <span class="nav-main-link-name">Ajuda</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END Main Navigation -->

                    <!-- END Main Navigation -->
                </div>
            </div>
            <!-- END Navigation -->

            <!-- Page Content -->
            <div class="content">
                <!-- Your Block -->


                <?= $MyViewContainer ?>



                <!-- END Your Block -->
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->

        <!-- Footer -->
        <!-- <footer id="page-footer" class="bg-body-light">
            <div class="content py-0">
                <div class="row fs-sm">
                    <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-end">
                        Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold" href="https://pixelcave.com" target="_blank">pixelcave</a>
                    </div>
                    <div class="col-sm-6 order-sm-1 text-center text-sm-start">
                        <a class="fw-semibold" href="https://pixelcave.com/products/dashmix" target="_blank">Dashmix 5.9</a> &copy; <span data-toggle="year-copy"></span>
                    </div>
                </div>
            </div>
        </footer> -->
        <!-- END Footer -->
    </div>
    <!-- END Page Container -->

    <!--
      Dashmix JS

      Core libraries and functionality
      webpack is putting everything together at assets/_js/main/app.js
    -->
    <script src="/assets/js/dashmix.app.min.js"></script>
    <script src="/assets/alertifyjs/alertify.js"></script>

</body>

</html>