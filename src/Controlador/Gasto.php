<?php
namespace App\Controlador;
use App\Controlador\ControladorLocal;
use App\Modelo;
use DateTime;


class Gasto extends ControladorLocal {

	private $gasto;
	
	protected function accion_alta() {
		$vars['SUBTITULO'] = 'Alta';
            
		if ($_SERVER['REQUEST_METHOD']==='POST') {
			$this->gasto = Modelo\Gasto::singleton();
			$respuesta = false;
			$lista = 'listado_ingreso';
			$this->gasto->load_instance($_POST);
			$this->gasto->fecha =  DateTime::createFromFormat('d/m/Y', $this->gasto->fecha)->format('Y-m-d');
			if ($this->gasto->validar()) {

				if ((int)$this->gasto->tipo === Modelo\Gasto::INGRESO){
					$respuesta = $this->gasto->alta_ingreso();
				} elseif((int)$this->gasto->tipo === Modelo\Gasto::EGRESO) {
					$respuesta = $this->gasto->alta_egreso();
					$lista = 'listado_egreso';
				}

				if ($respuesta) {
					\App\Vista\Vista::msj_aviso('AVISO: Se dió de alta de forma exitosa.');
					$redirect = HTTP_PATH.'/gasto/'.$lista;
					$this->redirect($redirect);
					
				} else {
					\App\Vista\Vista::msj_error('ERROR: Error en el alta.');
					$redirect = HTTP_PATH.'/gasto/'.$lista;
					$this->redirect($redirect);
				}      
			} else {        
				\App\Vista\Vista::msj_error($this->gasto->errores, $vars);
			}
		}
		\App\Vista\Vista::load_object($this->gasto, $vars);
		$this->vista = require VISTAS_PATH . 'am_gasto.php';
	}
	
	protected function accion_listado_egreso() {
		$vars = [];		
		$data = Modelo\Gasto::listar_egreso();
		$tipo =  ' ingreso';
		$alta = 'alta_egreso';
		\App\Vista\Vista::msj_error($this->error, $vars);
		$this->vista = require_once VISTAS_PATH.'lista_gasto.php';
	}

	protected function accion_listado_ingreso() {
		$vars = [];
		$data = Modelo\Gasto::listar_ingreso();
		$alta = 'alta_ingreso';
		$tipo =  ' ingreso';
		foreach ($data as $campo => &$valor){
			if ($campo == 'descripcion'){
				$valor['descripcion'] = mb_strimwidth($valor['descripcion'], 0, 10, "...");
				$valor['detalle'] = $valor['descripcion'];
			}
		}

		\App\Vista\Vista::msj_error($this->error, $vars);
		$this->vista = require_once VISTAS_PATH.'lista_gasto.php';
	}

	protected function accion_modificar() {
		$this->gasto = Modelo\Marca::obtener($this->_id);
		$old_image =  $this->gasto->foto ;
		$vars['SUBTITULO'] = 'Modificación de Marca';		
		if ($_SERVER['REQUEST_METHOD']==='POST') {	
								
			$this->gasto->load_instance($_POST);
			$this->gasto->foto =  !empty($_FILES['foto']['name']) ? $_FILES['foto']['tmp_name'] : HTTP_PATH.'/fotos/marca/'.$old_image;
			$this->gasto->id = $this->_id;
						
			if ($this->gasto->validar()) {
				$this->gasto->foto = !empty($_FILES['foto']['name']) ?  \App\Helper\ImagenSize::resize($_FILES['foto']['name'], $_FILES['foto']['tmp_name'],DIRECTORY_SAVE_MARCA,250,450)  : $old_image  ;
				if ($this->gasto->modificacion()) {					
					\App\Vista\Vista::msj_aviso('AVISO: Se modificó de forma exitosa.');          
					$redirect = HTTP_PATH.'/index.php/marca/listar';
					$this->redirect($redirect);
				} else {
					\App\Vista\Vista::msj_error('ERROR: No se modificó ningun registro.'); 
					$redirect = HTTP_PATH.'/index.php/marca/listar';
					$this->redirect($redirect);
				}      
			} else {        
				\App\Vista\Vista::msj_error($this->gasto->errores,$vars);			
			}
		
		}	
		\App\Vista\Vista::load_object($this->gasto, $vars);
		$vars['FOTO'] = HTTP_PATH.'/fotos/marcas/'.$this->gasto->foto;
		$this->vista = require VISTAS_PATH . 'am_gasto.php';
	}
	
	protected function accion_baja() {
		$this->gasto = Modelo\Marca::obtener($this->_id);
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {	
			if ($this->gasto->baja()) {
				\App\Vista\Vista::msj_aviso('AVISO: Se dio de baja en forma exitosa.');
				$redirect = HTTP_PATH.'/index.php/marca/listar';
				$this->redirect($redirect);
			} else {
				\App\Vista\Vista::msj_error('ERROR: Hubo un error al dar de baja.');
				$redirect = HTTP_PATH.'/index.php/marca/listar';
				$this->redirect($redirect);
			}			
		}	
	}
}
