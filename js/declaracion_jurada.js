$(document).ready(function() {
    
    $("#tabla").DataTable({ "ordering": false });
    $(".cerrar").on('click',function(event) {
        return confirm('¿ESTA SEGURO QUE DESEA CERRAR LA DECLARACION JURADA?');
  
    });


});
