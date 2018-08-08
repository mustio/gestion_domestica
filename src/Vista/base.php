<?php
	namespace App\Vista;
	$vars['CSS_FILES'][]['CSS_FILE'] = "/cdn/bootstrap/css/bootstrap.min.css";
	$vars['CSS_FILES'][]['CSS_FILE'] = "/cdn/poncho-v01/css/droid-serif.css";
	$vars['CSS_FILES'][]['CSS_FILE'] = "/cdn/poncho-v01/css/font-awesome.min.css";
	$vars['CSS_FILES'][]['CSS_FILE'] = "/cdn/poncho-v01/css/roboto-fontface.css";
	$vars['CSS_FILES'][]['CSS_FILE'] = "/cdn/poncho-v01/css/poncho.min.css";
	$vars['CSS_FILES'][]['CSS_FILE'] = "/cdn/estiloIS/2/estilois.css";
	$vars['CSS_FILES'][]['CSS_FILE'] = "/cdn/bootstrap/datepicker/4.17.37/css/bootstrap-datetimepicker.min.css";

	$vars['JS_FILES'][]['JS_FILE'] = "/cdn/js/jquery.js";
	$vars['JS_FILES'][]['JS_FILE'] = "/cdn/bootstrap/js/bootstrap.min.js";
	$vars['JS_FILES'][]['JS_FILE'] = "/cdn/momentjs/2.14.1/moment.min.js";
	$vars['JS_FILES'][]['JS_FILE'] = "/cdn/momentjs/2.14.1/es.js";
	$vars['JS_FILES'][]['JS_FILE'] = "/cdn/bootstrap/datepicker/4.17.37/js/bootstrap-datetimepicker.min.js";

	$vars['COMPONENTS']['CABECERA'] = (new Vista(VISTAS_PATH.'widgets/cabecera.php'))->show();
	$vars['COMPONENTS']['PIE']      = (new Vista(VISTAS_PATH.'widgets/footer.php'))->show();