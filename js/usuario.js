$(document).ready(function() {
    
    $(".borrar").on('click',function(event) {
        var user = $(this).attr('data-user');
        return confirm('¿Esta seguro que desea borrar el usuario '+user+' ?');
  
    });

});
