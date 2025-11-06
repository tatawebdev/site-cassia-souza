<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title>Dashmix - Bootstrap 5 Admin Template &amp; UI Framework</title>

  <meta name="description" content="Dashmix - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
  <meta name="author" content="pixelcave">
  <meta name="robots" content="index, follow">

  <meta property="og:title" content="Dashmix - Bootstrap 5 Admin Template &amp; UI Framework">
  <meta property="og:site_name" content="Dashmix">
  <meta property="og:description" content="Dashmix - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
  <meta property="og:type" content="website">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
  <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
  <link rel="stylesheet" id="css-main" href="assets/css/dashmix.min.css">

</head>

<body>
  <div id="page-container">

    <!-- Main Container -->
    <main id="main-container">
      <!-- Page Content -->
      <div class="row g-0 justify-content-center bg-body-dark">
        <div class="hero-static col-sm-10 col-md-8 col-xl-6 d-flex align-items-center p-2 px-sm-0">
          <!-- Sign In Block -->
          <div class="block block-rounded block-transparent block-fx-pop w-100 mb-0 overflow-hidden bg-image" style="background-image: url('assets/media/photos/photo20@2x.jpg');">
            <div class="row g-0">
              <div class="col-md-6 order-md-1 bg-body-extra-light">
                <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                  <!-- Header -->
                  <div class="mb-2 text-center">
                    <a class="link-fx fw-bold fs-1" href="index.html">
                      <img src="https://cassiasouzaadvocacia.com.br/assets-all/images/logo/logo-azul.png" style="margin-bottom: 50px;" class="w-100" alt="">
                    </a>
                  </div>
                  <form class="js-validation-signin" action="/login" method="POST">
                    <div class="mb-4">
                      <input type="text" class="form-control form-control-alt" id="username" name="username" placeholder="Usuario">
                    </div>
                    <div class="mb-4">
                      <input type="password" class="form-control form-control-alt" id="password" name="password" placeholder="Senha">
                    </div>
                    <div class="mb-4">
                      <button type="submit" class="btn w-100 btn-hero btn-primary">
                        <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Login
                      </button>
                    </div>
                  </form>
                  <!-- END Sign In Form -->
                </div>
              </div>
              <div class="col-md-6 order-md-0 bg-primary-dark-op d-flex align-items-center">
                <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                  <div class="d-flex">

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END Sign In Block -->
        </div>
      </div>
      <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
  </div>
  <!-- END Page Container -->

  <!--
      Dashmix JS

      Core libraries and functionality
      webpack is putting everything together at assets/_js/main/app.js
    -->
  <script src="assets/js/dashmix.app.min.js"></script>

  <!-- jQuery (required for jQuery Validation plugin) -->
  <script src="assets/js/lib/jquery.min.js"></script>

  <!-- Page JS Plugins -->
  <script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>

  <!-- Page JS Code -->
  <script src="assets/js/pages/op_auth_signin.min.js"></script>
</body>

</html>