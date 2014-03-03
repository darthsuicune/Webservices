<?php

class MySqlDao implements DataStorage {
	var $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo ;
	}

	/**
	 * Abstraction layer for the query to the database.
	 *
	 * @param array $columns
	 * @param array $tables Needs to contain at least one value
	 * @param String $where
	 * @param array $whereArgs
	 * @return mixed
	 */
	public function query(array $columns, array $tables, $where, array $whereArgs) {
		if(substr_count($where, "?") != count($whereArgs)
				|| count($tables) < 1) {
			return false;
		}

		$projection;
		if (is_array ( $columns ) && count($columns) > 0) {
			$projection = join ( ',', $columns );
		} else {
			$projection = '*';
		}

		$sources = join ( ' NATURAL JOIN ', $tables );

		$query = "SELECT $projection FROM $sources";
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
				error_log("INSERT -> Index hasn't been defined. "
						. "Pass an assoc array with columns as indices");
				return false;
			}
			$fields[] = $index;
		}
		$fields = join(',', $fields);
		$row = implode(',', array_fill(0, count($values), '?'));
		$query = "INSERT INTO $table ($fields) VALUES ($row)";
		return $this->performParametrizedQuery($query, $values);
	}

	/**
	 * Abstraction layer for bulk inserting values into the database
	 *
	 * @param string $table
	 * @param array $values -> Must contain only arrays.
	 */
	public function bulkInsert($table, array $values){
		if($table == null || $table == "" || count($values) < 1){
			return false;
		}

		$parameters = array();
		foreach($values as $set){
			if(!is_array($set)){
				return false;
			}
		}
		
		
		$query = "INSERT INTO $table ($fields) VALUES ($row)";
		return $this->performParametrizedQuery($query, $values);
	}
	/**
	 * Abstraction layer for the update of rows from a database
	 * @param array $values
	 * @param string $table
	 * @param string $where
	 * @param array $whereArgs
	 */
	public function update($table, array $values, $where, array $whereArgs) {
		if($table == null || $table == "" || count($values) < 1 
				|| substr_count($where, "?") != count($whereArgs)){
			return false;
		}

		$set = "";
		foreach($values as $index => $value){
			if($index===0){
				error_log("UPDATE -> Index hasn't been defined. "
						. "Pass an assoc array with columns as indices");
				return false;
			}
			$set .= "$index=?,";
		}
		$set = substr($set, 0, -1);
		$parameters = array_merge(array_values($values), $whereArgs);
		$query = "UPDATE $table SET ($set)";
		if($where != null && (strcmp($where, "") != 0)){
			$query .= " WHERE $where";
		}
		return $this->performParametrizedQuery($query, $parameters);
	}
	/**
	 * Abstraction layer for the deletion of rows from a database
	 *
	 * @param string $table
	 * @param string $where
	 * @param array $whereArgs
	 */
	public function delete($table, $where, array $whereArgs) {
		if(substr_count($where, "?") != count($whereArgs) || $table == "" 
				|| $table == null || $where == null || $where == ""
				|| count($whereArgs) < 1){
			return false;
		}
		$query = "DELETE FROM " . $table . ' WHERE ' . $where;
		return $this->performParametrizedQuery($query, $whereArgs);
	}

	function performParametrizedQuery($query, array $whereArgs){
		$statement = false;
		try{
			$statement = $this->pdo->prepare($query);
			if($statement->execute($whereArgs)){
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				$statement->closeCursor();
				return $result;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			if($statement){
				error_log($statement->errorInfo());
				$statement->closeCursor();
			}
			return false;
		}
	}
}