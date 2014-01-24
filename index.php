<?php
/**
 * Documentation, License etc.
 *
 * @package Webserver
 */
include_once('User.php');
include_once('LocationsService.php');
include_once('LoginService.php');


$index = new Index();
$index->getIndex();

class Index {
	const LOGIN_REQUEST = "login";
	const UPDATE_REQUEST = "update";
	const ADD_REQUEST = "addNew";
	const DELETE_REQUEST = "delete";
	const REQUEST_TYPE = "q";
	const USERNAME = "username";
	const PASSWORD = "password";
	
	const COOKIE_NAME = "accessToken";

	public function getIndex(){
		$user = $this->getUserDetails();
		if($user && isset($_GET[self::REQUEST_TYPE])){
			$requestType = explode("/", $_GET[self::REQUEST_TYPE]);
			switch($requestType[0]){
				case self::LOGIN_REQUEST:
					$this->handleLoginRequest($user);
					break;
				case self::ADD_REQUEST:
					$this->handleAddRequest($user);
					break;
				case self::DELETE_REQUEST:
					$this->handleDeleteRequest($user, $requestType[1]);
					break;
				case self::UPDATE_REQUEST:
					$this->handleUpdateRequest($user, $requestType[1]);
					break;
				default:
					$this->showLoginForm();
					break;
			}
		} else {
			$this->showLoginForm();
		}
	}
	
	function handleLoginRequest($user){
		setcookie(self::COOKIE_NAME, $user->accessToken->accessTokenString);
		if($user->role == UsersContract::ROLE_ADMIN){
			$this->showAdminPanel($user);
		} else {
			$this->showMap($user);
		}
	}
	
	function handleAddRequest($user){
		if($user && $user->role == UsersContract::ROLE_ADMIN){
			$values = $this->createLocationValues();
			if($values){
				LocationsService::addLocation($values);
			}
			$this->showAdminPanel($user);
		}
	}
	
	function handleDeleteRequest($user, $id){
		if($user && $user->role == UsersContract::ROLE_ADMIN){
			LocationsService::deleteLocation($id);
			$this->showAdminPanel($user);
		}
	}
	
	function handleUpdateRequest($user, $id){
		if($user && $user->role == UsersContract::ROLE_ADMIN){
			$values = $this->createLocationValues();
			if($values){
				LocationsService::updateLocation($id, $values);
			}
			$this->showAdminPanel($user);
		}
	}

	function showAdminPanel($user){
		include_once('AdminPanel.php');
		$adminPanel = new AdminPanel();
		echo $adminPanel->getAdminPanel($user);

	}

	function showMap($user){
		include_once('Map.php');
		$map = new Map();
		echo $map->parseRequest($user);
	}

	function getUserDetails(){
		$user = $this->getUserFromCookies();
		if($user == null) {
			$user = $this->getUserFromForm();
		}
		return $user;
	}

	function showLoginForm(){
		include_once 'login.html';
	}

	function getUserFromCookies(){
		$user = null;
		if(isset($_COOKIE[self::COOKIE_NAME])){
			$loginService = new LoginService();
			$user = $loginService->validateAccessToken($_COOKIE[self::COOKIE_NAME]);
		}
		return $user;
	}

	function getUserFromForm(){
		if(!isset($_POST[self::USERNAME]) || $_POST[self::USERNAME] == ""){
			$this->showLoginForm();
			return;
		}
		if(!isset($_POST[self::PASSWORD]) || $_POST[self::PASSWORD] == ""){
			$this->showLoginForm();
			return;
		}
		$loginService = new LoginService();
		return $loginService->checkUser($_POST[self::USERNAME], sha1($_POST[self::PASSWORD]));
	}

	function performLogin($username, $password){
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
		$whereargs = array($username,$password);
		$row = LoginService::getUserData($projection, $tables, $where, $whereargs);
		if($row != null){
			return User::createWebUser($row[UsersContract::USERS_COLUMN_USERNAME],
					$row[UsersContract::USERS_COLUMN_ROLE],
					$row[UsersContract::USERS_COLUMN_E_MAIL]);
		} else {
			return null;
		}
	}

	function createLocationValues(){
		$values = array();
		$values[LocationsContract::LOCATIONS_COLUMN_LATITUDE] = $_POST[LocationsContract::LOCATIONS_COLUMN_LATITUDE];
		$values[LocationsContract::LOCATIONS_COLUMN_LONGITUDE] = $_POST[LocationsContract::LOCATIONS_COLUMN_LONGITUDE];
		$values[LocationsContract::LOCATIONS_COLUMN_NAME] = $_POST[LocationsContract::LOCATIONS_COLUMN_NAME];
		$values[LocationsContract::LOCATIONS_COLUMN_TYPE] = $_POST[LocationsContract::LOCATIONS_COLUMN_TYPE];
		if(isset($_POST[LocationsContract::LOCATIONS_COLUMN_OTHER])){
			$values[LocationsContract::LOCATIONS_COLUMN_ADDRESS] = $_POST[LocationsContract::LOCATIONS_COLUMN_ADDRESS];
		}
		if(isset($_POST[LocationsContract::LOCATIONS_COLUMN_ADDRESS])){

			$values[LocationsContract::LOCATIONS_COLUMN_OTHER] = $_POST[LocationsContract::LOCATIONS_COLUMN_OTHER];
		}
		$values[LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED] = round(microtime(true) * 1000);
		if(isset($_POST[LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE]) 
				&& $_POST[LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE] > 0){
			date_default_timezone_set("Europe/Madrid");
			$values[LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE] = 
					strtotime($_POST[LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE]) * 1000;
		} else {
			$values[LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE] = "0";
				
		}
		return $values;
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
