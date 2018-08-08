<?php
namespace FMT;

abstract class Controlador
{
	protected $vista;
	protected $accion;

	public function __construct($accion)
	{
		$this->accion = 'accion_'.$accion;
	}
	
	protected function antes(){
		return true;
	}

	public function procesar()
	{
		$this->existe_accion();
		if($this->antes()){
			$this->{$this->accion}();
			$this->despues();
			$this->mostrar_vista();
		}	
	}

	protected function despues(){}

	protected function existe_accion()
	{
		$metodos = get_class_methods (get_class($this));
		if(!in_array($this->accion, $metodos))
		{
			throw new \Exception('ERROR: No existe la accion.');
		}
	}

	public function mostrar_vista(){
		echo $this->vista;
	}
}