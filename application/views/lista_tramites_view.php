<div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Mis Derechos Trámites</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                          <li class="breadcrumb-item"><a href="<?php  echo $this->config->base_url().'inicio'  ?>">Inicio</a></li>
                                            <li class="breadcrumb-item active">Mis Derechos Trámites</li>
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


                <form class="form-horizontal">
                    <label for="exampleInputEmail1">Fechas:</label>        
                    <div class="form-group row mb-0">
                                                  
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Elige un rango..." id="txtFecha" >
                                                            <div class="input-group-append">
                                                                <button class="btn btn-success waves-effect waves-light" type="button" id="btnFiltrar"><i class="fas fa-search"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                    </form>
<br>
                    <div class="row">
                        <div class="col-12">
                        <table id="tblDerTramites" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead class="thead-light">
                                                    <tr>
                                                     
                                                        <th>N° Derecho Trámite</th>
                                                        <th>Procedimiento</th>
                                                        <th>Fecha</th>
                                                        <th>Estado</th>
                                                        <th style="text-align: center;">Copiar N°Trámite</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                   
                                                </tbody>
                                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- end col -->


</div>                        

<script src="<?php echo MAIN_URL_PUBLIC; ?>assets/js/tramite/jsTramite.js?v=<?php echo(rand()); ?>"></script>
<script type="text/javascript">


    $(document).ready(function () {
        TRAMITE.init();
    });

</script>