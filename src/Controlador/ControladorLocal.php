<?php
namespace App\Controlador;
use FMT\Controlador;
abstract class ControladorLocal extends Controlador
{
	public $error;
	public $id_puerto;
	public $permiso;
	protected function antes() {
	    // $control = str_replace("app\controlador\\", '', strtolower(static::class)); 
	    // $accion = str_replace("accion_", '', $this->accion);
			// 
	    // $this->permiso = \FMT\Usuarios::getPermiso($_SESSION['iu'])['permiso'];
      //   $this->id_puerto = \FMT\Usuarios::getMetadata($_SESSION['iu'])['metadata'];
	    // $permisos_sistema = json_decode(PERMISOS);
	    // if(isset($permisos_sistema->$control->$accion) && in_array($this->permiso, $permisos_sistema->$control->$accion)) {
	    //     return true;
	    // } else {
	    //     $control = new \App\Controlador\Error('na');
	    //     $control->procesar();
	    //     $datos = [];
	    //     $datos['session_data'] = $_SESSION['datos_usuario_logueado'];
	    //     \FMT\Logger::event('no_autorizado',$datos);
	    //     exit;
			// 
	    // }
	    return true;    
	}

	protected function redirect($url) {    
		header('Location: '.$url);
		exit;
	}
}