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
				error_log("INSERT -> Indices aren't defined. "
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
	 * @param array $values -> Must contain only arrays. The first sub-array
	 * must provide through keys the parameters to use as columns. The second and further
	 * can then omit the keys or include them (they will be ignored anyway)
	 *
	 * Example: $values = array(array("key1"=>"value1", "key2"=>"value2"),
	 * array("value3", "value4"));
	 */
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

		$parameters = join(",", $parameters);
		$rows = join("),(", $rows);
		$query = "INSERT INTO $table ($parameters) VALUES ($rows)";
		return $this->performParametrizedQuery($query, $valuesToInsert);
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
				error_log("UPDATE -> Indices aren't defined. "
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
		if($table == "" || $table == null || $where == null || $where == ""
				|| substr_count($where, "?") != count($whereArgs)){
			error_log("DELETE -> Pass valid values. No defaults are provided for deletion.");
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
				error_log("Statement did not parse correctly");
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