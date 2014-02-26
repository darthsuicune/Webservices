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
	 * @param array $tables
	 * @param String $where
	 * @param array $whereArgs
	 * @return mixed
	 */
	public function query(array $columns, array $tables, $where, array $whereArgs) {
		if(substr_count($where, "?") != count($whereArgs)
				|| (!is_array ( $tables )) || count($tables) == 0) {
			return false;
		}

		$projection;
		if (is_array ( $columns ) && count($columns) > 0) {
			$projection = join ( ',', $columns );
		} else {
			$projection = '*';
		}

		$sources = join ( ' NATURAL JOIN ', $tables );

		$query = 'SELECT ' . $projection . ' FROM ' . $sources;
		if($where != ""){
			$query .= ' WHERE ' . $where;
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
		if($table == null || $table == "" || count($values < 1)){
			return false;
		}
			
		$fields = array();
		foreach($values as $index => $value){
			$fields[] = $index;
		}
		$fields = join(',', $fields);
		$row = implode(',', array_fill(0, count($values), '?'));
		$query = 'INSERT INTO ' . $table . ' (' . $fields . ') VALUES (' . $row . ')';
		return $this->performParametrizedQuery($query);
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
			return false;
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
		if(substr_count($where, "?") != count($whereArgs) 
				|| $table == "" || $table == null 
				|| $where == null || $where == ""
				|| !is_array($whereArgs) || count($whereArgs) < 1){
			return false;
		}
		$query = "DELETE FROM " . $table . ' WHERE ' . $where;
		return $this->performParametrizedQuery($query, $whereArgs);
	}

	public function bulkInsert($table, array $values){
		if($table == null || $table == ""){
			return false;
		}

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