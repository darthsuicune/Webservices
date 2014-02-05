<?php
require_once('LoginProvider.php');
require_once('LocationsProvider.php');

$androidConnection = new WebService();

class CreuRojaWebService implements WebService {
	const ACCESS_REQUEST = "";
	const PASSWORD_CHANGE_REQUEST = "";
	const PASSWORD_RECOVERY_REQUEST = "";
	const LAST_UPDATES_REQUEST = "";
	const LOCATION_LIST_REQUEST = "";
	
	var $clientType;
	
	var $loginProvider;
	var $locationsProvider;
	
	public function __construct(ClientType $clientType){
		$this->mClientType = $clientType;
	}
	
	public function requestAccess(){
		
	}
	public function changePassword(){
		
	}
	public function recoverPassword(){
		
	}
	public function getLastUpdates(){
		
	}
	public function getFullLocationList(){
		
	}
	
}

abstract class ClientType {
	const ANDROID = 0;
	const WEB = 1;
}

interface LoginProvider {
	
}

interface LocationsProvider {
	
}