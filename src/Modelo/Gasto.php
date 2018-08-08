<?php
namespace App\Modelo;
use DateTime;
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
  const INGRESO = 1;
  const EGRESO = 2;
  private static $instancia;

  public function alta(){
      // TODO: Implement alta() method.
  }

  protected function __construct() {
  }

  public static function singleton(){
  	if (!static::$instancia instanceof static){
  		$clase =   __CLASS__;
  		static::$instancia = new $clase;
	}
	return static::$instancia;
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
          $egreso->fecha = DateTime::createFromFormat('Y-m-d',$resultado['fecha']);
        }
	}
    return $egreso;
  }

  public function alta_ingreso() {
    $conexion = new Conexion;
    $sql =  "INSERT INTO ingreso
			(nombre, descripcion, fecha, monto)
			VALUES
		( :nombre, :descripcion,:fecha, :monto )";
    $resultado= $conexion->consulta(Conexion::INSERT, $sql,
		[
			":nombre" => $this->nombre,
			":descripcion" => $this->descripcion,
			":fecha" => $this->fecha,
			":monto" => $this->monto
		]);
    var_dump($resultado, $this);exit;
    
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


  
	public static function listar_ingreso(){
		$sql = "SELECT  id,fecha,nombre,descripcion,monto
		FROM ingreso
		WHERE borrado = 0
		ORDER BY fecha ASC";
		$mbd = new Conexion;
		$resultado = $mbd->consulta(Conexion::SELECT, $sql);
		return ($resultado) ? $resultado : [];
	}

	public static function listar_egreso(){
		$sql = "SELECT  id,fecha,nombre,descripcion,monto
    FROM egreso
    WHERE borrado = 0
    ORDER BY fecha ASC";
		$mbd = new Conexion;
		$resultado = $mbd->consulta(Conexion::SELECT, $sql);
		return ($resultado) ? $resultado : [];
	}

	/**
	 * @return bool
	 * @throws \SimpleValidator\SimpleValidatorException
	 */
	public function validar(){
		$rules = [
			"nombre" => ["required"],
			"descripcion" => ["required",'max_length(250)'],
			"tipo" => ["required",'integer'],
			"monto" => ["required",'max_length(80)'],
			"fecha" => ["required",
				'fecha_valida' => function($val){
					return (DateTime::createFromFormat('Y-m-d',$val)) ? true : false;
				}
			],
		];

		$names = [
		  'nombre' => 'Concepto',
		  'fecha' => 'Fecha',
		  'descripcion' => "Descripcion",
		  'monto' => "Monto",
		  'tipo' => "Tipo"
	  ];

    $validacion = Validator::validate((array)$this, $rules, $names);
    $validacion->customErrors([
      "required"      => "Campo <strong>:attribute</strong> requerido",
      "numeric"       => "Seleccione un <strong>:attribute </strong> válido",
      "max_length"    => "El campo <strong>:attribute</strong> debe tener como máximo :params(0) caracteres",
		"fecha_valida" => "La <strong>:attribute</strong> ingresa no es valida"
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