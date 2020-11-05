var REGISTRO = function () {

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
              $('#btnRegistro').removeAttr('disabled');
            // alert('ok');
            } else {
             $('#btnRegistro').attr('disabled', true);
              //alert('mal');
            }
          });

    };

  
    var eventos = function () {

       
      
        $("#btnRegistro").click(function () {
            $(this).blur();
           // grecaptcha.reset();
            $("#emailaddress").removeClass("is-invalid");
            $("#txtNombres").removeClass("is-invalid");
            $("#txtApellidos").removeClass("is-invalid");
            $("#txtPassword").removeClass("is-invalid");
            $("#txtPasswordConfirmacion").removeClass("is-invalid");
            $('#divMsg').hide();
            $('#spMsg').remove();
           
            $.ajax({
                type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
                 dataType: 'json',
                 data : $("#frmRegistro").serialize(),
                 url:"http://localhost:86/pagosenlinea/index.php/registro/registrarUsuario",
              // url:"http://172.24.12.29:86/pagosenlinea/index.php/login/Autenticar",
              beforeSend : function() {
                  
                $(".loader_bg").show();
               
              },
            success: function(data){
                 
                  if(data.status){
                     location.href = data.data;
                    }else{
                        if(data.tipo === 'error_form'){
                            $("#email_error").html(data.data.email_error);
                            $("#nombres_error").html(data.data.nombres_error);
                            $("#apellidos_error").html(data.data.apellidos_error);
                            $("#contraseña_error").html(data.data.password_error);
                            $("#contraseña_confirmacion_error").html(data.data.password_confirm_error);
                            if(data.data.email_error !== ''){
                                $("#emailaddress").addClass("is-invalid");                         
                            }                         
                            if(data.data.nombres_error !== ''){
                                $("#txtNombres").addClass("is-invalid");                             
                            }  
                            if(data.data.apellidos_error !== ''){
                                $("#txtApellidos").addClass("is-invalid");                             
                            }  
                            if(data.data.password_error !== ''){
                                $("#txtPassword").addClass("is-invalid");                             
                            }  
                            if(data.data.password_confirm_error !== ''){
                                $("#txtPasswordConfirmacion").addClass("is-invalid");                             
                            }                          
                        }else if(data.tipo === 'error_captcha'){
                            $('#divMsg').append(data.data);
                            $('#divMsg').show();
                        }else if(data.tipo === 'error_user'){
                            $('#divMsg').append(data.data);
                            $('#divMsg').show();
                        }
                    }
                },
                complete: function(data) {
                    grecaptcha.reset();
                    $(".loader_bg").hide();
                }
            })


        });
        



    };
    
  
    
 


    return {
        init: function () {

            eventos();
            plugins();


        }
    };
}();



