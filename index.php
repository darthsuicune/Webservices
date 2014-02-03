<?php
/**
 * Documentation, License etc.
 *
 * @package Webserver
 */
include_once('User.php');
include_once('LocationsService.php');
include_once('LoginService.php');

// echo "\n" . "TEST" . "\n";

$index = new Index();
$index->getIndex();

class Index {
	const LOGIN_REQUEST = "login";
	const UPDATE_REQUEST = "update";
	const ADD_REQUEST = "addNew";
	const DELETE_REQUEST = "delete";
	const REGISTER_REQUEST = "register";
	const CHANGE_PASSWORD_REQUEST = "changePassword";
	const RECOVER_PASSWORD_REQUEST = "recoverPassword";
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
				case self::REGISTER_REQUEST:
					$this->handleRegisterRequest($user);
					break;
				case self::CHANGE_PASSWORD_REQUEST:
					$this->handlePasswordChangeRequest($user);
					break;
				case self::RECOVER_PASSWORD_REQUEST:
					$this->handlePasswordRecoverRequest($user);
					break;
				default:
					$this->showLoginForm();
					break;
			}
		} else if ($user) {
			$this->showMap($user);
		} else {
			$this->showLoginForm();
		}
	}

	function handleLoginRequest($user){
		setcookie(self::COOKIE_NAME, $user->accessToken->accessTokenString);
		if($user->role == UsersContract::ROLE_ADMIN){
			$this->showAdminPanel($user);
		} else if ($user) {
			$this->showMap($user);
		} else {
			$this->showLoginForm();
		}
	}

	function handleAddRequest($user){
		if($user && $user->role == UsersContract::ROLE_ADMIN){
			$values = $this->createLocationValues();
			if($values){
				LocationsService::addLocation($values);
			} else {
				$this->showErrorMessage("Can't add location");
			}
			$this->showAdminPanel($user);
		} else {
			$this->showLoginForm();
		}
	}

	function handleUpdateRequest($user, $id){
		if($user && $user->role == UsersContract::ROLE_ADMIN){
			$values = $this->createLocationValues();
			if($values){
				LocationsService::updateLocation($id, $values);
			} else {
				$this->showErrorMessage("Can't update location");
			}
			$this->showAdminPanel($user);
		} else {
			$this->showLoginForm();
		}
	}

	function handleDeleteRequest($user, $id){
		if($user && $user->role == UsersContract::ROLE_ADMIN){
			LocationsService::deleteLocation($id);
			$this->showAdminPanel($user);
		} else {
			$this->showLoginForm();
		}
	}

	function handleRegisterRequest($user) {
		if($user && ($user->role == UsersContract::ROLE_REGISTER
				|| $user->role == UsersContract::ROLE_ADMIN)) {
			if(isset($_POST)){
				include_once('Register.php');
				$register = new Register();
				echo $register->register($username, $password, $email, $roles);
			} else {
				//Show register webpage.
			}
		}
	}

	function handlePasswordChangeRequest($user) {
		if($user){
			if(isset($_POST)){
				include_once('Register.php');
				$register = new Register();
				echo $register->changePassword($email, $newPassword);
			} else {
				//Show password change webpage.
			}
		} else {
			$this->showLoginForm();
		}
	}

	function handlePasswordRecoverRequest($user){
		if(isset($_POST)){
			include_once('Register.php');
			$register = new Register();
			echo $register->recoverPassword($email);
		} else {
			//Show password recovery webpage.
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
		$where = UsersContract::USERS_COLUMN_USERNAME . "=? AND " .
				UsersContract::USERS_COLUMN_PASSWORD . "=?";
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
		if(!isset($_POST[LocationsContract::LOCATIONS_COLUMN_LATITUDE])){
			return false;
		}
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

	function showErrorMessage($message){
		echo "There was an error while processing your request: " . $message;
	}
}