<?php
	namespace App\Vista;
	require 'base.php';

	$vars['TITLE']			= 'Atención';
	$vars['TITULO']			= 'Atención';
	$vars['SUBTITULO']		= 'Usuario no autorizado.';
	$vars['COMPONENTS']['CONTENT'] ='<h5><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> No esta autorizado para usar esta funcionalidad.</h5>';

	$html = (new Vista(VISTAS_PATH.'template/base.html',$vars))->show();
	return $html;
?>
