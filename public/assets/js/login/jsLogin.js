var INIT = function () {

   

  
    var eventos = function () {

        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                $("#btnLogin").click();
            }
        });
      
        $("#btnLogin").click(function () {
            $(this).blur();
            $("#emailaddress").removeClass("is-invalid");
            $("#password").removeClass("is-invalid");
            $('#divError').hide();
            $('#spMsgError').remove();
            $('#divSuccess').remove();
            $.ajax({
                type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
                 dataType: 'json',
                 data : $("#frmLogin").serialize(),
                 url:"http://localhost:86/pagosenlinea/index.php/login/Autenticar",
              // url:"http://172.24.12.29:86/pagosenlinea/index.php/login/Autenticar",
            success: function(data){
                  if(data.status){
                    location.href = './././inicio';
                    }else{
                        if(data.tipo === 'error_form'){
                            $("#email_error").html(data.data.email_error);
                            $("#password_error").html(data.data.password_error);
                            if(data.data.email_error !== ''){
                                $("#emailaddress").addClass("is-invalid");                         
                            }                         
                            if(data.data.password_error !== ''){
                                $("#password").addClass("is-invalid");                             
                            }                          
                        }else if(data.tipo === 'error_user'){
                            $('#divError').append(data.data);
                            $('#divError').show();
                        }
                    }
                }
            })


        });
        



    };
    
  
    
 


    return {
        init: function () {

            eventos();
    


        }
    };
}();



