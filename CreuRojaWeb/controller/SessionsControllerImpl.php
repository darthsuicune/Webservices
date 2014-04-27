<?php
class SessionsControllerImpl implements SessionsController {

	var $dataStorage;

	public function __construct(DataStorage $dataStorage) {
		$this->dataStorage = $dataStorage;
	}

	public function createSession(User $user){
		session_start();
		$_SESSION[SessionsController::USER] = $user;
	}

	public function destroySession(){
		unset($_SESSION[SessionsController::USER]);
		session_destroy();
	}

	public function setLanguage($language = Strings::LANG_CATALAN){
		$_SESSION[SessionsController::LANGUAGE] = new Strings($language);
	}
}