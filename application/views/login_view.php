<!DOCTYPE html>
<html lang="en">


    
<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:44:04 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Login page | Velonic - Responsive Bootstrap 4 Admin Dashboard</title>
        <meta content="<?php echo $csrf;  ?>" name="csrf-token" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo MAIN_URL_PUBLIC; ?>assets/images/favicon.ico">

        <!-- App css -->
        <link href="<?php echo MAIN_URL_PUBLIC; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="<?php echo MAIN_URL_PUBLIC; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo MAIN_URL_PUBLIC; ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
        
        <style>
            .alert-success2 {
                    color: #31402f;
                    background-color: #b4d6ad;
                    border-color: #b4d6ad;
                }
               
        </style>
    </head>

    <body class="authentication-page">

   

        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-header p-4 " style="background-color: #1a2942;text-align: center;">
                            <img style="margin-left: -11%;" alt="" width="100%" height="100%" src="<?php echo MAIN_URL_PUBLIC; ?>assets/images/logos/logo_login.png">
                            </div>
                            <div class="card-body">
                            <?php 
                                 if(isset($_GET['newpwd'])){
                                     if($_GET['newpwd'] == 'pwdupdate' ){

                                  
                            ?>
                               <div class="alert alert-success2  fade show" role="alert" id="divSuccess" >   
                                           <i class="fas fa-check-circle mr-2"></i>Su contraseña ha sido restablecida correctamente.
                                       </div>

                                     <?php } 
                                    }
                                    ?>
                                               <?php 
                                 if(isset($_GET['activate'])){
                                     if($_GET['activate'] == 'email' ){

                                  
                            ?>
                               <div class="alert alert-success2  fade show" role="alert" id="divSuccess" >   
                                           <i class="fas fa-envelope mr-2"></i>Revisa tu correo electrónico para activar tu cuenta. 
                                       </div>

                                     <?php } 
                                    }
                                    ?>

<?php 
                                 if(isset($_GET['token'])){
                                     if($_GET['token'] == 'invalid' ){

                                  
                            ?>
                               <div class="alert alert-danger  fade show" role="alert" id="divSuccess" >   
                                           <i class="fas fa-times-circle mr-2"></i>Token inválido. 
                                       </div>

                                     <?php } 
                                    }
                                    ?>

                                    
<?php 
                                 if(isset($_GET['user'])){
                                     if($_GET['user'] == 'success' ){

                                  
                            ?>
                               <div class="alert alert-success2  fade show" role="alert" id="divSuccess" >   
                                           <i class="fas fa-check-circle mr-2"></i>Tu cuenta ha sido activada correctamente. 
                                       </div>

                                     <?php } 
                                    }
                                    ?>
                            


                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="divError" style="display: none;">
                                           
                                            <i class="mdi mdi-information mr-2"></i>
                                           
                                        </div>
                               <form id="frmLogin">

                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Correo electrónico<span class="text-danger">*</span></label>
                                        <input class="form-control" type="email" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" name="emailaddress" id="emailaddress" required="" >
                                        <div class="invalid-feedback" id="email_error"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Contraseña<span class="text-danger">*</span></label>
                                        <input class="form-control" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="password" required="" name="password" id="password" >
                                        <div class="invalid-feedback" id="password_error"></div>
                                    </div>
                                    <div class="form-group  row mb-4">
                                    <div class="col-12">
                                            <a href="<?php echo $this->config->base_url() .'pwd_reset' ?>" class="text-muted float-right">Olvidaste tu contraseña?</a>
                                    </div>
                                    </div>
                                    </form>
                                    <div class="form-group row text-center mt-4 mb-4">
                                        <div class="col-12">
                                            <button class="btn btn-md btn-block btn-primary waves-effect waves-light" id="btnLogin">Ingresar</button>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-sm-12 text-center">
                                            <p class="text-muted mb-0">No tienes cuenta? <a href="<?php echo $this->config->base_url() .'Registro' ?>" class="text-dark m-l-5"><b>Regístrate</b></a></p>
                                        </div>
                                    </div>
                               
                                    
                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <!-- end row -->

                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

            </div>
        </div>

        <!-- Vendor js -->
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/app.min.js"></script>
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/login/jsLogin.js?v=<?php echo(rand()); ?>"></script>

        <!-- General js -->
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/global/jsGeneral.js"></script>

    </body>


<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:44:04 GMT -->
</html>


<script type="text/javascript">


    $(document).ready(function () {
        INIT.init();
    });

</script>