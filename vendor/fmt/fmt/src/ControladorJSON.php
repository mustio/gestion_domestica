<?php

namespace FMT;

abstract class ControladorJSON extends Controlador {

	/* Atributos */

	protected $resultado = [];

	/* Métodos */

	// Mostrar Vista (Redefinicion)
	public function mostrar_vista() {

		// Cabecera JSON
		header('Content-Type: application/json');

		// Devuelvo Resultado JSON
		echo json_encode($this->resultado);
	}

}