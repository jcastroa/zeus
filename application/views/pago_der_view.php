<script src="https://integracion.alignetsac.com/VPOS2/js/modalcomercio.js"></script>
<div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Pago Trámite</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                          <li class="breadcrumb-item"><a href="<?php  echo $this->config->base_url().'inicio'  ?>">Inicio</a></li>
                                            <li class="breadcrumb-item active">Pago Derecho Trámite</li>
                                        </ol>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                  
                                        <h4 class="header-title mb-4">Procedimiento</h4>
                                        <form id="frmProcedimiento">
                                        <div class="form-group mb-3">
                                           
                                        <select class="form-control" data-placeholder="Choose one thing" data-allow-clear="0" name="cbo_procedimiento" id="cbo_procedimiento">

                                        </select>
                                        </form>
                                        <div class="invalid-feedback" id="procedimiento_error"></div>
                                    </div>
                                        <div class="card mb-4 box-shadow" style="background-color: #e1e9f4;">
                    <div class="card-body">
                        <h1><b>S/<span id="spMonto"></span>.<span id="spDecimal">00</span> </b><small class="text-muted">/ soles</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li style="font-size: 20px;font-weight: 600;"><span id="spProNom"></span></li>
                            
                           
                        </ul> 
                        <div id="frmPago">

                        </div>
                       
                    </div>
                </div>
                                       
                                    </div>
                                </div>
                            </div>

                          
                        </div>
             
    

<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/pago/jsPago.js?v=<?php echo(rand()); ?>"></script>
<script type="text/javascript">


    $(document).ready(function () {
        PAGO.init();
    });

</script>