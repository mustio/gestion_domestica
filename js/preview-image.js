function readURL(input) {

    if (input.files && input.files[0] && input.files[0].size <= 1500000 ) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        return true;
    }
    else {
      return false;
    }
}

$("#foto").change(function(){
    if(!readURL(this)){
      alert("La imagen tiene un tamaño no permitido ");
      $(this).val('');
    }
});
