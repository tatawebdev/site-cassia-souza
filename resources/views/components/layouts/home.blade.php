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
    <link href="assets/css/style.css?v1" rel="stylesheet" type="text/css">
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.theme.default.min.css" rel="stylesheet" type="text/css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
</head>

<body>
    <!-- Back to top button -->
    <a id="button"></a>

    {{ $slot }}

    <a id="btn_wpp" title="Agende agora mesmo uma consulta via Whatsapp"
        href="https://web.whatsapp.com/send/?phone=5511915201084&amp;text=Ol%C3%A1%2C%20Cassia%20Souza%20Advocacia%21%0A%0ATenho%20interesse%20em%20seus%20servi%C3%A7os%20advocat%C3%ADcios%20⚖️"
        class="float" target="_blank" rel="nofollow"
        style="position: fixed; width: 60px; height: 60px; bottom: 120px; right: 20px; background-color: #25d366; color: #fff; border-radius: 50px; text-align: center; font-size: 30px; box-shadow: 2px 2px 3px #999; z-index: 100;display: flex;justify-content: center;align-items: center;">
        <i class="fab fa-whatsapp my-float" style="color:#fefefe;"></i>
    </a>
    </a>

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
    <script src="/assets/js/contact-form.js"></script>
    <script src="/assets/js/contact-validate.js"></script>
    <script src="/assets/js/counter.js"></script>
</body>

</html>