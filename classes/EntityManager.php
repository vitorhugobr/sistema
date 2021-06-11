<?php
include("Environment.php");
class EntityManager {

	static private $instance;
	
	private $connection;
	private $errorPDO;

	
	private function EntityManager() {

		//Server version: 5.0.51a-24-log (Debian)
		/*desenvolvimento
		$host = 'ldbdes3';	
		$pwd = 'Srw*prc6n';	*/			
		
		//Server version 5.7
		//desenvolvimento
		//$host = 'ldbdes8';
		//$pwd = 'QUDsCW6U';
		
		$host = Environment::$host;
		$pwd = Environment::$pwd;
		//produção
		/*$host = 'ldbpro8';			
		$pwd = 'C83jm!ha2g';*/
		
		$user = 'procon_updt';
	    $db = 'procon';
	
		$constring = 'mysql:host=' . $host . ';dbname=' . $db; //.";charset=utf8";
		$this->connection = new PDO($constring, $user,$pwd, array(PDO::ATTR_PERSISTENT => true));
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/** 
	*Retorna um conjunto de registros em forma de array
	*/
	public function executeQuery($query) {
		$rows = $this->connection->query($query)->fetchAll();
		return $rows;
	}
	
	
	/** 
	 *Retorna um conjunto de registros associativo
	 */
	public function executeQueryAssoc($query) {
		
		$rows = Array();
		$execAssoc = $this->connection->query($query);
		$execAssoc->setFetchMode(PDO::FETCH_ASSOC);
		while( $row = $execAssoc->fetch()){ 
			$rows[] = $row;
		}
		//$execAssoc->setFetchMode(PDO::FETCH_BOTH);	
		return $rows;
	}

	public function prepare($query) {	
		try{
			$statement  = $this->connection->prepare($query);
		}catch(PDOException $e){
			$statement  = $e->getCode();
		}
		return $statement  ;
	}
	
	
	/**
	*	Retornando o número de linhas afetadas.
	*/
	public function execute($statement) {	
		try{
			$rowsAffected  = $this->connection->exec($statement);
		}catch(PDOException $e){
			$rowsAffected = $e->getCode();
		}
		return $rowsAffected;
	}	
		
	public function insert($statement) {
		try{
			$this->connection->exec($statement);
			$lastID = $this->connection->lastInsertId();		
		}catch(PDOException $e){
			return $e->getCode(). " - " . $e->getMessage();
			//$lastID = 0; 
		}
		return $lastID;
	}

	public function insertWithArgs($query, $args) {	
		$id = -1;
		try{
			$stmt = $this->connection->prepare($query);
			
			if(!$stmt->execute($args))
				return $stmt->errorInfo()[2];
			$id = $this->connection->lastInsertId(); 
		}catch(PDOException $e){
			return $e->getMessage();
		}
		return $id;
	}
		
	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new EntityManager();
		}
		return self::$instance;
	}
	
	/** 
		--------------------------------------------------
			Métodos com Prepare para evitar injections
	    --------------------------------------------------
	*/

	/** 
	* Retorna um conjunto de registros em forma de array
	*/
	public function qryPrepare($sql, $parms = null){
		try{
			$stmt = $this->connection->prepare($sql);
			(is_null($parms)) ? $stmt->execute() : $stmt->execute($parms);
			return $stmt->fetchAll();
		} catch (PDOException $e){
			return $e->getCode(). " - " . $e->getMessage();
		}
	}	

	/**
	*	Retornando o número de linhas afetadas.
	*/	
	public function execPrepare($sql, $parms){
		try{
			$stmt = $this->connection->prepare($sql);
			$stmt->execute($parms);
			return $stmt->rowCount();
		} catch (PDOException $e){
				return $e->getCode(). " - " . $e->getMessage();
		}
	}	
	
	/**
	*	Retornando o id inserido.
	*/	
	public function insertLastID($sql, $parms){
		try{
			$stmt = $this->connection->prepare($sql);			
			$stmt->execute($parms);		//echo "<pre>" . $stmt->debugDumpParams() . "</pre>";				
			$x = (int)($this->connection->lastInsertId());			
			
		} catch (PDOException $e){		
			if ($e->getCode() == 23000) {
				$mensagem = "Registro dulicado.";
			} else {
				$mensagem = $e->getMessage();
			}
			$x = $e->getCode(). " - " . $e->getMessage();
		}
		return $x;
	}		
}
?>
