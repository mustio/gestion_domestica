<?php
namespace App\Controlador;
use FMT\Controlador;
use App\Modelo;
use FMT\Configuracion;

class Gasto extends ControladorLocal {
	
	protected function accion_alta() {
		$vars['SUBTITULO'] = 'Alta';
            
		if ($_SERVER['REQUEST_METHOD']==='POST') {	
			$marca->load_instance($_POST);
			if ($marca->validar()) {
				if ($marca->alta()) {
					\App\Vista\Vista::msj_aviso('AVISO: Se dió de alta de forma exitosa.');
					$redirect = HTTP_PATH.'/index.php/marca/listar';
					$this->redirect($redirect);
					
				} else {
					\App\Vista\Vista::msj_error('ERROR: Error en el alta.');
					$redirect = HTTP_PATH.'/index.php/marca/listar';
					$this->redirect($redirect);
				}      
			} else {        
				\App\Vista\Vista::msj_error($marca->errores, $vars);
			}
		}
//		\App\Vista\Vista::load_object($marca, $vars);
		$this->vista = require VISTAS_PATH . 'am_gasto.php';
	}
	
	protected function accion_listar() {
		$vars = [];		
		$data = Modelo\Marca::listar();
		\App\Vista\Vista::msj_error($this->error, $vars);
		$this->vista = require_once VISTAS_PATH.'lista_marca.php';
	}
	
	protected function accion_modificar() {
		$marca = Modelo\Marca::obtener($this->_id);
		$old_image =  $marca->foto ;
		$vars['SUBTITULO'] = 'Modificación de Marca';		
		if ($_SERVER['REQUEST_METHOD']==='POST') {	
								
			$marca->load_instance($_POST);
			$marca->foto =  !empty($_FILES['foto']['name']) ? $_FILES['foto']['tmp_name'] : HTTP_PATH.'/fotos/marca/'.$old_image;
			$marca->id = $this->_id;
						
			if ($marca->validar()) {
				$marca->foto = !empty($_FILES['foto']['name']) ?  \App\Helper\ImagenSize::resize($_FILES['foto']['name'], $_FILES['foto']['tmp_name'],DIRECTORY_SAVE_MARCA,250,450)  : $old_image  ;
				if ($marca->modificacion()) {					
					\App\Vista\Vista::msj_aviso('AVISO: Se modificó de forma exitosa.');          
					$redirect = HTTP_PATH.'/index.php/marca/listar';
					$this->redirect($redirect);
				} else {
					\App\Vista\Vista::msj_error('ERROR: No se modificó ningun registro.'); 
					$redirect = HTTP_PATH.'/index.php/marca/listar';
					$this->redirect($redirect);
				}      
			} else {        
				\App\Vista\Vista::msj_error($marca->errores,$vars);			
			}
		
		}	
		\App\Vista\Vista::load_object($marca, $vars);
		$vars['FOTO'] = HTTP_PATH.'/fotos/marcas/'.$marca->foto;
		$this->vista = require VISTAS_PATH . 'am_gasto.php';
	}
	
	protected function accion_baja() {
		$marca = Modelo\Marca::obtener($this->_id);
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {	
			if ($marca->baja()) {
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
