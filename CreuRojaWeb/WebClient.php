<?php

class WebClient implements Client {
	const REQUEST_LOGIN = "login";
	const REQUEST_LOGOUT = "logout";
	const REQUEST_UPDATE_LOCATION = "update";
	const REQUEST_ADD_LOCATION = "addNew";
	const REQUEST_DELETE_LOCATION = "delete";
	const REQUEST_REGISTER = "register";
	const REQUEST_CHANGE_PASSWORD = "changePassword";
	const REQUEST_RECOVER_PASSWORD = "recoverPassword";
	const REQUEST_TYPE = "q";

	const PARAMETER_NAME = "name";
	const PARAMETER_SURNAME = "surname";
	const PARAMETER_PASSWORD = "password";
	const PARAMETER_CONFIRM_PASSWORD = "confirmpass";
	const PARAMETER_OLD_PASSWORD = "oldpassword";
	const PARAMETER_EMAIL = "email";
	const PARAMETER_ROLES = "roles";
	const PARAMETER_TOKEN = "token";

	const COOKIE_NAME = "accessToken";

	var $usersController;
	var $locationsController;
	var $sessionsController;

	public function __construct(UsersController $usersController,
			LocationsController $locationsController,
			SessionsController $sessionsController){
		$this->usersController = $usersController;
		$this->locationsController = $locationsController;
		$this->sessionsController = $sessionsController;
	}

	public function handleRequest() {
		$request[0] = false;
		if(isset($_GET[self::REQUEST_TYPE])){
			$request = explode("/", $_GET[self::REQUEST_TYPE]);
		}
		if(isset($request[1])){
			switch($request[0]){
				case self::REQUEST_UPDATE_LOCATION:
					return $this->handleLocationUpdateRequest($request[1]);
				case self::REQUEST_DELETE_LOCATION:
					return $this->handleLocationDeleteRequest($request[1]);
					break;
				default:
					break;
			}
		} else {
			switch($request[0]){
				case self::REQUEST_LOGIN:
					return $this->handleLoginRequest();
				case self::REQUEST_LOGOUT:
					return $this->handleLogoutRequest();
				case self::REQUEST_ADD_LOCATION:
					return $this->handleLocationAddRequest();
				case self::REQUEST_REGISTER:
					return $this->handleRegisterRequest();
				case self::REQUEST_CHANGE_PASSWORD:
					return $this->handlePasswordChangeRequest();
				case self::REQUEST_RECOVER_PASSWORD:
					return $this->handlePasswordRecoverRequest();
				default:
					break;
			}
		}
		return $this->showRoot();
	}

	function handleLoginRequest(){
		if(isset($_POST[self::PARAMETER_EMAIL])
				&& isset($_POST[self::PARAMETER_PASSWORD])) {
			$user = $this->usersController->validateUserFromLogin(
					$_POST[self::PARAMETER_EMAIL], 
					$_POST[self::PARAMETER_PASSWORD]); 
			if($user) {
				$this->sessionsController->createSession($user);
				return $this->showMap();
			}
		}
		return $this->showRoot();
	}

	function handleLogoutRequest(){
		$this->sessionsController->destroySession();
		return $this->showRoot();
	}

	function handleLocationAddRequest(){
		if($this->checkLocationValues()) {
			break;
		}
		return $this->showRoot();
	}

	function handleLocationUpdateRequest($id){
		if(!$this->checkLocationValues()
				|| !$this->isCleanId($id)) {
			break;
		}
		return $this->showRoot();
	}

	function handleLocationDeleteRequest($id){
		if($this->checkLocationValues()
				&& $this->isCleanId($request[1])) {
			return $this->handleLocationDeleteRequest($request[1]);
		}
		return $this->showRoot();
	}

	function handleRegisterRequest(){
		if(isset($_POST[''])) {
			break;
		}
		return $this->showRoot();
	}

	function handlePasswordChangeRequest(){
		if(isset($_POST[self::PARAMETER_OLD_PASSWORD])
				&& (isset($_POST[self::PARAMETER_PASSWORD]))
				&& (isset($_POST[self::PARAMETER_CONFIRM_PASSWORD]))) {
			break;
		}
		return $this->showRoot();
	}

	function handlePasswordRecoverRequest(){
		if(isset($_POST[self::PARAMETER_EMAIL])) {
			break;
		}
		return $this->showRoot();
	}

	function showRoot(){
		require_once("view/login.php");
	}
	
	function showMap(){
		require_once("view/map.php");
	}

	function isCleanId($unsafeId) {
		return strcmp($unsafeId, mysql_real_escape_string($unsafeId)) == 0;
	}

	function checkLocationValues() {
		return ((isset($_POST[LocationsContract::COLUMN_ADDRESS]))
				&& (isset($_POST[LocationsContract::COLUMN_EXPIRE_DATE]))
				&& (isset($_POST[LocationsContract::COLUMN_ID]))
				&& (isset($_POST[LocationsContract::COLUMN_LAST_UPDATED]))
				&& (isset($_POST[LocationsContract::COLUMN_LATITUDE]))
				&& (isset($_POST[LocationsContract::COLUMN_LONGITUDE]))
				&& (isset($_POST[LocationsContract::COLUMN_NAME]))
				&& (isset($_POST[LocationsContract::COLUMN_OTHER]))
				&& (isset($_POST[LocationsContract::COLUMN_TYPE])));
	}
}