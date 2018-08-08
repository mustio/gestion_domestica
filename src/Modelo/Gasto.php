<?php
namespace App\Modelo;
use FMT\Usuarios;
use FMT\Modelo;
use \SimpleValidator\Validator;
use \App\Helper\Conexion;
use FMT\Logger;

class Gasto extends Modelo {

  public $id;
  public $fecha;
  public $nombre;
  public $descripcion;
  public $monto;
  public $tipo;

  public function alta(){
      // TODO: Implement alta() method.
  }


  public static function obtener_ingreso($id = null){
    $ingreso = new static;
    $resultado = false;
    if($id != null){
      $sql = "SELECT id,nombre, descripcion, fecha, monto
			  FROM ingreso
      WHERE id = :id";
      $mbd = new Conexion;
      $resultado = $mbd->consulta(Conexion::SELECT, $sql, [":id"=> $id]);    
    
        if ($resultado) {
          $resultado =$resultado[0];
          $ingreso->id = $resultado["id"];
          $ingreso->nombre= $resultado["nombre"];
          $ingreso->descripcion = $resultado['descripcion'];
          $ingreso->fecha = $resultado['fecha'];
          $ingreso->monto = $resultado['monto'];
        }
	}    
    return $ingreso;
  }

  public static function obtener_egreso($id = null){
    $egreso = new static;
    $resultado = false;
    if($id != null && is_numeric($id)){
      $sql = "SELECT id,nombre, descripcion, fecha
			  FROM egreso
      WHERE id = :id";
      $mbd = new Conexion;
      $resultado = $mbd->consulta(Conexion::SELECT, $sql, [":id"=> $id]);

        if ($resultado) {
          $resultado =$resultado[0];
          $egreso->id = $resultado["id"];
          $egreso->nombre= $resultado["nombre"];
          $egreso->descripcion = $resultado['descripcion'];
          $egreso->fecha = $resultado['fecha'];
        }
	}
    return $egreso;
  }

  public function alta_ingreso() {
    $conexion = new Conexion;
    $resultado= $conexion->consulta(Conexion::INSERT, 
    "INSERT INTO ingreso
		(nombre,descripcion, fecha, monto)
		VALUES
		(:nombre, :descripcion,:fecha, :monto)",
		[
	
			":nombre" => $this->nombre,
			":descripcion" => $this->descripcion,
			":fecha" => $this->fecha,
			":monto" => $this->monto,

		]);
    
    return $resultado;    
  }
  public function alta_egreso() {
    $conexion = new Conexion;
    $resultado= $conexion->consulta(Conexion::INSERT,
    "INSERT INTO egreso
		(nombre,descripcion, fecha, monto)
		VALUES
		(:nombre, :descripcion,:fecha, :monto)",
		[

			":nombre" => $this->nombre,
			":descripcion" => $this->descripcion,
			":fecha" => $this->fecha,
			":monto" => $this->monto,

		]);

    return $resultado;
  }

  public function modificacion() {
    $sql = "UPDATE 	marca
				    SET			foto = :foto,
										nombre = :nombre
				    WHERE 	id = :id;";
    $mbd = new Conexion;
    $resultado = $mbd->consulta(Conexion::UPDATE, $sql,
    
    [ 
      ":id" => $this->id,      
			":foto" => $this->foto,
			":nombre" => $this->nombre

    ]);
    
    if ($resultado) {
			$datos = (array)$this;
			$datos['modelo'] = 'Marca';
			//Logger::event("modificacion",$datos);
    }
    
    return $resultado;
  }
  
  public function baja(){
    $sql = "UPDATE marca
    SET
    borrado = 1
    WHERE id = :id;";
    $mbd = new Conexion;
    $resultado = $mbd->consulta(Conexion::UPDATE, $sql,
    [ 
      ":id" => $this->id
    ]);    
    
    if ($resultado) {
			$datos = (array)$this;
			$datos['modelo'] = 'Marca';
			//Logger::event("baja",$datos);
    }
    
    return $resultado;    
  }


  
  public static function listar(){
    $sql = "SELECT  id,foto, nombre
    FROM marca
    WHERE borrado =0
    ORDER BY nombre ASC";
    $mbd = new Conexion;
    $resultado = $mbd->consulta(Conexion::SELECT, $sql);
    return ($resultado) ? $resultado : [];
  }
	
	public static function listar_cmb_marca(){
		$sql = "SELECT  id,nombre
		FROM marca
		WHERE borrado = 0
		ORDER BY nombre DESC";
		$mbd = new Conexion;
		$resultado = $mbd->consulta(Conexion::SELECT, $sql);
		if ($resultado) {
			foreach ($resultado as $key => &$value) {
				$aux[$value['id']] = $value['nombre'];
			}
		}	else {
			$aux[0] = "sin dato";
		}
		return $aux;
	}  
  
  public function validar(){
		$rules = [
			"foto" => ["required"],
			"nombre" => ["required",'max_length(80)'],
		];   
    $validacion = Validator::validate((array)$this, $rules);
    $validacion->customErrors([
      "required"      => "Campo :attribute requerido",                               
      "numeric"       => "El formato de :attribute es inválido. Se aceptan sólo valores numéricos",                               
      "max_length"    => "El campo :attribute debe tener como máximo :params(0) caracteres"                               
    ]);
    if ($validacion->isSuccess() == true) {
      return true;
    } 
    else {
      $this->errores = $validacion->getErrors();
      return false;
    }
  }

   public function load_instance($content) {

      $properties = get_object_vars($this);
      foreach ($properties as $key => $value) {
          $this->{$key} = (isset($content[$key])) ? $content[$key] : '';
      }
  }   
}