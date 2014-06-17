<?php

class AndroidClient {
	const REQUEST_TYPE = 'q';
	const REQUEST_LOCATIONS = 'get_locations';
	const REQUEST_ACCESS = 'request_access';

	const PARAMETER_EMAIL = "email";
	const PARAMETER_PASSWORD = "password";
	const PARAMETER_ACCESS_TOKEN = "access_token";
	const PARAMETER_LAST_UPDATE_TIME = 'last_update';
	
	var $usersController;
	var $locationsController;
	
	public function __construct(UsersController $usersController,
			LocationsController $locationsController){
		$this->usersController = $usersController;
		$this->locationsController = $locationsController;
	}
}