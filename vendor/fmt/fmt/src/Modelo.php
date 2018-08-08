<?php
namespace FMT;
abstract class Modelo{
	
	public $errores;
	
	abstract public function validar();
	abstract public function alta();
	abstract public function baja();
	abstract public function modificacion();
	//TODO: en PHP7 definir estos dos metodos como abstractos
	static public function listar(){trigger_error("Abstract method not defined", E_USER_ERROR);exit();}
	static public function obtener($id){trigger_error("Abstract method not defined", E_USER_ERROR);exit();}
	protected function __construct(){}

	public function __set($key,$value)
	{
		throw new \ErrorException('ERROR: Variable asignada "'.$key.'" no existe.');
	}

	public function __get($key)
	{
		throw new \ErrorException('ERROR: Variable consultada "'.$key.'" no existe.');
	}
}