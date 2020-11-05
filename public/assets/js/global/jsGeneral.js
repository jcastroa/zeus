$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    beforeSend : function(){
        cargando(true);
    },
    complete: function(){
        cargando(false);
    }
});


function cargando(estado){
    if(estado){
        $(".loader_bg").show();
        $("body").addClass("loader-open");
    }else{
        $(".loader_bg").hide();
        $("body").removeClass("loader-open");
    }
}