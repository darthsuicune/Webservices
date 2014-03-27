<?php
require_once('UsersProvider.php');

class UsersProviderImpl implements UsersProvider {
	var $dataStorage;
	public function __construct(DataStorage $dataStorage){
		$this->dataStorage = $dataStorage;
	}

	public function getUserFromEmail($email){
		
	}
	
	public function getUserFromAccessToken($accessToken){
	
	}
}