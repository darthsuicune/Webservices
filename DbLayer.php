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
	
	const RESULT_DB_CONNECTION_SUCCESFUL = 0;
	const RESULT_DB_CONNECTION_ERROR = 1;
	
	var $dbAddress;
	var $dbUsername;
	var $dbPassword;
	var $dbDatabase;
	var $mysqli;
	
	const DB_SELECT_USER_QUERY = 'SELECT * FROM users WHERE ';
	
	public function __construct($address = self::DB_ADDRESS, $username = self::DB_USERNAME, 
			$password = self::DB_PASSWORD, $database = self::DB_DATABASE) {
		$this->dbAddress = $address;
		$this->dbUsername = $username;
		$this->dbPassword = $password;
		$this->dbDatabase = $database;
	}
	public function connect() {
		$this->mysqli = new mysqli ( $this->dbAddress, $this->dbUsername, $this->dbPassword, 
				$this->dbDatabase );
		if ($this->mysqli->connect_errno) {
			return self::RESULT_DB_CONNECTION_ERROR;
		} else {
			$this->mysqli->set_charset("utf8");
			return self::RESULT_DB_CONNECTION_SUCCESFUL;
		}
	}
	public function error() {
	    return $this->mysqli->connect_error;
	}
	public function close() {
		$this->mysqli->close ();
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

		$query = 'SELECT ' . $projection . 
				' FROM ' . $sources . 
				$this->getCondition($where, $whereArgs);
		return $this->mysqli->query($query);
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
	    
	    $fields = array();
	    $row = array();
	    foreach($values as $index => $value){
	        $fields[] = $this->mysqli->real_escape_string($index);
	        $row[] = $this->mysqli->real_escape_string($value);
	    }
        $fields = join(',', $fields);
        $row = '\'' . join('\',\'', $row) . '\'';
	    $query = 'INSERT INTO ' . $table . ' (' . $fields . 
	    		') VALUES (' . $row . ')';
 	    return $this->mysqli->query($query);
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
				!is_array($values) || count($values) < 1){
			return null;
		}
		$update = "";
		foreach($values as $index => $value){
			$update .= $this->mysqli->real_escape_string($index);
			$update .= "='";
			$update .= $this->mysqli->real_escape_string($value) . "'";
			$update .= ",";
		}
		$query = "UPDATE " . $table . 
				" SET " . substr($update, 0, -1) .  
				$this->getCondition($where, $whereArgs);
		return $this->mysqli->query($query);
	}
	/**
	 * Abstraction layer for the deletion of rows from a database
	 * 
	 * @param $table
	 * @param unknown $where
	 * @param array $whereArgs
	 */
	public function delete($table, $where, array $whereArgs) {
		$query = "DELETE FROM " . $table . 
				$this->getCondition($where, $whereArgs);
		echo $query;
		return $this->mysqli->query($query);
	}
	/**
	 * Abstraction layer for creating a new DB with all its tables.
	 * 
	 * @param unknown $dbname        	
	 * @param array $tables        	
	 */
	
	function getCondition($where, $whereArgs){
		$selection = "";
		if (is_string ( $where ) && $where != "") {
			if (is_array ( $whereArgs )  && count($whereArgs) > 0) {
				$search = "%";
				foreach ( $whereArgs as $arg ) {
					$where = substr_replace ( $where, "'" . $arg .
							"'", strpos ( $where, $search ), strlen ( $search ) );
				}
				$selection = ' WHERE ' . $where;
			}
		}
		return $selection; 
	}
	
}

?>