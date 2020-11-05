<div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Cambiar Mi Contraseña</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="<?php echo $this->config->base_url() . 'inicio'  ?>">Inicio</a></li>
                                        <li class="breadcrumb-item active">Cambiar Contraseña</li>
                                        </ol>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
            <div class="alert alert-danger  fade show" role="alert" id="divError" style="display: none;">                                           
                                           <i class="mdi mdi-information mr-2"></i>
                                         
                                       </div>
                                     <form id="frmChangePassword">
                                            <div class="form-group">
                                                <label for="txtPasswordActual">Contraseña Actual</label>
                                                <input type="password" class="form-control" id="txtPasswordActual" name="txtPasswordActual" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                                                <div class="invalid-feedback" id="pwd_actual_error"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtPassword">Nueva Contraseña</label>
                                                <input type="password" class="form-control" id="txtPassword" name="txtPassword" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                                                <div class="invalid-feedback" id="pwd_nuevo_error"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtConfirmPassword">Confirmar Nueva Contraseña</label>
                                                <input type="password" class="form-control" id="txtConfirmPassword" name="txtConfirmPassword" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" >
                                                <div class="invalid-feedback" id="pwd_confirmar_error"></div>
                                            </div>
                                        </form>
                                            <button  class="btn btn-success" id="btnGuardarPassword" disabled>Guardar</button>

            </div>
        </div>
    </div>
    <!-- end col -->


</div>                        

<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/password/jsPassword.js?v=<?php echo(rand()); ?>"></script>
<script type="text/javascript">


    $(document).ready(function () {
        PASSWORD.init();
    });

</script>
                      
  