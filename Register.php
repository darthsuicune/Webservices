<?php
class Register {
	public function registerUser($password, $email, $roles, $name, $surname){
		if($this->isValidData($name . "." . $surname, $password, $email, $roles)){
			return $this->createUser($name . "." . $surname, $password, $email, $roles);
		} else {
			return false;
		}
	}

	public function recoverPassword($email){
		$user = $this->isValidEmail();
		if($user){
			return $user->createNewPassword();
		} else {
			return $this->incorrectData();
		}
	}

	public function changePassword($email, $newPassword){
		$user = $this->isValidEmail();
		if($user){
			return $user->changePassword($newPassword);
		} else {
			return $this->incorrectData();
		}
	}

	function createUser($username, $password, $email, $role){
		require_once('DbLayer.php');
		$dbLayer = new DbLayer();
		$dbLayer->connect();
		$values = array (
			UsersContract::USERS_COLUMN_USERNAME=>$username,
			UsersContract::USERS_COLUMN_PASSWORD=>$password,
			UsersContract::USERS_COLUMN_E_MAIL=>$email,
			UsersContract::USERS_COLUMN_ROLE=>$role
		);
		return $dbLayer->insert(UsersContract::USERS_TABLE_NAME, $values);
		
	}

	function isValidData($username, $password, $email, $roles){
		if($username == "" || $username == null || strlen($username) < 3) {
			return false;
		}

		if($password == "" || $password == null) {
			return false;
		}
		if($email == "" || $email == null || (!$this->isValidEmail($email))) {
			return false;
		}
		if($roles == "" || $roles == null || (!$this->isValidRole($roles))) {
			return false;
		}
		return true;
	}

	function isValidEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	function isValidRole($roles){
		return ($roles == UsersContract::ROLE_MARITIMOS 
				|| $roles == UsersContract::ROLE_SOCIAL
				|| $roles == UsersContract::ROLE_SOCIAL_SOCORROS
				|| $roles == UsersContract::ROLE_SOCORROS
				|| $roles == UsersContract::ROLE_SOCORROS_MARITIMOS);
	}
}