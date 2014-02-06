<?php
require_once('LoginProvider.php');

interface WebService {
	public function requestAccess($username, $password);
	public function changePassword($user);
	public function recoverPassword($user);
	public function getLastUpdates($user, $lastUpdateTime);
	public function getFullLocationList($user);
}

class CreuRojaWebService implements WebService {
	const ACCESS_REQUEST = "";
	const PASSWORD_CHANGE_REQUEST = "";
	const PASSWORD_RECOVERY_REQUEST = "";
	const LAST_UPDATES_REQUEST = "";
	const LOCATION_LIST_REQUEST = "";
	
	var $mClientType;
	var $mLoginProvider;
	
	public function __construct(ClientType $clientType, LoginProvider $loginProvider){
		$this->mClientType = $clientType;
		$this->mLoginProvider = $loginProvider;		
	}
	
	public function requestAccess($username, $password){
		
	}
	public function changePassword($user){
		
	}
	public function recoverPassword($user){
		
	}
	public function getLastUpdates($user, $lastUpdateTime){
		
	}
	public function getFullLocationList($user){
		
	}
	
}

abstract class ClientType {
	const ANDROID = 0;
	const WEB = 1;
}