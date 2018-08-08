<?php
session_start();
use FMT\Logger;
use FMT\Usuarios;
use FMT\Configuracion;
require_once 'constantes.php';
require_once BASE_PATH.'/vendor/autoload.php';
FMT\Configuracion::instancia()->cargar(BASE_PATH.'/config');
$config = Configuracion::instancia();
$dir = (isset($config['app']['web_path'])) ? $config['app']['web_path'] : dirname($_SERVER['SCRIPT_NAME']);  
define('HTTP_PATH', $dir);