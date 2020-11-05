<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:41:46 GMT -->

<head>
    <meta charset="utf-8" />
    <title>Pagos MPT</title>
    <meta content="<?php echo $csrf;  ?>" name="csrf-token" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo MAIN_URL_PUBLIC; ?>assets/images/favicon.ico">

    <!-- Plugins css-->
    <link href="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?php echo MAIN_URL_PUBLIC; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="<?php echo MAIN_URL_PUBLIC; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo MAIN_URL_PUBLIC; ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

    <!-- Vendor js -->
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/vendor.min.js"></script>

    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/moment/moment.min.js"></script>
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Chat app -->
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/pages/jquery.chat.js"></script>

    <!-- Todo app -->
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/pages/jquery.todo.js"></script>
    <style>
        body.loader-open {
            overflow: hidden;
        }

       
    </style>

 <!-- select2 -->
 <link href="<?php echo MAIN_URL_PUBLIC; ?>assets/css/select2.min.css" rel="stylesheet" />

<!-- select2-bootstrap4-theme -->
<link href="<?php echo MAIN_URL_PUBLIC; ?>assets/css/select2-bootstrap4.css" rel="stylesheet"> <!-- for live demo page -->

<link href="https://cdn.jsdelivr.net/npm/smartwizard@4.4.1/dist/css/smart_wizard.min.css" rel="stylesheet" type="text/css" />
  <link href="https://www.munitrujillo.gob.pe/portal/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/smartwizard@4.4.1/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>

<!-- select2 -->
<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/select2/select2.min.js"></script>


<link href="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">

<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>


<link href="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/slim-password/password.min.css" rel="stylesheet" />
<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/slim-password/password.min.js"></script>



<script type="text/javascript" src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/clipboard/clipboard.js"></script>

</head>

<body data-layout="horizontal">
    <div class="loader_bg" style="display: none;">
        <div style="background-color: #000000ad;width: 100%;height: 100%;z-index: 9999999;position: fixed;top: 0;left: 0;display: flex;justify-content: center;align-items: center;">
            <div class="spinner-border m-1 text-warning" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
    </div>


    <!-- Begin page -->
    <div id="wrapper">

        <!-- Navigation Bar-->
        <header id="topnav">
            <!-- Topbar Start -->
            <div class="navbar-custom">
                <div class="container-fluid">
                    <ul class="list-unstyled topnav-menu float-right mb-0">

                        <li class="dropdown notification-list">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle nav-link">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>



                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?php echo MAIN_URL_PUBLIC; ?>assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                                <span class="pro-user-name ml-1">
                                    <?php echo $names_user  ?> <i class="mdi mdi-chevron-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Bienvenido !</h6>
                                </div>


                                <!-- item-->
                                <a href="<?php echo $this->config->base_url() . 'Password';  ?>" class="dropdown-item notify-item">
                                    <i class="mdi mdi-lock-outline"></i>
                                    <span>Cambiar contraseña</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="<?php echo $this->config->base_url() . 'Login/logOut?token=' . $csrf;  ?>" class="dropdown-item notify-item" id="btnLogout">
                                    <i class="mdi mdi-logout-variant"></i>
                                    <span>Cerrar Sessión</span>
                                </a>

                            </div>
                        </li>



                    </ul>

                    <!-- LOGO -->
                    <div class="logo-box">
                        <a href="index.html" class="logo text-center logo-dark">
                            <span class="logo-lg">
                                <img src="<?php echo MAIN_URL_PUBLIC; ?>assets/images/logo-dark.png" alt="" height="16">
                                <!-- <span class="logo-lg-text-dark">Velonic</span> -->
                            </span>
                            <span class="logo-sm">
                                <!-- <span class="logo-lg-text-dark">V</span> -->
                                <img src="<?php echo MAIN_URL_PUBLIC; ?>assets/images/logo-sm.png" alt="" height="22">
                            </span>
                        </a>

                        <a href="index.html" class="logo text-center logo-light">
                            <span class="logo-lg">
                                <img src="<?php echo MAIN_URL_PUBLIC; ?>assets/images/logo-sm.png" alt="" height="40">
                                 <span class="logo-lg-text-light" style="font-size: 14px;">Pagos Mpt</span> 
                            </span>
                            <span class="logo-sm">
                            <img src="<?php echo MAIN_URL_PUBLIC; ?>assets/images/logo-sm.png" alt="" height="40">
                                 <span class="logo-lg-text-light" style="font-size: 14px;">Pagos Mpt</span> 
                               
                            </span>
                        </a>
                    </div>
                    <!-- LOGO -->

                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- end Topbar -->

            <div class="topbar-menu">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">


                            <li class="has-submenu">
                                <a href="#"> <i class="ion-ios-apps"></i> Trámites </a>
                                <ul class="submenu in">
                                    <li><a href="<?php echo $this->config->base_url() . 'PagoD'  ?>">Pago Derecho Trámite</a></li>
                                    <li><a href="<?php echo $this->config->base_url() . 'misderechostramites'  ?>">Mis Derechos Trámites</a></li>

                                </ul>
                            </li>

                            <li class="has-submenu">
                                <a href="<?php echo $this->config->base_url() . 'mispagos'  ?>"> <i class="mdi mdi-shopping"></i> Mis Pagos </a>

                            </li>

                        </ul>
                        <!-- End navigation menu -->

                        <div class="clearfix"></div>
                    </div>
                    <!-- end #navigation -->
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">



                    <?php echo $contents; ?>


                </div>
                <!-- end container-fluid -->

            </div>
            <!-- end content -->



            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            Copyright &copy; 2020 | Powered by GS-MPT
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->







    <!-- Sparkline charts -->
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- Dashboard init JS -->
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/pages/dashboard.init.js"></script>

    <!-- App js -->
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/app.min.js"></script>
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/home/jsHome.js?v=<?php echo (rand()); ?>"></script>

    <!-- General js -->
    <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/global/jsGeneral.js?v=<?php echo (rand()); ?>"></script>

</body>

<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:42:30 GMT -->

</html>
<script type="text/javascript">
    $(document).ready(function() {
        INIT.init();
    });
</script>