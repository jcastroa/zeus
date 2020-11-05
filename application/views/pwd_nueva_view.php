<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/pages-recoverpw.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:44:04 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Restablecer su contraseña | MPT</title>
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

        <!-- Vendor js -->
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/vendor.min.js"></script>
        
<link href="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/slim-password/password.min.css" rel="stylesheet" />
<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/slim-password/password.min.js"></script>

        <style>
        body.loader-open {
            overflow: hidden;
        }

       
.error-template {padding: 40px 15px;text-align: center;}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }


    </style>

    
    </head>

    <body class="authentication-page">
    <div class="loader_bg" style="display: none;">
        <div style="background-color: #000000ad;width: 100%;height: 100%;z-index: 9999999;position: fixed;top: 0;left: 0;display: flex;justify-content: center;align-items: center;">
            <div class="spinner-border m-1 text-warning" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
    </div>
        <div class="account-pages my-5">

   <?php 
      

       if(empty($_GET['selector']) || empty($_GET['validator'])){

      
   
   
   ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Oops!</h1>
                <h2>
                    404 Not Found</h2>
                <div class="error-details">
                    Sorry, an error has occured, Requested page not found!
                </div>
                <div class="error-actions">
                    <a href="http://www.jquery2dotnet.com" class="btn btn-primary btn-lg"><span class="fas fa-home"></span>&nbsp;&nbsp;
                        Ir al Inicio </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 

       }else{
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];
        if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){

?>





            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-header text-center p-4 " style="background-color: #3b5998;">
                                <h4 class="text-white mb-0 mt-0">Velonic</h4>
                                <h5 class="text-white font-13 mb-0">Restablecer su contraseña</h5>
                            </div>
                            <div class="card-body">
                                <form  class="p-2" id="frmPwdNew">
                                <div id="divMsj" class="alert alert-danger  fade show" role="alert" style="display: none;"></div>
                                <div class="form-group mb-3">
                                        <label for="emailaddress">Nueva contraseña<span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="txtPassword" name="txtPassword" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                                                <div class="invalid-feedback" id="pwd_nuevo_error"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Confirmar nueva contraseña<span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="txtConfirmPassword" name="txtConfirmPassword" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" >
                                        <div class="invalid-feedback" id="pwd_confirmar_error"></div>
                                    </div>
                                    <input type="hidden" name="selector" value="<?php  echo $selector  ?>">
                                    <input type="hidden" name="validator" value="<?php  echo $validator  ?>">
                                    <div class="form-group row text-center mt-4 mb-4">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-md btn-block btn-facebook waves-effect waves-light" id="btnGuardar" disabled>Actualizar contraseña</button>
                                        </div>
                                    </div>

                                    
                                </form>

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

<?php 
        }
        else{ ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Oops!</h1>
                <h2>
                    404 Not Found</h2>
                <div class="error-details">
                    Sorry, an error has occured, Requested page not found!
                </div>
                <div class="error-actions">
                    <a href="http://www.jquery2dotnet.com" class="btn btn-primary btn-lg"><span class="fas fa-home"></span>&nbsp;&nbsp;
                        Ir al Inicio </a>
                </div>
            </div>
        </div>
    </div>
</div>
        <?php
        }
       }

?>


        </div>


        <!-- App js -->
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/app.min.js"></script>
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/pwd_reset/jsPwdNew.js?v=<?php echo(rand()); ?>"></script>

<!-- General js -->
<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/global/jsGeneral.js"></script>
       
    </body>


<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/pages-recoverpw.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:44:04 GMT -->
</html>
<script type="text/javascript">


    $(document).ready(function () {
        PWDNEW.init();
    });

</script>