var PASSWORD = function () {
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
              $('#btnGuardarPassword').removeAttr('disabled');
            // alert('ok');
            } else {
             $('#btnGuardarPassword').attr('disabled', true);
              //alert('mal');
            }
          });

    };
   
    var eventos = function () {


      $("#btnGuardarPassword").click(function () {
          $(this).blur();
          $("#txtPasswordActual").removeClass("is-invalid");
          $("#txtPassword").removeClass("is-invalid");
          $("#txtConfirmPassword").removeClass("is-invalid");
           $('#divError').hide();
           $('#divError').attr("style","display:none");
           $('#spMsgError').remove();
           $('#spMsgExito').remove();
           if($('#divError').hasClass("alert-info")){
             $('#divError').removeClass("alert-info").addClass("alert-danger");}
          $.ajax({
              type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
               dataType: 'json',
               data : $("#frmChangePassword").serialize(),
               url:"http://localhost:86/pagosenlinea/index.php/Password/changePassword",
            // url:"http://172.24.12.29:86/pagosenlinea/index.php/Password/changePassword",
          success: function(data){
                if(data.status){
                   $('#divError').removeClass("alert-danger").addClass("alert-info");
                   $('#divError').attr("style","background-color:#26C281");
                   $('#divError').append(data.data);
                   $('#txtPasswordActual').val('');
                   $('#txtPassword').val('').blur();
                   $('#txtConfirmPassword').val('');
                   $("#btnGuardarPassword").attr("disabled",true);
                                 
                  }else{
                      if(data.tipo === 'error_form'){
                          $("#pwd_actual_error").html(data.data.contraseña_actual_error);
                          $("#pwd_nuevo_error").html(data.data.contraseña_error);
                          $("#pwd_confirmar_error").html(data.data.confirmacion_contraseña_error);
                          if(data.data.contraseña_actual_error !== ''){
                              $("#txtPasswordActual").addClass("is-invalid");                         
                          }                         
                          if(data.data.contraseña_error !== ''){
                              $("#txtPassword").addClass("is-invalid");                             
                          } 
                          if(data.data.confirmacion_contraseña_error !== ''){
                            $("#txtConfirmPassword").addClass("is-invalid");                             
                        }                       
                      }else if(data.tipo === 'error_listado'){
                        Swal.fire(
                          'Atencion!',
                          'No se cargaron los datos correctamente.',
                          'warning'
                        );
                     }else if(data.tipo === 'error_pwd_actual'){
                          $('#divError').append(data.data);
                          $('#divError').show();
                      }else if(data.tipo === 'error_upd_pass'){
                        $('#divError').append(data.data);
                        $('#divError').show();
                      }else if(data.tipo === 'error_pwd_nueva'){
                        $('#divError').append(data.data);
                        $('#divError').show();
                    }else if(data.tipo === 'error_token' || data.tipo === 'error_auth' ){
                      Swal.fire({ title: "Su sesión ha expirado!", text: "Por favor vuelve a loguearte.", type: "warning", confirmButtonColor: "#348cd4", confirmButtonText:
                              'ir al Login',allowOutsideClick: false }).then((result) => {
                          if (result.value) {
                               var url = window.location;
                               location.href = url.origin+'/pagosenlinea/index.php/Login';
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
            plugins();
            eventos();
         

        }
    };
}();



