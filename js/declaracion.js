$(document).ready(function(){
	 const CARGA = '1',
           DESCARGA = '2';
    
    if ($("#movimiento").val() == CARGA){
        	$("#id_presentacion").attr("disabled",false);
    }else{
        	$("#id_presentacion").attr('disabled','disabled');
        	$("#id_presentacion").val('');  
    }

    $(".baja").on('click',function(event) {
        return confirm('¿ESTA SEGURO QUE DESEA BORRAR LA DECLARACION?');
  
    });

   
    $("#movimiento").on('change',function(event) {
        if ($("#movimiento").val() == CARGA){
        	$("#id_presentacion").attr("disabled",false);
        }else{
        	$("#id_presentacion").attr('disabled','disabled');
        	$("#id_presentacion").val('');  
        }
  
    });
});
