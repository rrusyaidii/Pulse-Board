<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="<?= base_url() ?>/assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.png" type="image/x-icon">
    <title><?= $title ?></title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <!-- css -->
    <?= $this->include('layout/css') ?>
</head>

<body onload="startTime()">
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- loader ends-->

    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper"></div>
<div class="container-fluid p-0">
      <div class="row m-0">
        <div class="col-12 p-0">    
          <div class="login-card">
            <div>
              <div class="login-main"> 

                <!-- <form  class="theme-form"> -->
                <form method="post" action="<?= base_url('/auth/attemptLogin') ?>" class="theme-form">
                  <h4>Sign in to account</h4>
                  <div class="pt-3 form-group">
                    <label class="col-form-label">Email Address</label>
                    <input class="form-control" type="email" name="email" required placeholder="test@gmail.com">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                      <input class="form-control" type="password" name="password" required placeholder="*********">
                      <div class="show-hide"><span class="show"></span></div>
                    </div>
                  </div>
                  <div class="form-group mb-0">
                    <div class="checkbox p-0">
                      <input id="checkbox1" type="checkbox">
                    </div>
                    <a href="#" id="forgot-password-link" class="link">Forgot password?</a>
                    <div class="text-end mt-3">
                      <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                    </div>
                  </div>
              </form>

              </div>
            </div>
          </div>
        </div>
      </div>

      


    <!-- Script-->
    <?= $this->include('layout/script') ?>
    <script src="<?=base_url()?>/assets/js/sweet-alert/sweetalert.min.js"></script>
    <script src="<?=base_url()?>/assets/js/sweet-alert/app.js"></script>
    <script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

    <script>
      document.getElementById("forgot-password-link").addEventListener("click", function (e) {
        e.preventDefault(); // prevent actual link behavior
        swal({
          title: "Forgot Password?",
          text: "Please contact support for password reset.",
          icon: "info",
          button: "Okay",
        });
      });
    </script>

    <?php if (session()->getFlashdata('error')): ?>
      <script>
        swal({
          title: "Login Failed",
          text: "<?= session('error') ?>",
          icon: "error",
          button: "Try Again",
        });
      </script>
    <?php endif; ?>



</body>
</html>