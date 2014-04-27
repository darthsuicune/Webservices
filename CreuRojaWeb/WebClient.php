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
	var $root;

	public function __construct(UsersController $usersController,
			LocationsController $locationsController,
			SessionsController $sessionsController,
			Root $root){
		$this->usersController = $usersController;
		$this->locationsController = $locationsController;
		$this->sessionsController = $sessionsController;
		$this->root = $root;
	}

	public function showDefaultView(User $user, Notice $notice = null) {
		$this->root->showRoot($user->getDefaultView(), $notice);
	}

	public function showLogin(Notice $notice = null) {
		$content = new Login();
		$this->root->showRoot($content, $notice);
	}

	public function showMap() {
		$content = new Map();
		$this->root->showRoot($content);
	}

	public function showAbout() {
		$content = new About();
		$this->root->showRoot($content);
	}

	public function showContact() {
		$content = new Contact();
		$this->root->showRoot($content);
	}

	public function handleLoginRequest(){
		if(isset($_POST[self::PARAMETER_EMAIL])
				&& isset($_POST[self::PARAMETER_PASSWORD])) {
			$email = $_POST[self::PARAMETER_EMAIL];
			$password = sha1($_POST[self::PARAMETER_PASSWORD]);
			$user = $this->usersController->validateUserFromLoginData($email, $password);
			if($user) {
				$this->sessionsController->createSession($user);
				$this->root->setUser($user);
				$this->showDefaultView($user);
			} else {
				$errors = new Notice(array(Notice::NOTICE_TYPE_ERROR,
						$_SESSION[SessionsController::LANGUAGE]->get(Strings::ERROR_INVALID_LOGIN)));
				$this->showLogin($errors);
			}
		} else {
			$this->showLogin();
		}
	}

	public function handleLogoutRequest(){
		$notice = null;
		if (isset($_SESSION[SessionsController::USER])) {
			$notice = new Notice(array(Notice::NOTICE_TYPE_NOTICE,
					$_SESSION[SessionsController::LANGUAGE]->get(Strings::LOGOUT_MESSAGE)));
		}
		$this->sessionsController->destroySession();
		$this->root->setUser();
		$this->showLogin($notice);
	}

	public function handleLocationAddRequest(){
		if($this->checkLocationValues()) {
		}
		return $this->root->showRoot();
	}

	public function handleLocationUpdateRequest($id){
		if(!$this->checkLocationValues()
				|| !$this->isCleanId($id)) {
		}
		return $this->root->showRoot();
	}

	public function handleLocationDeleteRequest($id){
		if($this->isCleanId($request[1])) {
		}
		return $this->root->showRoot();
	}

	public function handleRegisterRequest(){
		return $this->root->showRoot();
	}

	public function handleUserManagementRequest() {
		return $this->root->showRoot();
	}

	public function handleLocationManagementRequest() {
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