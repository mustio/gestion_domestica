<?php

namespace App\Helper;

use FMT\Configuracion;
use \PDO;

/**
 * Class Conexion
 *
 * Esta clase permite la conexion a multiples bases de datos, agregando en config/database.php['database']
 * una key con un nombre, y usando ese nombre en el construct.
 * El construct sin nombre usa los valores por defecto, una base con nombre no necesita redefinir todos los parametros
 *
 * @package App
 */
class Conexion {

	const SELECT = 0;
	const INSERT = 1;
	const DELETE = 2;
	const UPDATE = 3;

	/** @var string Codigo de error de MySQL si consulta devuelve false*/
	public $errorCode;
	/** @var string Mensaje de error de MySQL*/
	public $errorInfo;

	/** @var string */
	protected $database;

	public function __construct($database = '') {
		$this->database = $database;
	}


	/** @var \PDO */
	protected $_c;

	/**
	 * @return PDO
	 */
	public function conectaDB() {
		if (is_null($this->_c)) {
			$config = Configuracion::instancia();
			$host = $config['database']['host'];
			$database = $config['database']['database'];
			$username = $config['database']['user'];
			$passwd = $config['database']['pass'];
			if ($this->database) {
				if(isset($config['database'][$this->database]) && is_array($config['database'][$this->database])){
					if(isset($config['database'][$this->database]['host'])){
						$host = $config['database'][$this->database]['host'];
					}
					if(isset($config['database'][$this->database]['database'])){
						$database = $config['database'][$this->database]['database'];
					}
					if(isset($config['database'][$this->database]['user'])){
						$username = $config['database'][$this->database]['user'];
					}
					if(isset($config['database'][$this->database]['pass'])){
						$passwd = $config['database'][$this->database]['pass'];
					}
				}else{
					throw new \UnexpectedValueException('Base de datos seleccionada no está configurada');
				}
			}
			$this->_c = new PDO('mysql:host='.$host.';dbname='.$database, $username, $passwd, [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
		}
		return $this->_c;
	}


	protected $_stmts = [];

	/**
	 * @param \PDO $c
	 * @param string $sql
	 * @return \PDOStatement
	 */
	protected function preparar($c, $sql) {
		if (!isset($this->_stmts[$sql])) {
			$this->_stmts[$sql] = $c->prepare($sql);
		}
		return $this->_stmts[$sql];
	}

	/**
	 * Consulta a la db usando parametros
	 * Si hay un error, se devuelve false y se cargan las propiedades errorCode/errorInfo (revisar con ===, ya que update puede devolver 0)
	 *
	 * @param int $type constantes de clase
	 * @param string $sql
	 * @param array $params
	 * @return array|int|string|bool
	 */
	public function consulta($type, $sql, $params = []) {
		$c = $this->conectaDB();
		$stmt = $this->preparar($c, $sql);
		foreach ($params as $key => $value) {
			$stmt->bindValue($key, $value);
		}

		$stmt->execute();
		if ($stmt->errorCode() != '00000') {
			$this->errorCode = $stmt->errorCode();
			$this->errorInfo = $stmt->errorInfo();
			return false;
		}
		switch ($type) {
			case self::SELECT:
				$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $resultado;
			case self::INSERT:
				return $c->lastInsertId();
			case self::DELETE:
				return $stmt->rowCount();
			case self::UPDATE:
				return $stmt->rowCount();
			default:
				throw new \InvalidArgumentException('Tipo no reconocido');
		}

	}

}