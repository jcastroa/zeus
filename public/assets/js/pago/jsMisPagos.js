var MISPAGOS = function () {
    var plugins = function () {

     

      $('#txtFecha').daterangepicker({
        "autoApply": true,
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Do",
                "Lun",
                "Mar",
                "Mie",
                "Jue",
                "Vie",
                "Sab"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        }
     
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });



    var parms = {
        columns: [
          { data: "cod_ref"},   
          { data: "descripcion" }  ,     
          { data: "medio_pago" },
          { data: "monto" },
          { data: "moneda" },
          { data: "estado" },
          { data: "f_transaccion" }
        ],
        paging: true,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: false,
       
        language: {
          search: "Buscar: ",
          info: "Total registrados: _MAX_",
          zeroRecords: "No se encontraron coincidencias para su busqueda",
          infoEmpty: "",
          infoFiltered: "",
          paginate: {
            previous: "Anterior",
            next: "Siguiente",
            first: "Inicio",
            last: "Fin"
          }
        },
      
      };
      oTable_pagos = $("#tblPagos").dataTable(parms);

    };












   
    var getPagos = function () {
            $.ajax({
                type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
                 dataType: 'json',
                url:"http://localhost:86/pagosenlinea2/index.php/PagoD/getPagosUsuario",
                // url:"http://172.24.12.29:86/pagosenlinea2/index.php/PagoD/getPagosUsuario",
                 success: function(data){
                  if(data.status ){
                    oTable_pagos.fnClearTable();
                    if(data.data !== null){
                      oTable_pagos.fnAddData(data.data);
                    }
                    }else{
                         if(data.tipo === 'error_token' || data.tipo === 'error_auth' ){
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

    };
    
  
    var eventos = function () {

      $("#btnFiltrar").click(function () {
          $(this).blur();
          var fechaRango =$('#txtFecha').data('daterangepicker');
          $.ajax({
            type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
             dataType: 'json',
             url:"http://localhost:86/pagosenlinea2/index.php/PagoD/getPagosUsuarioFiltro",
            //   url:"http://172.24.12.29:86/pagosenlinea2/index.php/PagoD/getPagosUsuarioFiltro",
             data:{
            //  fini : fechaRango.startDate._d.toISOString(),
             // ffin : fechaRango.endDate._d.toISOString(),
              ai:fechaRango.startDate._d.getFullYear(),
              mi:fechaRango.startDate._d.getMonth(),
              di:fechaRango.startDate._d.getDate(),
              af:fechaRango.endDate._d.getFullYear(),
              mf:fechaRango.endDate._d.getMonth(),
              df:fechaRango.endDate._d.getDate()
             },
             success: function(data){
              if(data.status ){
                oTable_pagos.fnClearTable();
                if(data.data !== null){
                oTable_pagos.fnAddData(data.data);
                }
                }else{
                     if(data.tipo === 'error_token' || data.tipo === 'error_auth' ){
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
            getPagos();
            eventos();
           

        }
    };
}();



