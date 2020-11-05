<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/pages-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:44:04 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Registro Usuario | MPT</title>
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
          
                body.loader-open {
            overflow: hidden;
        }
        </style>
          <!-- Vendor js -->
          <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/vendor.min.js"></script>
        <link href="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/slim-password/password.min.css" rel="stylesheet" />
<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/libs/slim-password/password.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <body class="authentication-page">
    <div class="loader_bg" style="display: none;">
        <div style="background-color: #000000ad;width: 100%;height: 100%;z-index: 9999999;position: fixed;top: 0;left: 0;display: flex;justify-content: center;align-items: center;">
            <div class="spinner-border m-1 text-warning" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
    </div>
        <div class="account-pages my-3">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-7">
                        <div class="card mt-4">
                            <div class="card-header text-center p-4 " style="background-color:  #1a2942;">
                            <img style="margin-left: -7%;" alt="" width="70%" height="100%" src="<?php echo MAIN_URL_PUBLIC; ?>assets/images/logos/logo_login.png">
                                <h5 class="text-white font-13 mb-0">Registro Usuario</h5>
                            </div>
                            <div class="card-body">
                                <form class="p-2" id="frmRegistro">
                                    <div class="row">
                                       <div class="col-md-12">
                                       <div class="form-group mb-3">
                                        <label for="emailaddress">Correo electrónico<span class="text-danger">*</span></label>
                                        <input style="color:#3f51b5;font-weight: 600;" class="form-control" type="email" name="emailaddress" id="emailaddress" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required="" >
                                        <div class="invalid-feedback" id="email_error"></div>
                                    </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                       <div class="form-group mb-3">
                                        <label for="txtNombres">Nombres<span class="text-danger">*</span></label>
                                        <input style="color:black;font-weight: 600;text-transform: uppercase;" class="form-control" type="text" name="nombres" id="txtNombres" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required="" >
                                        <div class="invalid-feedback" id="nombres_error"></div>
									</div>
                                       </div>
                                       <div class="col-md-6">
                                       <div class="form-group mb-3">
                                        <label for="txtApellidos">Apellidos<span class="text-danger">*</span></label>
                                        <input style="color:black;font-weight: 600;text-transform: uppercase;" class="form-control" type="text" name="apellidos" id="txtApellidos" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required="" >
                                        <div class="invalid-feedback" id="apellidos_error"></div>
                                    </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                       <div class="form-group mb-3">
                                        <label for="txtPassword">Contraseña<span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="pwd" id="txtPassword" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required="" >
                                        <div class="invalid-feedback" id="contraseña_error"></div>
									</div>
                                       </div>
                                       <div class="col-md-6">
                                       <div class="form-group mb-3">
                                        <label for="txtPasswordConfirmacion">Confirmación Contraseña<span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="pwd_confirm" id="txtPasswordConfirmacion" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required="" >
                                        <div class="invalid-feedback" id="contraseña_confirmacion_error"></div>
                                    </div>
                                       </div>
                                    </div>

                                  
									
									

                                    

									
                                   
                                    <div class="g-recaptcha" data-sitekey="6LfNjMkZAAAAABnHaoGnGqSaJO3DA49i89U7rXAa"></div><br>
                                    <div class="alert alert-danger  fade show" role="alert" id="divMsg" style="display: none;">   
                                      
                                         </div>
                                    <div class="form-group text-right mt-4 mb-4">
                                        <div class="col-12">
                                            <button id="btnRegistro" disabled class="btn btn-md btn-block btn-primary waves-effect waves-light" type="button">Registrarme</button>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group row mb-0">
                                        <div class="col-sm-12 text-center">
                                            <a href="<?php echo $this->config->base_url() .'Login' ?>">Ya tengo cuenta?</a>
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

       

        <!-- App js -->
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/app.min.js"></script>
        <script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/login/jsRegistro.js?v=<?php echo(rand()); ?>"></script>
    </body>


<!-- Mirrored from coderthemes.com/velonic/layouts/horizontal/pages-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 09 Aug 2020 19:44:04 GMT -->
</html>
<script type="text/javascript">


    $(document).ready(function () {
        REGISTRO.init();
    });

</script>