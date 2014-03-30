<?php

class WebClient implements Client {
	const REQUEST_LOGIN = "login";
	const REQUEST_UPDATE_LOCATION = "update";
	const REQUEST_ADD_LOCATION = "addNew";
	const REQUEST_DELETE_LOCATION = "delete";
	const REQUEST_REGISTER = "register";
	const REQUEST_CHANGE_PASSWORD = "changePassword";
	const REQUEST_RECOVER_PASSWORD = "recoverPassword";
	const REQUEST_TYPE = "q";

	const PARAMETER_NAME = "name";
	const PARAMETER_SURNAME = "surname";
	const PARAMETER_PASSWORD = "password";
	const PARAMETER_CONFIRM_PASSWORD = "confirmpass";
	const PARAMETER_OLD_PASSWORD = "oldpassword";
	const PARAMETER_EMAIL = "email";
	const PARAMETER_ROLES = "roles";
	const PARAMETER_TOKEN = "token";

	const COOKIE_NAME = "accessToken";

	var $usersController;
	var $locationsController;
	var $sessionsController;

	public function __construct(UsersController $usersController,
			LocationsController $locationsController,
			SessionsController $sessionsController){
		$this->usersController = $usersController;
		$this->locationsController = $locationsController;
		$this->sessionsController = $sessionsController;
	}

	public function handleRequest() {
		$request[0] = false;
		if(isset($_GET[self::REQUEST_TYPE])){		
			$request = explode("/", $_GET[self::REQUEST_TYPE]);
		}
		switch($request[0]){
			case self::REQUEST_LOGIN:
				$this->handleLoginRequest();
				break;
			case self::REQUEST_UPDATE_LOCATION:
				$this->handleLocationUpdateRequest();
				break;
			case self::REQUEST_ADD_LOCATION:
				$this->handleLocationAddRequest();
				break;
			case self::REQUEST_DELETE_LOCATION:
				$this->handleLocationDeleteRequest();
				break;
			case self::REQUEST_REGISTER:
				$this->handleRegisterRequest();
				break;
			case self::REQUEST_CHANGE_PASSWORD:
				$this->handlePasswordChangeRequest();
				break;
			case self::REQUEST_RECOVER_PASSWORD:
				$this->handlePasswordRecoverRequest();
				break;
			default:
				$this->showRoot();
				break;

		}
	}

	function handleLoginRequest(){

	}
	function handleLocationUpdateRequest(){

	}
	function handleLocationAddRequest(){

	}
	function handleLocationDeleteRequest(){

	}
	function handleRegisterRequest(){

	}
	function handlePasswordChangeRequest(){

	}
	function handlePasswordRecoverRequest(){

	}
	function showRoot(){

	}
}