var PWDNEW = function () {
    var plugins = function () {
        $('#txtPassword').password({         
            showPercent: true,
            enterPass:'Escribe tu contraseña',
            shortPass:'La contraseña es demasiado corta',
            badPass:'Débil; intenta combinar letras y números',
            goodPass:'Medio; intenta usar carácteres especiales',
            strongPass:'Contraseña segura'
           
          }).on('password.score', function (e, score) {
            if (score == 100) {
              $('#btnGuardar').removeAttr('disabled');
            // alert('ok');
            } else {
             $('#btnGuardar').attr('disabled', true);
              //alert('mal');
            }
          });

    };
   
    var eventos = function () {


      $("#btnGuardar").click(function () {
          $(this).blur();
          $("#txtPassword").removeClass("is-invalid");
          $("#txtConfirmPassword").removeClass("is-invalid");
           $('#divMsj').hide();
           $('#spMsg').remove();


          $.ajax({
              type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
               dataType: 'json',
               data : $("#frmPwdNew").serialize(),
               url:"http://localhost:86/pagosenlinea/index.php/saveNewPassword",
           //  url:"http://172.24.12.29:86/pagosenlinea/index.php/saveNewPassword",
            beforeSend : function() {
                  
              $(".loader_bg").show();
              $("#emailaddress").val('');
            },
          success: function(data){
                  
                if(data.status){
                  location.href = data.data;
                                 
                  }else{
                      if(data.tipo === 'error_form'){      
                          $("#pwd_nuevo_error").html(data.data.contraseña_error);
                          $("#pwd_confirmar_error").html(data.data.confirmacion_contraseña_error);                    
                          if(data.data.contraseña_error !== ''){
                              $("#txtPassword").addClass("is-invalid");                             
                          } 
                          if(data.data.confirmacion_contraseña_error !== ''){
                            $("#txtConfirmPassword").addClass("is-invalid");                             
                        }                       
                      }else if(data.tipo === 'error_user'){
                        $('#divMsj').append(data.data);
                        $('#divMsj').show();
                        $('#txtPassword').val('').blur();
                        $('#txtConfirmPassword').val('');
                        $("#btnGuardar").attr("disabled",true);
                      }else if(data.tipo === 'error_pwd'){
                        $('#divMsj').append(data.data);
                        $('#divMsj').show();
                        $('#txtPassword').val('').blur();
                        $('#txtConfirmPassword').val('');
                        $("#btnGuardar").attr("disabled",true);
                      }else if(data.tipo === 'error_upd_pass'){
                        $('#divMsj').append(data.data);
                        $('#divMsj').show();
                        $('#txtPassword').val('').blur();
                        $('#txtConfirmPassword').val('');
                        $("#btnGuardar").attr("disabled",true);
                      }
                  }
              },
              complete: function () {
                  $(".loader_bg").hide();
              }
          })


      });
      



  };
  
  
 


    return {
        init: function () {
            plugins();
            eventos();
         

        }
    };
}();



