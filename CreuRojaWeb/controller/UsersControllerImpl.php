<?php
class UsersControllerImpl implements UsersController {
	var $usersProvider;
	
	public function __construct(UsersProvider $usersProvider) {
		$this->usersProvider = $usersProvider;
	}
	
	public function validateUserFromLogin($email, $password){
		$this->usersProvider->getUserFromEmail($email);
	}
	public function validateUserFromAccessToken($accessToken){
		
	}
} 