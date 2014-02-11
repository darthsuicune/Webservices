<?php
class Register {
	public function registerUser($username, $password, $email, array $roles){
		if($this->isValidData($username, $password, $email, $roles)){
			return $this->createUser($username, $password, $email, $this->getRole($roles));
		} else {
			return $this->incorrectData();
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

	function incorrectData(){
		return "ERROR";
	}

	function createUser($username, $password, $email, $role){
		require_once('DbLayer.php');
		$dbLayer = new DbLayer();
		$values = array (
			UsersContract::USERS_COLUMN_USERNAME=>$username,
			UsersContract::USERS_COLUMN_PASSWORD=>$password,
			UsersContract::USERS_COLUMN_E_MAIL=>$email,
			UsersContract::USERS_COLUMN_ROLE=>$role
		);
		$dbLayer->insert(UsersContract::USERS_TABLE_NAME, $values);
	}

	function getRole(array $roles){
		if(count($roles) == 1 ){
			return $roles[0];
		} else if (count($roles) == 2) {
			
		}
	}

	function isValidData($username, $password, $email, array $roles){
		if($username == "" || $username == null || strlen($username) < 3) {
			return false;
		}

		if($password == "" || $password == null || $password == User::generateHash("")) {
			return false;
		}
		if($email == "" || $email == null || (!$this->isValidEmail($email))) {
			return false;
		}
		return true;
	}

	function isValidEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
}