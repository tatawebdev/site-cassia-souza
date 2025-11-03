<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $title ?? 'Cassia Souza Advocacia Tributária' }}</title>
    <!-- /SEO Ultimate -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta charset="utf-8">
        <link rel="icon" type="image/png" href="/assets/favicon.png">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Latest compiled and minified CSS -->
    <link href="/assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/js/bootstrap.min.js">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- StyleSheet link CSS -->
    <link href="/assets/css/style.css?v2" rel="stylesheet" type="text/css">
    <link href="/assets/css/responsive.css?v2" rel="stylesheet" type="text/css">
    <link href="/assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/owl.theme.default.min.css" rel="stylesheet" type="text/css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">


</head>

<body>
    <!-- Back to top button -->
    <a class="button-flutuante"></a>

    {{ $slot }}

    <x-link-whatsapp id="btn_wpp" title="Agende agora mesmo uma consulta via Whatsapp" class="float"
        style="position: fixed; width: 60px; height: 60px; bottom: 40px; right: 40px; background-color: #25d366; color: #fff; border-radius: 50px; text-align: center; font-size: 30px; box-shadow: 2px 2px 3px #999; z-index: 100;display: flex;justify-content: center;align-items: center;">
        <i class="fab fa-whatsapp my-float" style="color:#fefefe;"></i>
    </x-link-whatsapp>

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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Listener for Livewire 3 dispatch('swal', payload)
            window.addEventListener('swal', event => {
                let detail = event.detail;
                // Livewire 3 often wraps params in an array: [payload]
                if (Array.isArray(detail) && detail.length) detail = detail[0];
                detail = detail || {};

                Swal.fire({
                    icon: detail.type || 'success',
                    title: detail.title || '',
                    text: detail.text || '',
                    showConfirmButton: detail.showConfirmButton !== false,
                    timer: detail.timer || undefined,
                });
            });
        });

    </script>
</body>

</html>