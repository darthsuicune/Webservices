<?php
class Register {
	public function registerUser($password, $email, $roles, $name, $surname){
		if($this->isValidData($name, $surname, $password, $email, $roles)){
			return $this->createUser($name, $surname, $password, $email, $roles);
		} else {
			return false;
		}
	}

	public function recoverPassword($email){
		$loginService = new LoginService();
		$user = $loginService->getUserFromEmail($email);
		if($user){
			return $user->createNewPassword($email);
		} else {
			return $this->incorrectData();
		}
	}

	public function changePassword($email, $oldPassword, $newPassword){
		$user = $this->isValidEmail($email, $oldPassword);
		if($user){
			return $user->changePassword($newPassword);
		} else {
			return $this->incorrectData();
		}
	}

	function createUser($name, $surname, $password, $email, $role){
		require_once('DbLayer.php');
		$dbLayer = new DbLayer();
		if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL) {
			$values = array (
					UsersContract::USERS_COLUMN_NAME=>$name,
					UsersContract::USERS_COLUMN_SURNAME=>$surname,
					UsersContract::USERS_COLUMN_PASSWORD=>$password,
					UsersContract::USERS_COLUMN_E_MAIL=>$email,
					UsersContract::USERS_COLUMN_ROLE=>$role
			);
			return $dbLayer->insert(UsersContract::USERS_TABLE_NAME, $values);
		} 
		return false;

	}

	function isValidData($name, $surname, $password, $email, $roles){
		if($name == "" || $name == null || $surname == "" || $surname == null) {
			return false;
		}

		if($password == "" || $password == null) {
			return false;
		}
		if($email == "" || $email == null) {
			return false;
		}
		if($roles == "" || $roles == null || (!$this->isValidRole($roles))) {
			return false;
		}
		return true;
	}

	function isValidEmail($email, $password){
		$loginService = new LoginService();
		return $loginService->checkUser($email, $password);
	}
	
	function isValidRole($roles){
		return ($roles == UsersContract::ROLE_MARITIMOS
				|| $roles == UsersContract::ROLE_SOCIAL
				|| $roles == UsersContract::ROLE_SOCIAL_SOCORROS
				|| $roles == UsersContract::ROLE_SOCORROS
				|| $roles == UsersContract::ROLE_SOCORROS_MARITIMOS);
	}
	
	function incorrectData(){
		return "An error happened. No data available for such user.";
	}
}