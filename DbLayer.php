<?php
/**
 * Documentation, License etc.
 *
 * @package Webserver
 */
include_once('Location.php');
include_once('User.php');
require_once 'config.php';
class DbLayer {

	const RESULT_DB_CONNECTION_SUCCESFUL = 10;
	const RESULT_DB_CONNECTION_ERROR = 11;

	var $dbDsn;
	var $pdo;
	var $result;
	var $error;

	public function __construct() {
		$this->dbDsn = 'mysql:dbname=' . DB_DATABASE . ';host=' . DB_ADDRESS
		. ';charset=' . CHARSET;
		try{
			$this->pdo = new PDO ( $this->dbDsn, DB_USERNAME, DB_PASSWORD );
			$this->result = self::RESULT_DB_CONNECTION_SUCCESFUL;
		} catch (PDOException $e) {
			$this->result = self::RESULT_DB_CONNECTION_ERROR;
			$this->error = $e;
		}
	}
	public function connect() {
		return $this->result;
	}
	
	public function joinTables($tables) {
		$table = "";
		if(is_array($tables)){
			if (count($tables) > 1) {
				$table = "$tables[0]` JOIN `$tables[1]` ON `$tables[0]`.`id` = `$tables[1]`.`user_id";
			} else {
				$table = array_pop($tables);
			}
		} else {
			$table = $tables;
		}
		return $table;
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
	public function query(array $columns, $tables, $where, array $whereArgs) {
		if(substr_count($where, "?") != count($whereArgs)) {
			return false;
		}

		$projection;
		if (is_array ( $columns ) && count($columns) > 0) {
			$projection = "`" . join ( '`,`', $columns ) . "`";
		} else {
			$projection = '*';
		}

		$query = "SELECT $projection FROM `$tables`";
		
		if($where != ""){
			$query .= " WHERE $where";
		}
		return $this->performParametrizedQuery($query, $whereArgs);
	}
	/**
	 * Abstraction layer for the insert of rows into a database
	 *
	 * @param string $table
	 * @param array $values
	 */
	public function insert($table, array $values) {
		if($table == null || $table == "" || count($values) < 1){
			return false;
		}
			
		$fields = array();
		foreach($values as $index => $value){
			if($index===0){
				error_log("INSERT -> Indices aren't defined. "
						. "Pass an assoc array with columns as indices");
				return false;
			}
			$fields[] = $index;
		}
		$fields = join('`,`', $fields);
		$row = implode(',', array_fill(0, count($values), '?'));
		$query = "INSERT INTO `$table` (`$fields`) VALUES ($row)";
		return $this->performParametrizedQuery($query, $values);
	}

	public function bulkInsert($table, array $values){
		if($table == null || $table == "" || count($values) < 1){
			return false;
		}

		$parameters = array();
		$valuesToInsert = array();
		$rows = array();
		foreach($values as $set){
			if(!is_array($set)){
				error_log("BULK INSERT -> values must be an array containing sub-arrays".
						" with the values to insert in each row");
				return false;
			} else if (count($parameters) === 0 && (!array_key_exists("0", $set))) {
				$parameters = array_keys($set);
			}
			if(count($parameters) != count($set)){
				error_log("The amount of parameters does not match.");
				return false;
			}
			//Add ? for each value
			$rows[] = implode(',', array_fill(0, count($set), '?'));
			//Then add the values to the array sent as parameters
			$valuesToInsert = array_merge($valuesToInsert, array_values($set));
		}

		$parameters = join("`,`", $parameters);
		$rows = join("),(", $rows);
		$query = "INSERT INTO `$table` (`$parameters`) VALUES ($rows)";
		return $this->performParametrizedQuery($query, $valuesToInsert);
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
		if($table == null || $table == "" || count($values) < 1
				|| substr_count($where, "?") != count($whereArgs)){
			return false;
		}

		$set = "";
		foreach($values as $index => $value){
			if($index===0){
				error_log("UPDATE -> Indices aren't defined. "
						. "Pass an assoc array with columns as indices");
				return false;
			}
			$set .= "`$index`=?,";
		}
		$parameters = array_merge(array_values($values), $whereArgs);

		$query = "UPDATE `$table` SET ".substr($set, 0, -1);
		if($where != null && (strcmp($where, "") != 0)){
			$query .= " WHERE $where";
		}
		return $this->performParametrizedQuery($query, $parameters);
	}
	/**
	 * Abstraction layer for the deletion of rows from a database
	 *
	 * @param $table
	 * @param unknown $where
	 * @param array $whereArgs
	 */
	public function delete($table, $where, array $whereArgs) {
		if($table == "" || $table == null || $where == null || $where == ""
				|| substr_count($where, "?") != count($whereArgs)){
			error_log("DELETE -> Pass valid values. No defaults are provided for deletion.");
			return false;
		}
		$query = "DELETE FROM `$table` WHERE " . $where;
		return $this->performParametrizedQuery($query, $whereArgs);
	}

	function performParametrizedQuery($query, array $whereArgs){
		$statement = false;
		$result = false;

		try{
			if($whereArgs == array()){
				$statement = $this->pdo->query($query);
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				$statement->closeCursor();
			} else {
				$statement = $this->pdo->prepare($query);
				
				if($statement->execute(array_values($whereArgs))){
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					$statement->closeCursor();
				} else {
					var_dump($whereArgs);
					var_dump($statement->errorInfo()) . "<br>\n";
					echo $statement->debugDumpParams() . "<br>\n";
					echo $statement->queryString . "<br>\n";
					$result = false;
				}
			}
		} catch (PDOException $e) {
			var_dump($e);
			if($statement){
				$statement->closeCursor();
			}
			$result = false;
		}
		return $result;
	}
}