var PAGO = function () {

 
   
    var getProcedimientos = function () {
            $.ajax({
                type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
                 dataType: 'json',
                url:"http://localhost:86/pagosenlinea2/index.php/Procedimiento/getProcedimientos",
              // url:"http://172.24.12.29:86/pagosenlinea2/index.php/Procedimiento/getProcedimientos",
                 success: function(data){
                  if(data.status ){
                    $("#cbo_procedimiento").html("").append("<option value='' disabled selected>Selecciona...</option>");
                        for(var i = 0;i< data.data.length;i++){
                            $("#cbo_procedimiento").append("<option value='"+ data.data[i].iCodProcedimiento +"'>"+  data.data[i].vDescripcion   +"</option>");
                        }
                        $('#cbo_procedimiento').select2({
                            theme: 'bootstrap4',
                           width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                          });
                    }else{
                        if(data.tipo === 'error_form'){
                            $("#procedimiento_error").html(data.data.procedimiento_error);
                            if(data.data.procedimiento_error !== ''){
                                $("#cbo_procedimiento").addClass("is-invalid");                         
                            }                                               
                        }else if(data.tipo === 'error_token' || data.tipo === 'error_auth' ){
                            Swal.fire({ title: "Su sesión ha expirado!", text: "Por favor vuelve a loguearte.", type: "warning", confirmButtonColor: "#348cd4", confirmButtonText:
                                    'ir al Login',allowOutsideClick: false }).then((result) => {
                                if (result.value) {
                                     var url = window.location;
                                     location.href = url.origin+'/pagosenlinea2/index.php/Login';
                                }
                                });
                        }else {
                            Swal.fire(
                                'Atencion!',
                                'No se cargaron los datos correctamente.',
                                'warning'
                              );
                        }
                    }
                }
            })

    };
    
  
    var eventos = function () {

      
        $("#cbo_procedimiento").change(function () {        
            $("#cbo_procedimiento").removeClass("is-invalid");
            $.ajax({
                type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
                 dataType: 'json',
                 data : $("#frmProcedimiento").serialize(),
                  url:"http://localhost:86/pagosenlinea2/index.php/Procedimiento/getInfoProcedimiento",
            //  url:"http://172.24.12.29:86/pagosenlinea2/index.php/Procedimiento/getInfoProcedimiento",
            success: function(data){
                  if(data.status){
                       $("#frmPago").html(data.data);
                       $("#spMonto").html(data.procedimiento[0].vMonto);
                       $("#spDecimal").html(data.procedimiento[0].vDecimales);
                       $("#spProNom").html(data.procedimiento[0].vDescripcion);
                    }else{
                        if(data.tipo === 'error_form'){
                            $("#procedimiento_error").html(data.data.procedimiento_error);
                            if(data.data.procedimiento_error !== ''){
                                $("#cbo_procedimiento").addClass("is-invalid");                         
                            }                                               
                        }else if(data.tipo === 'error_token' || data.tipo === 'error_auth' ){
                            Swal.fire({ title: "Su sesión ha expirado!", text: "Por favor vuelve a loguearte.", type: "warning", confirmButtonColor: "#348cd4", confirmButtonText:
                                    'ir al Login',allowOutsideClick: false }).then((result) => {
                                if (result.value) {
                                     var url = window.location;
                                     location.href = url.origin+'/pagosenlinea2/index.php/Login';
                                }
                                });
                        }else {
                            Swal.fire(
                                'Atencion!',
                                'No se cargaron los datos correctamente.',
                                'warning'
                              );
                        }
                    }
                }
            })
        });
    };
    
 


    return {
        init: function () {
           
            getProcedimientos();
    
            eventos();

        }
    };
}();



