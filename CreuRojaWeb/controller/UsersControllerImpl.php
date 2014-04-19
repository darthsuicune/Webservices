<?php
class UsersControllerImpl implements UsersController {
	var $usersProvider;
	
	public function __construct(UsersProvider $usersProvider) {
		
	}
	
	public function validateUserFromLogin($email, $password){
		
	}
	public function validateUserFromAccessToken($accessToken){
		
	}
} 