<?php
/**
 * Documentation, License etc.
 *
 * @package Webserver
 */
include_once('User.php');
include_once('Log.php');
include_once('LocationsService.php');
include_once('LoginService.php');

$index = new Index();
$index->getIndex();


class Index {const LOGIN_REQUEST = "login";
	const UPDATE_REQUEST = "update";
	const ADD_REQUEST = "addNew";
	const DELETE_REQUEST = "delete";
	const REGISTER_REQUEST = "register";
	const CHANGE_PASSWORD_REQUEST = "changePassword";
	const RECOVER_PASSWORD_REQUEST = "recoverPassword";
	const REQUEST_TYPE = "q";
	const NAME = "name";
	const SURNAME = "surname";
	const PASSWORD = "password";
	const CONFIRM_PASS = "confirmpass";
	const OLD_PASSWORD = "oldpassword";
	const EMAIL = "email";
	const ROLES = "roles";
	const TOKEN = "token";

	const COOKIE_NAME = "accessToken";

	public function getIndex(){
		//Special case
		if(isset($_GET[self::REQUEST_TYPE]) && $_GET[self::REQUEST_TYPE] == self::RECOVER_PASSWORD_REQUEST){
			$this->handlePasswordRecoveryRequest();
		} else {
			$user = $this->getUserDetails();
				
			if($user && isset($_GET[self::REQUEST_TYPE])){
				Log::write($user, $_GET[self::REQUEST_TYPE]);
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
					default:
						$this->showLoginForm();
						break;
				}
			} else if ($user) {
				Log::write($user, "map");
				$this->showMap($user);
			} else {
				if(isset($_POST[self::EMAIL])) {
					Log::failWrite(null, "login for " . $_POST[self::EMAIL]);
				} else {
					Log::write(null, "view login");
				}
				$this->showLoginForm();
			}
		}
	}

	function handleLoginRequest(User $user = null){
		setcookie(self::COOKIE_NAME, $user->accessToken->accessTokenString);
		if($user) {
			if($user->role == UsersContract::ROLE_ADMIN){
				$this->showAdminPanel($user);
			} else if ($user->role == UsersContract::ROLE_REGISTER){
				$this->showRegister();
			} else {
				$this->showMap($user);
			}
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
			$this->showRegister();
		} else {
			$this->showLoginForm();
		}
	}

	function handlePasswordChangeRequest($user) {
		if($user){
			if(isset($_POST[self::EMAIL]) && isset($_POST[self::OLD_PASSWORD])
					&& isset($_POST[self::PASSWORD]) && isset($_POST[self::CONFIRM_PASS])
					&& strcmp($_POST[self::PASSWORD], $_POST[self::CONFIRM_PASS]) == 0){
				include_once('Register.php');
				$register = new Register();
				$newPassword = $_POST[self::PASSWORD];
				if($register->changePassword($email, $newPassword)){
					echo "Canvi de contrasenya completat amb èxit";
				} else {
					echo "Error en el canvi de contrasenya";
					require_once('changePassword.html');
				}
			}else {
				require_once('changePassword.html');
			}
		} else {
			$this->showLoginForm();
		}
	}
	
	function handlePasswordRecoveryRequest(){
		$loginService = new LoginService();
		if (isset($_GET[self::EMAIL]) && isset($_GET[self::TOKEN])){
			if($loginService->canResetPassword($_GET[self::EMAIL], $_GET[self::TOKEN])){
				require_once 'passRecover2.php';
			} else {
				echo "Your token has expired! Ask for one again";
				require_once('passRecover.html');
			}
		} else if (isset($_POST[self::PASSWORD]) && isset($_POST[self::CONFIRM_PASS])
				&& strcmp($_POST[self::PASSWORD], $_POST[self::CONFIRM_PASS]) == 0){
			if($loginService->updateUser($_POST[self::EMAIL], $_POST[self::PASSWORD])){
				echo "Canvi de contrasenya completat amb èxit";
			} else {
				echo "Error en el canvi de contrasenya";
			}
		} else if (isset($_POST[self::EMAIL])) {
			require_once('Register.php');
			$register = new Register();
			if($register->recoverPassword($_POST[self::EMAIL])){
				echo "An Email has been sent to your account";
			} else {
				echo "An error ocurred";
			}
		} else {
			require_once('passRecover.html');
		}
	}

	function showLoginForm(){
		require_once 'login.html';
	}

	function showAdminPanel($user){
		include_once('AdminPanel.php');
		$adminPanel = new AdminPanel();
		echo $adminPanel->getAdminPanel($user);
	}

	function showRegister(){
		//Second form passed already
		if(isset($_POST[self::EMAIL]) && isset($_POST[self::PASSWORD]) && isset($_POST[self::CONFIRM_PASS])) {
			if ($_POST[self::PASSWORD] == $_POST[self::CONFIRM_PASS]){
				include_once('Register.php');
				$register = new Register();
				$name = $_POST[self::NAME];
				$surname = $_POST[self::SURNAME];
				$password = password_hash($_POST[self::PASSWORD], PASSWORD_BCRYPT);
				$email = $_POST[self::EMAIL];
				$roles = $_POST[self::ROLES];
				if ($register->registerUser($password, $email, $roles, $name, $surname) === array()) {
					echo "Success!";
					require_once('register.html');
				} else {
					echo "Failure";
					require_once('register2.php');
				}
			} else {
				//Show register webpage.
				require_once('register2.php');
			}
			//First form passed, second not yet.
		} else if (isset($_POST[self::ROLES])) {
			require_once('register2.php');
		} else {
			require_once('register.html');
		}
	}

	function showMap($user){
		require_once('Map.php');
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

	function getUserFromCookies(){
		$user = null;
		if(isset($_COOKIE[self::COOKIE_NAME])){
			$loginService = new LoginService();
			$user = $loginService->validateAccessToken($_COOKIE[self::COOKIE_NAME]);
		}
		return $user;
	}

	function getUserFromForm(){
		if(!isset($_POST[self::EMAIL]) || $_POST[self::EMAIL] == ""){
			$this->showLoginForm();
			return;
		}
		if(!isset($_POST[self::PASSWORD]) || $_POST[self::PASSWORD] == ""){
			$this->showLoginForm();
			return;
		}
		$loginService = new LoginService();
		return $loginService->checkUser($_POST[self::EMAIL], $_POST[self::PASSWORD]);
	}

	function createLocationValues(){
		if(!isset($_POST[LocationsContract::LOCATIONS_COLUMN_LATITUDE])){
			return false;
		}
		$values = array();
		$values[LocationsContract::LOCATIONS_COLUMN_LATITUDE] =
		str_replace(",", ".", $_POST[LocationsContract::LOCATIONS_COLUMN_LATITUDE]);
		$values[LocationsContract::LOCATIONS_COLUMN_LONGITUDE] =
		str_replace(",", ".", $_POST[LocationsContract::LOCATIONS_COLUMN_LONGITUDE]);
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
