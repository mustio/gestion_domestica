<?php
session_start();
use FMT\Configuracion;
require_once 'constantes.php';
require_once BASE_PATH.'/vendor/autoload.php';
FMT\Configuracion::instancia()->cargar(BASE_PATH.'/config');
$config = Configuracion::instancia();
$dir = (isset($config['app']['web_path'])) ? $config['app']['web_path'] : dirname($_SERVER['SCRIPT_NAME']);  
define('HTTP_PATH', $dir);
$_id=0;
$control = "gasto";
$accion  = "alta";


$path_info = explode('/',ltrim($_SERVER['REQUEST_URI'],'/'));

if (!empty($path_info[1])) {
	
	if(isset($path_info[1])){
		$control = $path_info[1];
	}
	if(isset($path_info[2])){
		$accion = $path_info[2];
	}
	if(isset($path_info[3])){
		$_id = $path_info[3];
	}
}

$class = 'App\\Controlador\\' . ucfirst(strtolower($control));

if(!class_exists($class,1)) {
	$accion = 'e';
	$_SESSION['msj'] = 'No existe el controlador "'.ucfirst(strtolower($control)).'"';
	$class = 'App\\Controlador\\' . 'Error';
	
}

$control = new $class(strtolower($accion));

if(isset($_SESSION['msj'])) {
	$control->error = $_SESSION['msj'];
	unset($_SESSION['msj']);	
}
$control->_id = $_id;
$control->procesar();