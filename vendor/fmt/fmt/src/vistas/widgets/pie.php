<?php
$url_contacto = '';
if(isset($conf)){
  if($conf['url_contacto']){
    $url_contacto = (string) $conf['url_contacto'];
  }
}
?>
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <a href="<?php echo $url_contacto?>" class="btn btn-info" >Reportar un error</a>
      </div>
      <div class="col-md-3">
        <a href=""><img  src="" alt="Ir al Sitio Ministerio de Transporte"></a>
      </div>
    </div>
  </div>
</footer>