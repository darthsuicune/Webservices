<?php
class LocationsService {
	const ERROR_INVALID_CREDENTIALS = 1;
	const ERROR_NO_USERNAME_PROVIDED = 2;
	const ERROR_NO_PASSWORD_PROVIDED = 3;
	const LAST_UPDATE_TIME_PARAM = 'last_update';
// 	var $dbLayer;
	
	public function getLocations() {
		$userRoles = $this->getUserRoles();
		//TODO: Build JSON object
		return getLocationList($userRoles);
	}
	
	private function getUserRoles(){
		
	}
	
	private function getLocationList($userRoles){
		
	}
	
	
	
	
	
	
	
	
	
	public function placeHolder() {
		include_once 'DbLayer.php';
		
// 		if ($this->hasDbConnectionData ()) {
// 			$this->dbLayer = new DbLayer ( $this->getDbAddress (), $this->getDbUser (), 
// 					$this->getDbPass (), $this->getDbName () );
// 		} else {
// 			$this->dbLayer = new DbLayer ();
// 		}
		
		// TODO: Uncomment for production.
		// if(isset ( $_POST [DbLayer::DB_FIELD_USERNAME] )) {
		// $username = $_POST [DbLayer::DB_FIELD_USERNAME];
		// } else {
		// $this->error(self::ERROR_NO_USERNAME_PROVIDED);
		// return;
		// }
		// if(isset ( $_POST [DbLayer::DB_FIELD_PASSWORD] )) {
		// $password = $_POST [DbLayer::DB_FIELD_PASSWORD];
		// } else {
		// $this->error(self::ERROR_NO_PASSWORD_PROVIDED);
		// return;
		// }
		//
		// if ($this->dbLayer->isValidUser ( $username, $password )) {
		if ($this->dbLayer->isValidUser ( 'testuser', 'pass' )) {
			$userDetails = $this->getUserParameters ( $username );
			return $this->createJsonAnswer ( $userDetails );
		} else {
			return $this->error ( self::ERROR_INVALID_CREDENTIALS );
		}
	}
	function getUserParameters($username) {
		$lastupdate = (isset ( $_GET [self::LAST_UPDATE_TIME_PARAM] )) ? $_GET [self::LAST_UPDATE_TIME_PARAM] : 0;
		return array (
				self::LAST_UPDATE_TIME_PARAM => $lastupdate,
				self::USER_ROLES_PARAM => $this->dbLayer->getUserRoles ( $username ) 
		);
	}
	function createJsonAnswer($userDetails) {
		return '[{' . join ( "},{", $this->dbLayer->retrieveFromDb ( $userDetails ) ) . "}]\n";
	}
	
	/**
	 * Convenience method for displaying error codes
	 *
	 * @param int $errorCode
	 *        	defined in Webserver.php as constants ERROR_*
	 */
	function error($errorCode) {
		switch ($errorCode) {
			case self::ERROR_INVALID_CREDENTIALS :
				return "Invalid credentials, you fucker...";
			case self::ERROR_NO_USERNAME_PROVIDED :
				return "What did you expect without a username?";
			case self::ERROR_NO_USERNAME_PROVIDED :
				return "No password, no goodies";
			default :
				break;
		}
	}
	/**
	 * This functions should retrieve the parameters from wherever they are stored.
	 * Return nothing if no parameter is stored to use the defaults.
	 */
	function hasDbConnectionData() {
		return false;
	}
	function getDbAddress() {
		return;
	}
	function getDbUser() {
		return;
	}
	function getDbPass() {
		return;
	}
	function getDbName() {
		return;
	}
}