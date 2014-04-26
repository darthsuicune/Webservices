<?php
class WebClient {
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
	var $lang;
	var $root;

	public function __construct(UsersController $usersController,
			LocationsController $locationsController,
			SessionsController $sessionsController,
			Strings $lang, Root $root){
		$this->usersController = $usersController;
		$this->locationsController = $locationsController;
		$this->sessionsController = $sessionsController;
		$this->lang = $lang;
		$this->root = $root;
	}

	public function showRoot() {
		return $this->root->showRoot(Root::LOGIN);
	}

	public function handleLoginRequest(){
		if(isset($_POST[self::PARAMETER_EMAIL])
				&& isset($_POST[self::PARAMETER_PASSWORD])) {
			$user = $this->usersController->validateUserFromLoginData(
					$_POST[self::PARAMETER_EMAIL],
					sha1($_POST[self::PARAMETER_PASSWORD]));
			if($user) {
				$this->sessionsController->createSession($user);
				$this->root->setUser($user);
				return $this->root->showRoot(Root::MAP);
			} else {
				$errors = array($this->lang->get(Strings::ERROR_INVALID_LOGIN));
				return $this->root->showRoot(Root::LOGIN, true, $errors);
				
			}
		}
		return $this->root->showRoot(Root::LOGIN);
	}

	public function handleLogoutRequest(){
		$this->sessionsController->destroySession();
		return $this->root->showRoot();
	}

	public function handleLocationAddRequest(){
		if($this->checkLocationValues()) {
			break;
		}
		return $this->root->showRoot();
	}

	public function handleLocationUpdateRequest($id){
		if(!$this->checkLocationValues()
				|| !$this->isCleanId($id)) {
			break;
		}
		return $this->root->showRoot();
	}

	public function handleLocationDeleteRequest($id){
		if($this->checkLocationValues()
				&& $this->isCleanId($request[1])) {
			return $this->handleLocationDeleteRequest($request[1]);
		}
		return $this->root->showRoot();
	}

	public function handleRegisterRequest(){
		if(isset($_POST[''])) {
			break;
		}
		return $this->root->showRoot();
	}

	public function handlePasswordChangeRequest(){
		if(isset($_POST[self::PARAMETER_OLD_PASSWORD])
				&& (isset($_POST[self::PARAMETER_PASSWORD]))
				&& (isset($_POST[self::PARAMETER_CONFIRM_PASSWORD]))) {
			break;
		}
		return $this->root->showRoot();
	}

	public function handlePasswordRecoverRequest(){
		if(isset($_POST[self::PARAMETER_EMAIL])) {
			break;
		}
		return $this->root->showRoot();
	}
	
	public function handleAboutRequest() {
		return $this->root->showRoot(Root::ABOUT);
	}
	
	public function handleContactRequest() {
		return $this->root->showRoot(Root::CONTACT);
	}

	function isCleanId($unsafeId) {
		return strcmp($unsafeId, mysql_real_escape_string($unsafeId)) == 0;
	}

	function checkLocationValues() {
		return ((isset($_POST[LocationsContract::COLUMN_ADDRESS]))
				&& (isset($_POST[LocationsContract::COLUMN_EXPIRE_DATE]))
				&& (isset($_POST[LocationsContract::COLUMN_ID]))
				&& (isset($_POST[LocationsContract::COLUMN_LAST_UPDATED]))
				&& (isset($_POST[LocationsContract::COLUMN_LATITUDE]))
				&& (isset($_POST[LocationsContract::COLUMN_LONGITUDE]))
				&& (isset($_POST[LocationsContract::COLUMN_NAME]))
				&& (isset($_POST[LocationsContract::COLUMN_OTHER]))
				&& (isset($_POST[LocationsContract::COLUMN_TYPE])));
	}
}