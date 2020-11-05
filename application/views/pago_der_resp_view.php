
<div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Resumen Transacción</h4>
                                   
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-12">
                        
                                      
                                           
                                     
<?php 
if ($parametros[0] == '00' ) {
                       
    echo ' <div class="alert alert-icon alert-info alert-dismissible fade show" role="alert" style="background-color: #d4edda;border-color:#c3e6cb;"> <h6 style="color:#155724"><i class="ion ion-md-checkmark-circle"></i>&nbsp;&nbsp;Transacción aprobada!</h6></div>';
}

else if ($parametros[0] == '01' ) {
  
    echo ' <div class="alert alert-icon alert-info alert-dismissible fade show" role="alert" style="background-color: #f8d7da;border-color:#f5c6cb;"> <h6 style="color:#721c24"><i class="ion ion-md-close-circle"></i>&nbsp;&nbsp;Transacción denegada!</h6></div>';
}
else if ($parametros[0] == '05' ) {
  
    echo ' <div class="alert alert-icon alert-info alert-dismissible fade show" role="alert" style="background-color: #f8d7da;border-color:#f5c6cb;"> <h6 style="color:#721c24"><i class="ion ion-md-close-circle"></i>&nbsp;&nbsp;Transacción rechazada!</h6></div>';
}else{
    echo ' <div class="alert alert-icon alert-info alert-dismissible fade show" role="alert" style="background-color: #f8d7da;border-color:#f5c6cb;"> <h6 style="color:#721c24"><i class="ion ion-md-close-circle"></i>&nbsp;&nbsp;Error!</h6></div>';
}
                   
?>

                                     
                                    
                        </div>
                        </div>

                        <?php 
                           $idadquiriente = $parametros[7];
                           $idcomercio = $parametros[8];
                             $op = $parametros[1];
                             $monto =$parametros[3];
                             $moneda = $parametros[9];
                             $authorizationResult = $parametros[0];
                             $key='VrWsTZMmPAgUhQFm*897388977';
                            $fimra_cadena = $idadquiriente.$idcomercio.$op.$monto.$moneda. $authorizationResult.$key;
                            $signature = openssl_digest($fimra_cadena,'sha512');

                         if ($parametros[6] == $signature ||  $parametros[6] == "") {  
                             ?>
 <div class="row"> 
     <div class="col-12">
            <table class="table  table-striped text-left table-sm" style=" background-color: white;font-size: 15px;">            
            <tbody>
                <tr>
                    <td style="width:40%"><b>Operación</b></td>
                    <td style="width:60%"><?php echo $parametros[1] ?></td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td><?php echo $parametros[2] ?></td>
                </tr>
                <tr>
                    <td><b>Valor total</b></td>
                    <td>S/. <?php echo $parametros[3]/100; ?></td>
                </tr>
                <tr>
                    <td><b>Descripción</b></td>
                    <td><?php echo $parametros[5] ?></td>
                </tr>            
                <tr>
                    <td><b>Fecha Transacción</b></td>
                    <td><?php echo $parametros[4] ?></td>
                </tr>
            </tbody>
            </table>
      </div>
  </div>
                         <?php }else{?>

                            <h4>Transacción inválida. Los datos fueron alterados en el proceso de respuesta.</h4>
                         <?php }?>

<?php  if ($parametros[0] == '00' ) {  ?>
<div class="row">
    <div class="col-12">
    <a type="button"  href="<?php  echo $this->config->base_url().'misderechostramites'  ?>"  class="btn btn-success waves-effect width-md waves-light"><i class="fas fa-file-alt"></i>&nbsp;&nbsp;Ver Mi Derecho Trámite</a>&nbsp;&nbsp;
    <a  type="button"  href="<?php  echo $this->config->base_url().'inicio'  ?>"   class="btn btn-secondary waves-effect width-md waves-light"><i class="fas fa-arrow-circle-left"></i>&nbsp;&nbsp;Regresar al Inicio</a>
    </div>
</div>   

<?php } else { ?>

    <div class="row">
    <div class="col-12">   
    <a  type="button"  href="<?php  echo $this->config->base_url().'inicio'  ?>"   class="btn btn-secondary waves-effect width-md waves-light"><i class="fas fa-arrow-circle-left"></i>&nbsp;&nbsp;Regresar al Inicio</a>
    </div>
</div>  

<?php } ?>