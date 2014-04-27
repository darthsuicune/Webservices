<?php
class UsersControllerImpl implements UsersController {
	var $usersProvider;
	
	public function __construct(UsersProvider $usersProvider) {
		$this->usersProvider = $usersProvider;
	}
	
	public function getUserFromEmail($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
			return false;
		}
		return $this->usersProvider->getUserFromEmail($email);
	}
	
	public function validateUserFromLoginData($email, $password){
		if((filter_var($email, FILTER_VALIDATE_EMAIL) == false) || (strlen($password) != 40)) {
			return false;
		}
		return $this->usersProvider->getUserFromLoginData($email, $password);
	}
	
	public function validateUserFromAccessToken($accessToken){
		if(strlen($accessToken) != 40) {
			return false;
		}
		return $this->usersProvider->getUserFromAccessToken($accessToken);
	}
	
	public function getUserList(array $roles = null){
		if(($roles == null) || (count($roles) == 0)) {
			return array();
		}
		return $this->usersProvider->getUserList($roles);
	}
} 