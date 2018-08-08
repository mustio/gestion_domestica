<?php
	namespace App\Vista;
	require 'base.php';

	$vars['TITLE']			= 'Ingreso y Egreso Monetario';
	$vars['TITULO']			= 'Ingreso y Egreso Monetario';
	$vars['CONTROL']		= 'gasto';
	$vars['HTTP']				= HTTP_PATH.'/index.php';

	$vars['CSS_FILES'][]	= ['CSS_FILE' => HTTP_PATH."/css/style.css"];
	$vars['CSS_FILES'][]	= ['CSS_FILE' => "/cdn/bootstrap/datepicker/4.17.37/css/bootstrap-datetimepicker.min.css"];
	$vars['COMPONENTS']['CONTENT'] = (new Vista(VISTAS_PATH.'template/am_gasto.html',['OPTIONS'=>['CLEAN'=>false]]))->show();
    $vars['JS_FOOTER'][]['JS_SCRIPT'] = "/cdn/bootstrap/datepicker/4.17.37/js/bootstrap-datetimepicker.min.js";

	$html = (new Vista(VISTAS_PATH.'template/base.html',$vars))->show();

	return $html;
?>