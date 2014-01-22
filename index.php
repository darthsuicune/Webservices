<?php
/**
 * Documentation, License etc.
 *
 * @package Webserver
 */

$index = new Index();
$user = $index->getUserDetails();
if($user){
	$index->showMap($user);
} else {
	$index->showLoginForm();
}

class Index {
	const LOGIN_REQUEST = "login";
	const REQUEST_TYPE = "q";
	const USERNAME = "username";
	const PASSWORD = "password";

	public function showMap(){
		include_once('Map.php');
		$map = new Map();
		$response = $map->parseRequest($user);
		echo $response;
	}

	public function getUserDetails(){
		$user = $this->getFromCookies();
		if($user == null) {
			$user = $this->getFromForm();
		}
		return $user;
	}

	function getFromCookies(){
		return null;
	}

	function getFromForm(){
		if(!isset($_POST[self::USERNAME]) || $_POST[self::USERNAME] == ""){
			$this->showLoginForm();
			return;
		}
		if(!isset($_POST[self::PASSWORD]) || $_POST[self::PASSWORD] == ""){
			$this->showLoginForm();
			return;
		}
		return $this->performLogin($_POST[self::USERNAME], $_POST[self::PASSWORD]);
	}
	function showLoginForm(){
		include_once 'login.html';

	}

	function performLogin($username, $password){
		include_once('User.php');
		include_once('LoginService.php');
		if($username == null || $username == "" || $password == null || $password == ""){
			return null;
		}
		$projection = array(
				UsersContract::USERS_COLUMN_USERNAME,
				UsersContract::USERS_COLUMN_E_MAIL,
				UsersContract::USERS_COLUMN_ROLE
		);
		$tables = array(UsersContract::USERS_TABLE_NAME);
		$where = UsersContract::USERS_COLUMN_USERNAME . "=% AND " .
				UsersContract::USERS_COLUMN_PASSWORD . "=%";
		echo $password;
		$whereargs = array($username,sha1($password));
		$row = LoginService::getUserData($projection, $tables, $where, $whereargs);
		if($row != null){
			echo "PASSED!";
			return User::createWebUser($row[UsersContract::USERS_COLUMN_USERNAME],
					$row[UsersContract::USERS_COLUMN_ROLE],
					$row[UsersContract::USERS_COLUMN_E_MAIL]);
		} else {
			echo "FAILED! $username ".sha1($password);
			return null;
		}
	}


}

// echo "\n" . "TEST" . "\n";
// include_once ('DbLayer.php');
// include_once('Location.php');
// $columns = array ();
// $tables = array (LocationsContract::LOCATIONS_TABLE_NAME);
// $where = LocationsContract::LOCATIONS_COLUMN_TYPE . "=%";
// $whereargs = array ('cuap');

// $dbLayer = new DbLayer ();
// $dbLayer->connect ();
// $result = $dbLayer->query ( $columns, $tables, $where, $whereargs );
// if (result != null) {
// 	while ($row = $result->fetch_assoc()) {
// 		echo json_encode(new Location($row)) . "\n";
// 		echo json_last_error() . "\n";
// 	}
// }
// $dbLayer->close ();
