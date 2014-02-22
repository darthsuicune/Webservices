<?php
require_once('DbLayer.php');

interface DataStorage{
	public function connect($object);
	public function getLastError();
	public function query(array $columns, array $tables, $where, array $whereArgs);
	public function insert($table, array $values);
	public function bulkInsert();
	public function update(array $values, $table, $where, array $whereArgs);
	public function delete($table, $where, array $whereArgs);
}

class MySqlDao implements DataStorage {

	const DB_ADDRESS = 'localhost'; // TODO: Set values
	const DB_USERNAME = 'wait'; // TODO: Set values
	const DB_PASSWORD = 'wat'; // TODO: Set values
	const DB_DATABASE = 'webservice';
	const CHARSET = 'UTF8';

	const RESULT_DB_CONNECTION_SUCCESFUL = 1;
	const RESULT_DB_CONNECTION_ERROR = 0;

	var $pdo;

	public function __construct(PDO $pdo) {
		try{
			$this->pdo = $pdo ;
			return self::RESULT_DB_CONNECTION_SUCCESFUL;
		} catch (PDOException $e) {
			return self::RESULT_DB_CONNECTION_ERROR;
		}
	}
	
	public function getLastError() {
		//TODO: stateful, return errors from method calls or just log them.
		return $this->pdo->connect_error;
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