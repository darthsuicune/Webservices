<?php
require_once('DataStorage.php');

interface LoginProvider {
	public function validateUserInfo($username, $password);
	public function validateAccessToken($accessToken);
}

class LoginProviderImpl implements LoginProvider {
	var $mDataStorage;
	public function __construct(DataStorage $dataStorage){
		$this->mDataStorage = $dataStorage;
	}
	
	public function validateUserInfo($username, $password) {
		
	}
	public function validateAccessToken($accessToken) {
	
	}
}