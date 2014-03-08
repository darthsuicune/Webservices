<?php

class UsersProviderImpl implements UsersProvider {
	var $dataStorage;
	public function __construct(DataStorage $dataStorage){
		$this->dataStorage = $dataStorage;
	}

	public function validateUserInfo($email, $password) {

	}
	public function validateAccessToken($accessToken) {

	}
}