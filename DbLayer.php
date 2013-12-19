<?php
/**
     * Documentation, License etc.
     *
     * @package Webserver
     */
include_once 'Webserver.php';
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
	
	public function __construct($address = self::DB_ADDRESS, $username = self::DB_USERNAME, $password = self::DB_PASSWORD, 
			$database = self::DB_DATABASE) {
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
			return self::RESULT_DB_CONNECTION_SUCCESFUL;
		}
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
	 * @param array $whereargs
	 * @return mixed 
	 */
	public function query(array $columns, array $tables, $where, array $whereargs) {
		$projection;
		if (is_array ( $columns )) {
			$projection = join ( ',', $columns );
		} else {
			$projection = '*';
		}
		$sources;
		if (is_array ( $tables )) {
			$sources = join ( ' JOIN ', $tables );
		} else {
			$tableList = array (
					'users',
					'locations',
			);
			$sources = join ( ' JOIN ', $tableList );
		}
		
		$selection = '';
		if (is_string ( $where ) && $where != "") {
			if (is_array ( $whereargs )) {
				$search = "%";
				foreach ( $whereargs as $arg ) {
					$where = substr_replace ( $where, $arg, strpos ( $where, $search ), 
							strlen ( $search ) );
				}
				$selection = ' WHERE ' . $where;
			}
		}
		$query = 'SELECT ' . $projection . ' FROM ' . $sources . $selection;
		return mysqli_query($this->mysqli, $query );
	}
	/**
	 * Abstraction layer for the insert of rows into a database
	 * 
	 * @param array $columns        	
	 * @param unknown $table        	
	 * @param array $values        	
	 */
	public function insert(array $columns, $table, array $values) {
	}
	/**
	 * Abstraction layer for the update of rows from a database
	 * 
	 * @param array $columns        	
	 * @param array $tables        	
	 * @param unknown $where        	
	 * @param array $whereargs        	
	 */
	public function update(array $columns, array $tables, $where, array $whereargs) {
	}
	/**
	 * Abstraction layer for the deletion of rows from a database
	 * 
	 * @param array $columns        	
	 * @param array $tables        	
	 * @param unknown $where        	
	 * @param array $whereargs        	
	 */
	public function delete(array $columns, array $tables, $where, array $whereargs) {
	}
	/**
	 * Abstraction layer for creating a new DB with all its tables.
	 * 
	 * @param unknown $dbname        	
	 * @param array $tables        	
	 */
}

?>