<?php

namespace App\Controlador;
use FMT\Controlador;

class Error extends Controlador {

	public 	 $_id;

	protected function accion_e()
	{
		$this->vista = $this->error;
	}

	protected function accion_na()
	{		
		$this->vista = include VISTAS_PATH.'no_autorizado.php';
	}	
}