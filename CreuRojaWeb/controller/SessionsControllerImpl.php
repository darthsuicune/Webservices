<?php
class SessionsControllerImpl implements SessionsController {
	
	var $dataStorage;
	
	public function __construct(DataStorage $dataStorage) {
		$this->dataStorage = $dataStorage;
	}
	
	public function createSession(User $user){
		$_SESSION[SessionsController::USER_OBJECT] = $user;
	}
	
	public function destroySession(){
		session_destroy();
	}
}