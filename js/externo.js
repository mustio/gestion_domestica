function maskMonto(target){
	$(target).inputmask('monto', {digits:2, allowMinus:false});
}

function validar_fecha(fecha_entrada,fecha_salida){
  var startDate = fecha_entrada.val().replace('-','/');
  var endDate =fecha_salida.val().replace('-','/');

  if(startDate > endDate){
    fecha_salida.val(''); 
  }
}

$(function () {
	$('.dateMA input').datetimepicker({
    format: 'DD/MM/YYYY', 
    keyBinds:{
      up:null,
      down:null,
      left:null,
      right:null
    }
  });
	
	$("input.block").on({
		 keydown: function(e) {
				return false;
		 }
	});
	
	$( "#salida" ).blur(function(){
		validar_fecha($('#entrada'),$('#salida'));
	});
	
		
	maskMonto('.monto');	
	
});