<?php
$pie = FMT\VistasGenericas::pie();

?>
<?php
	$config = FMT\Configuracion::instancia();
	if($config['analytics']['habilitado'] && $config['analytics']['ua'])
	{	
	  $pie .= '
				<!-- Google Analytics -->
				<script type="text/javascript" src="/cdn/js/analytics.js"></script>
				<script type="text/javascript">
				ga("create", "'.$config['analytics']['ua'].'", "auto");
				ga("send", "pageview");
				</script>
				<!-- End Google Analytics -->	   
	  		  ';
	}
	echo $pie;