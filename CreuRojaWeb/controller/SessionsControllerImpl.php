<?php
class SessionsControllerImpl implements SessionsController {
	
	var $dataStorage;
	
	public function __construct(DataStorage $dataStorage) {
		$this->dataStorage = $dataStorage;
	}
	
	public function createSession(User $user){
		$_SESSION['user'] = $user;
	}
	
	public function destroySession(){
		session_destroy();
	}
}