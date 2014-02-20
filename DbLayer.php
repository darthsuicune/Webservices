<?php
/**
 * Documentation, License etc.
 *
 * @package Webserver
 */
include_once('Location.php');
include_once('User.php');
class DbLayer {

	const DB_ADDRESS = 'localhost'; // TODO: Set values
	const DB_USERNAME = 'testuser'; // TODO: Set values
	const DB_PASSWORD = 'password'; // TODO: Set values
	const DB_DATABASE = 'webservice';
	const CHARSET = 'UTF8';

	const RESULT_DB_CONNECTION_SUCCESFUL = 0;
	const RESULT_DB_CONNECTION_ERROR = 1;

	var $dbDsn;
	var $dbUsername;
	var $dbPassword;
	var $pdo;

	public function __construct($address = self::DB_ADDRESS, $username = self::DB_USERNAME,
			$password = self::DB_PASSWORD, $database = self::DB_DATABASE) {
		$this->dbUsername = $username;
		$this->dbPassword = $password;
		$this->dbDsn = 'mysql:dbname=' . $database . ';host='.$address . ';charset=' . self::CHARSET;
	}
	public function connect() {
		try{
			$this->pdo = new PDO ( $this->dbDsn, $this->dbUsername, $this->dbPassword );
			return self::RESULT_DB_CONNECTION_SUCCESFUL;
		} catch (PDOException $e) {
			return self::RESULT_DB_CONNECTION_ERROR;
		}
	}
	/**
	 * Abstraction layer for the query to the database.
	 *
	 * @param array $columns
	 * @param array $tables
	 * @param String $where
	 * @param array $whereArgs
	 * @return mixed
	 */
	public function query(array $columns, array $tables, $where, array $whereArgs) {
		if(substr_count($where, "?") != count($whereArgs)){
			return false;
		}

		$projection;
		if (is_array ( $columns ) && count($columns) > 0) {
			$projection = join ( ',', $columns );
		} else {
			$projection = '*';
		}
		$sources;
		if (is_array ( $tables ) && count($tables) > 0) {
			$sources = join ( ' NATURAL JOIN ', $tables );
		} else {
			$tableList = array (
					UsersContract::USERS_TABLE_NAME,
					UsersContract::ACCESS_TOKEN_TABLE_NAME,
					LocationsContract::LOCATIONS_TABLE_NAME
			);
			$sources = join ( ' JOIN ', $tableList );
		}

		$query = 'SELECT ' . $projection . ' FROM ' . $sources . ' WHERE ' . $where;
		return $this->performParametrizedQuery($query, $whereArgs);
	}
	/**
	 * Abstraction layer for the insert of rows into a database
	 *
	 * @param string $table
	 * @param array $values
	 */
	public function insert($table, array $values) {
		if($table == null || $table == ""){
			return null;
		}
	  
		//TODO BIG STUFF
		$fields = array();
		$row = array();
		foreach($values as $index => $value){
			$fields[] = mysql_real_escape_string($index);
			$row[] = mysql_real_escape_string($value);
		}
		$fields = join(',', $fields);
		$row = '\'' . join('\',\'', $row) . '\'';
		$query = 'INSERT INTO ' . $table . ' (' . $fields . ') VALUES (' . $row . ')';
		return $this->pdo->query($query);
	}
	/**
	 * Abstraction layer for the update of rows from a database
	 * @param array $values
	 * @param array $columns
	 * @param $table
	 * @param unknown $where
	 * @param array $whereArgs
	 */
	public function update(array $values, $table, $where, array $whereArgs) {
		if($table == null || $table == "" ||
				!is_array($values) || count($values) < 1 ||
				substr_count($where, "?") != count($whereArgs)){
			return null;
		}
		//TODO BIG STUFF
		
		$update = "";
		foreach($values as $index => $value){
			$update .= mysql_real_escape_string($index);
			$update .= "='";
			$update .= mysql_real_escape_string($value) . "'";
			$update .= ",";
		}
		$query = "UPDATE " . $table . " SET " . substr($update, 0, -1) . ' WHERE ' . $where;
		return $this->performParametrizedQuery($query, $whereArgs);
	}
	/**
	 * Abstraction layer for the deletion of rows from a database
	 *
	 * @param $table
	 * @param unknown $where
	 * @param array $whereArgs
	 */
	public function delete($table, $where, array $whereArgs) {
		if(substr_count($where, "?") != count($whereArgs) ||
				$where == null || $where == "" ||
				!is_array($whereArgs) || count($whereArgs) < 1){
			return false;
		}
		$query = "DELETE FROM " . $table . ' WHERE ' . $where;
		return $this->performParametrizedQuery($query, $whereArgs);
	}
	
	public function bulkInsert(){
		
	}
	
	function performParametrizedQuery($query, $whereArgs){
		$statement = false;
		try{
			$statement = $this->pdo->prepare($query);
			if($statement->execute($whereArgs)){
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				$statement->closeCursor();
				return $result;
			} else {
				var_dump($statement->errorInfo());
				return false;
			}
		} catch (PDOException $e) {
			if($statement){
				echo $statement->errorInfo();
				$statement->closeCursor();
			}
			return false;
		}
	}
}

?>
