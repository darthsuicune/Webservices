<?php
class Register {
	public function registerUser($username, $password, $email, array $roles){
		if($this->isValidData($username, $password, $email)){
			
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
}