<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= base_url() ?>/assets/images/logo/logodebug.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/logo/logodebug.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/themify.css"></link>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/icofont.css"></link>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/font-awesome.css" ></link>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/jkanban.css">

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
    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        <!-- Header Start -->
        <?= $this->include('layout/header') ?>
        <!--Header End  -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <!-- Page Sidebar Start-->
            <?= $this->include('layout/sidebar') ?>
            <!-- Page Sidebar Ends-->

            <div class="page-body">
                <!-- Main Content Start -->
                <?= $this->renderSection('main-content') ?>
                <!-- Main Content End -->
            </div>

            <!-- Footer -->
            <?= $this->include('layout/footer') ?>
        </div>
    </div>

    <!-- Script-->
    <?= $this->include('layout/script') ?>
</body>

</html>