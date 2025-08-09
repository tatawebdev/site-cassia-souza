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

{{ $slot }}


<!-- Footer -->
<section class="footer-con position-relative" id="footer">
    <div class="container position-relative">
        <div class="row">
            <div class="col-12">
                <div class="upper_portion" data-aos="fade-up">
                    <div class="heading">
                        <h6 class="text-white">Subscription</h6>
                        <h3 class="text-white mb-0">Subscribe to our <span
                                class="span_borderbootom">newsletter</span></h3>
                    </div>
                    <form action="javascript:;">
                        <div class="form-group position-relative mb-0">
                            <input type="text" class="form_style" placeholder="Your email address" name="email">
                            <button>Subscribe<i class="fa-solid fa-arrow-right"></i></button>
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
                            <figure class="mb-0"><img src="./assets/images/logo-acinzentado.png" alt="image"></figure>
                        </a>
                        <p class="text-size-14">Nemo enim ipsam voluptatem quia voluptas sit asperna tur aut odit
                            aut fugit, sed quia conseuntur magni dolor es eos rui ratione...</p>
                        <ul class="list-unstyled mb-0 social-icons">
                            <li><a href="https://www.facebook.com/login/" class="text-decoration-none"><i class="fa-brands fa-facebook-f social-networks"></i></a></li>
                            <li><a href="https://twitter.com/i/flow/login" class="text-decoration-none"><i class="fa-brands fa-x-twitter social-networks"></i></a></li>
                            <li><a href="https://www.linkedin.com/login" class="text-decoration-none"><i class="fa-brands fa-linkedin social-networks"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-2 col-md-4 col-sm-4 col-6">
                    <div class="links">
                        <h4 class="heading">Useful Links</h4>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/" class=" text-size-14 text text-decoration-none">Home</a></li>
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/about" class=" text-size-14 text text-decoration-none">About</a></li>
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/practice-area" class=" text-size-14 text text-decoration-none">Practice Areas</a></li>
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/case-studies" class=" text-size-14 text text-decoration-none">Cases</a></li>
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/blog" class=" text-size-14 text text-decoration-none">Blog</a></li>
                            <li><i class="fa-solid fa-arrow-right"></i><a href="/contact" class=" text-size-14 text text-decoration-none">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                    <div class="timing">
                        <h4 class="heading">Office Hours</h4>
                        <ul class="list-unstyled mb-0">
                            <li><p>Monday – Saturday</p></li>
                            <li><span>12:00 – 14:45</span></li>
                            <li><p>Sunday – Thursday</p></li>
                            <li><span>17.30 – 21.45</span></li>
                            <li><p>Friday – Saturday</p></li>
                            <li><span class="mb-0">13.00 – 19.45</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                    <div class="icon">
                        <h4 class="heading">Contact Us</h4>
                        <ul class="list-unstyled mb-0">
                            <li class="text">
                                <i class="fa-solid fa-phone"></i>
                                <a href="tel:+568925896325" class="text-decoration-none">+5689 2589 6325</a>
                            </li>
                            <li class="text">
                                <i class="fa-solid fa-envelope"></i>
                                <a href="mailto:info@lawfinity.com"
                                    class="text-decoration-none">Info@lawfinity.com</a>
                            </li>
                            <li class="text">
                                <i class="fa-solid fa-location-dot"></i>
                                <p class="address mb-0">21 King Street Melbourne, 3000, Australia</p>
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
                <img src="./assets/images/footer-contactimage.png" alt="image" class="img-fluid">
            </figure>
        </div>
        <div class="body" style="display: none;">
            <form action="javascript:;">
                <div class="form-group mb-0">
                    <input type="text" class="form_style" placeholder="Name" name="name">
                </div>
                <div class="form-group mb-0">
                    <input type="email" class="form_style" placeholder="Email" name="emailid">
                </div>
                <div class="form-group mb-0">
                    <input type="tel" class="form_style" placeholder="Phone" name="phone">
                </div>
                <div class="form-group mb-0">
                    <textarea class="form_style" placeholder="Message" rows="3" name="msg"></textarea>
                </div>
                <button type="submit" class="submit_now text-decoration-none">Submit</button>
            </form>
        </div>
    </div>
    <figure class="footer-sideimage mb-0">
        <img src="./assets/images/footer-sideimage.png" alt="image" class="img-fluid">
    </figure>
    <div class="copyright">
        <p class="mb-0">Copyright © lawfinity.com, All Rights Reserved 2024</p>
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
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<script src="assets/js/carousel.js"></script>
<script src="assets/js/animation.js"></script>
<script src="assets/js/video-popup.js"></script>
<script src="assets/js/video.js"></script>
<script src="assets/js/back-to-top-button.js"></script>
<script src="assets/js/preloader.js"></script>
<script src="assets/js/popup-image.js"></script>
<script src="assets/js/contact-form.js"></script>
<script src="assets/js/contact-validate.js"></script>
<script src="assets/js/counter.js"></script>
</body>
</html>