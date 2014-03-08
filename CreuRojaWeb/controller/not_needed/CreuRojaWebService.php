<?php

class CreuRojaWebService implements WebService {
	const ACCESS_REQUEST = "";
	const PASSWORD_CHANGE_REQUEST = "";
	const PASSWORD_RECOVERY_REQUEST = "";
	const LAST_UPDATES_REQUEST = "";
	const LOCATION_LIST_REQUEST = "";

	var $loginProvider;

	public function __construct(LoginProvider $loginProvider){
		$this->loginProvider = $loginProvider;
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