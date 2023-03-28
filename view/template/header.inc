<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="FBB" name="FBB sistema"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= HOME_URI . "assets/images/favicon.ico" ?>">

    <title>FBB - Sistema</title>

    <!-- App css -->
    <link href="<?= HOME_URI . "assets/css/bootstrap.min.css" ?>" rel="stylesheet" type="text/css">
    <link href="<?= HOME_URI . "assets/css/icons.min.css" ?>" rel="stylesheet" type="text/css">
    <link href="<?= HOME_URI . "assets/css/theme.min.css" ?>" rel="stylesheet" type="text/css">
    <link href="<?= HOME_URI . "assets/css/admin.css" ?>" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link href="<?= HOME_URI . "vendor/datatables/datatables.css" ?>" rel="Shortcut Icon">
    <link rel="stylesheet" type="text/css" href="<?= HOME_URI . "vendor/datatables/datatables.min.css" ?>"/>

    <!-- Others -->
    <link href="<?= HOME_URI . "vendor/chosen_v1.8.7/chosen.css" ?>" rel="stylesheet">
    <link href="<?= HOME_URI . "vendor/jquery-validation-1.16.0/jquery-validation.css" ?>" rel="stylesheet">
</head>
<body>

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex align-items-left">
                <button type="button" class="btn btn-sm mr-2 d-lg-none px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown d-inline-block ml-2">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                             src="<?= HOME_URI . 'assets/images/users/avatar-1.jpg'; ?>"
                             alt="Header Avatar">
                        <span class="d-none d-sm-inline-block ml-1"><?= saudacao($_SESSION["nm_login"]) ?>, <?= $_SESSION["nm_perfil"] ?></span>
                        <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                           href="<?= HOME_URI . 'logout.php' ?>">
                            <span>Sair</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <div class="navbar-brand-box">
                <a href="<?= HOME_URI . 'app/home/' ?>" class="logo">
                    <img src="<?= HOME_URI . 'assets/images/logo-light.png'; ?>"/>
                </a>
            </div>

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>

                    <?php
                        $perfilController = new PerfilController();
                        foreach ( $perfilController->getMenuByPerfil($_SESSION["id_perfil"]) as $strKey => $menu):
                    ?>
                    <li>
                        <a href="<?=$menu['url_menu']?>" class="waves-effect">
                            <i class="bx bx-aperture"></i><span><?= $menu['nm_menu'] ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>

                    <li>
                        <a href="<?= HOME_URI . 'logout.php' ?>" class="waves-effect">
                            <i class="bx bx-exit"></i><span>Sair</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
