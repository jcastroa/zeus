<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/pages-recoverpw.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:44:04 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Restablecer Contraseña | Velonic - Responsive Bootstrap 4 Admin Dashboard</title>
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
                body.loader-open {
            overflow: hidden;
        }
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
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-header text-center p-4 " style="background-color: #1a2942;text-align: center;">
                            <img style="margin-left: -7%;" alt="" width="100%" height="100%" src="<?php echo MAIN_URL_PUBLIC; ?>assets/images/logos/logo_login.png">
                                <h5 class="text-white font-13 mb-0">Restablecer la contraseña</h5>
                            </div>
                            <div class="card-body">
                                <form  class="p-2" id="frmPwdReset">
                                    <div id="divForm">
                                        <p class=" text-center mb-4" style="color: black;">Ingrese su dirección de correo electrónico y le enviaremos un mensaje con las instrucciones para restablecer su contraseña. </p>
                                        <div class="form-group mb-4">
                                            <div class="input-group">
                                                <input class="form-control" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"  placeholder="Ingresa tu correo electrónico" name="emailaddress" id="emailaddress">
                                                <span class="input-group-append"> <button  type="button" class="btn btn-primary " id="btnEnviar">Enviar</button> </span>
                                                <div class="invalid-feedback" id="email_error"></div>
                                            </div>
                                    
                                        </div>
                                    </div>
                                    <div id="divMsj" class="alert alert-success2  fade show" role="alert" style="display: none;">      
                                            
                                        </div>
                                     <div class="row" id="lblInfo" style="text-align: center;display: none;">
                                     <div class="col-12 mb-2">
                                     * En caso el correo no llegue busque dentro de su buzón de "correo no deseado" y marquelo como un correo "No Spam".
                                     </div>
                                     </div>   
                                   <div class="row" style="text-align: center;">
                                       <div class="col-12">
                                       <a  href="<?php echo $this->config->base_url() .'Login' ?>" type="button"><u><h6>Volver al logueo</h6></u></a>
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
        </div>

        <!-- Vendor js -->
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/app.min.js"></script>
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/pwd_reset/jsPwdReset.js?v=<?php echo(rand()); ?>"></script>

        <!-- General js -->
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/global/jsGeneral.js"></script>
    </body>


<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/pages-recoverpw.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:44:04 GMT -->
</html>
<script type="text/javascript">


    $(document).ready(function () {
        PWDRESET.init();
    });

</script>