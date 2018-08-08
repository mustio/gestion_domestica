<?php

namespace FMT;

class VistasGenericas{

	/**
	* se ubica en dentro de la etiqueta <header>. interna/pública
	* el parametro conf es un array con 4 claves opcionales
	* 'links'=> ['url'=>'texto link',] o ['texto menu'=>['url'=>'texto link',]]. por defecto en blanco
	* 'incluye_cerrar_sesion'=> bool, agrega el menu de cerrar sesion al final, por defecto true
	* 'activo'=> url, la key en links para marcar como actual
	* 'logo'=> url, por defecto https://www.transporte.gob.ar/_img/logo_ministerio_grande_blanco.png
	* 'dev' => bool, agrega al menu un warning de versión en desarrollo, por defecto false.
	* @param array $conf
	* @return string
	*/	
	public static function cabecera($conf=NULL){
		ob_start();
		include __DIR__.'/vistas/widgets/cabecera.php';
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}

	/** 
	* pie interno para reportar error. Uso en aplicaciones internas del área, requiere carga de archivo estilois.css.
	* devuelve el bloque <footer>, para pegar directo en <body>, requiere estilois.css
	* @param array $conf [url_contacto=>direccion del boton(opcional)]
	* @return string 
	*/
	public static function pie($conf=NULL){
		ob_start();
		include __DIR__.'/vistas/widgets/pie.php';
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}

}