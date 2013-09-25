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
	var $dbAddress;
	var $dbUsername;
	var $dbPassword;
	var $dbDatabase;
	var $mysqli;
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
			echo "Connection failed: " . $this->mysqli->connect_error;
		} else {
			return $this->mysqli;
		}
	}

	public function query(array $columns,array $tables, $where,array $whereargs) {
		// TODO: build query
		$projection;
		if(is_array($columns)){
			$projection = join(',', $columns);
		} else {
			$projection = '*';
		}
		$sources;
		if(is_array($tables)){
			$sources = join ( ' JOIN ', $tables);
		} else {
			$tableList = array ('users','userroles','locations','locationroles');
			$sources = join (' JOIN ', $tableList);
		}
		$selection = ' WHERE ';
		if(is_string($where) && $where != ""){
			if(is_array($whereargs)){
					
			} else {
				$selection = "";
			}
		} else {
			$selection = "";
		}
		$query = 'SELECT ' . $projection . ' FROM ' . $sources . $selection;
		return $result ( $this->mysqli->query ( $query ) );
	}
	public function insert(array $columns, $table, array $values){}
	public function update(array $columns,array $tables, $where,array $whereargs){}
	public function delete(array $columns,array $tables, $where,array $whereargs){}
	public function createDb($dbname, array $tables){}
}

?>