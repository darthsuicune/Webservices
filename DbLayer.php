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
	public function __construct($address = self::DB_ADDRESS, $username = self::DB_USERNAME, 
			$password = self::DB_PASSWORD, $database = self::DB_DATABASE) {
		$this->dbAddress = $address;
		$this->dbUsername = $username;
		$this->dbPassword = $password;
		$this->dbDatabase = $database;
	}
	function connect() {
		$mysqli = new mysqli ( $this->dbAddress, $this->dbUsername, $this->dbPassword, 
				$this->dbDatabase );
		if ($mysqli->connect_errno) {
			echo "Connection failed: " . $mysqli->connect_error;
		} else {
			return $mysqli;
		}
	}
	
	/**
	 * Methods for checking user values
	 */
	const DB_FIELD_USERNAME = 'username';
	const DB_FIELD_PASSWORD = 'password';
	const DB_SELECT_USER_QUERY = 'SELECT * FROM users WHERE ';
	public function isValidUser($username, $password) {
		$mysqli = $this->connect ();
		$result = $mysqli->query ( 
				self::DB_SELECT_USER_QUERY . self::DB_FIELD_USERNAME . '=\'' . $username . '\' AND ' .
						 self::DB_FIELD_PASSWORD . '=\'' . $password . '\'' );
		if ($result == false) {
			return false;
		}
		$res = $result->field_count;
		$result->close ();
		$mysqli->close ();
		return $res > 0;
	}
	const DB_GET_USER_ROLES_QUERY = 'SELECT * FROM userroles WHERE ';
	public function getUserRoles($username) {
		// $mysqli = $this->connect ();
		// $result = $mysqli->query ( '' );
		$result = array ('Maritimo','Terrestre','Admin' 
		);
		// $result->close();
		// $mysqli->close();
		return $result;
	}
	
	/**
	 *
	 * @return array with the locations.
	 */
	const DB_SELECT_LOCATIONS_QUERY = 'SELECT * FROM locations WHERE ';
	public function retrieveFromDb($userDetails) {
		// $mysqli = $this->connect ();
		// $result = $mysqli->query ( '' );
		$result;
		if ($userDetails [Webserver::LAST_UPDATE_TIME_PARAM] == 0) {
			$result = array ("This","is","a","new","petition" 
			);
		} else {
			$result = array ("But","this","is","old" 
			);
		}
		// $result->close();
		// $mysqli->close();
		return $result;
	}
	function query($mysqli,array $columns,array $tables, $where,array $whereargs) {
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
		$selection;
		if(is_array($whereargs)){
			
		} else {
			
		}
		$query = 'SELECT ' . $projection . ' FROM ' . $sources . ' WHERE '. $selection;
		return $result ( $mysqli->query ( $query ) );
	}
}

?>