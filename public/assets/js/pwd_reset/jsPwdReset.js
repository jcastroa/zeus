var PWDRESET = function () {

   

  
    var eventos = function () {

      
      
        $("#btnEnviar").click(function () {
            $(this).blur();        
            $("#emailaddress").removeClass("is-invalid");
            $('#divMsj').hide();
            $('#spMsg').remove();
            $("#divMsj").removeClass("alert-danger").addClass("alert-success2");
           
            $.ajax({
                type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
                 dataType: 'json',
                 data : $("#frmPwdReset").serialize(),
                 url:"http://localhost:86/pagosenlinea/index.php/resetpwd",
             //  url:"http://172.24.12.29:86/pagosenlinea/index.php/resetpwd",
              beforeSend : function() {
                  
                $(".loader_bg").show();
                $("#emailaddress").val('');
              },
            success: function(data){
               
                  if(data.status){
                         $("#divForm").remove();
                         $('#divMsj').append(data.data);
                         $('#divMsj').show();
                         $('#lblInfo').show();
                    }else{
                        if(data.tipo === 'error_form'){
                            $("#email_error").html(data.data.email_error);
                            if(data.data.email_error !== ''){
                                $("#emailaddress").addClass("is-invalid");                         
                            }                                                
                        }else if(data.tipo === 'error_user'){
                            $("#divMsj").removeClass("alert-success2").addClass("alert-danger");
                            $('#divMsj').append(data.data);
                            $('#divMsj').show();
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

            eventos();
    


        }
    };
}();



