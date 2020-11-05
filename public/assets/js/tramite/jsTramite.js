var TRAMITE = function () {
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
          { data: "n_tramite",
          createdCell: function (td, cellData, rowData, row, col) {
            $(td).css("text-align", "left");
            $(td).css("color", "blue");
            $(td).css("font-weight", "700");
            $(td).css("font-size", "18px");
          }
        
        },
          
          { data: "procedimiento" },
          { data: "freg" },
          { data: "estado" },       
          {
            data: null,
            targets: "no-sort",
            orderable: false,
            createdCell: function (td, cellData, rowData, row, col) {
              $(td).css("text-align", "center");
            },
            render: function (data, type, full, meta) {
              var botones = "";
  
              botones =
                '&nbsp;&nbsp;<button type="button" data-toggle="tooltip" title="Copiado!"  class="btn btn-secondary btn-rounded waves-effect  btn-sm" data-clipboard-demo data-clipboard-action="copy" data-clipboard-text="'+ data.n_tramite  +'"><i class="fas fa-copy"></i></button>';
  
              return botones;
            }
          }
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
      oTable_tramites = $("#tblDerTramites").dataTable(parms);

    };
   
    var getDerechosTramites = function () {
            $.ajax({
                type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
                 dataType: 'json',
                url:"http://localhost:86/pagosenlinea/index.php/Tramite/getDerechosTramitesUsuario",
                // url:"http://172.24.12.29:86/pagosenlinea/index.php/Tramite/getDerechosTramitesUsuario",
                 success: function(data){
                  if(data.status ){
                    oTable_tramites.fnClearTable();
                    if(data.data!== null){
                    oTable_tramites.fnAddData(data.data);
                        $('button[data-toggle="tooltip"]').tooltip({
                          animated: 'fade',
                          placement: 'left',
                          trigger: 'click'
                      });
                      var clipboardDemos = new ClipboardJS("[data-clipboard-demo]");
                      clipboardDemos.on("success", function (e) {
                          e.clearSelection();
                
                      });
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
               url:"http://localhost:86/pagosenlinea/index.php/Tramite/getDerechosTramitesUsuarioFiltro",
             //  url:"http://172.24.12.29:86/pagosenlinea/index.php/Tramite/getDerechosTramitesUsuario",
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
                  oTable_tramites.fnClearTable();
                  if(data.data!== null){
                    oTable_tramites.fnAddData(data.data);
                    $('button[data-toggle="tooltip"]').tooltip({
                      animated: 'fade',
                      placement: 'left',
                      trigger: 'click'
                  });
                  var clipboardDemos = new ClipboardJS("[data-clipboard-demo]");
                  clipboardDemos.on("success", function (e) {
                      e.clearSelection();
            
                  });
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
            getDerechosTramites();
    
            eventos();

        }
    };
}();



$(document).on('shown.bs.tooltip', function (e) {
  setTimeout(function () {
    $(e.target).tooltip('hide');
  }, 100);
});