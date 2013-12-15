<?php
include_once ('DbLayer.php');
include_once ('Location.php');
class LocationsService {
	
	
	/**
	 *
	 * @param string $user        	
	 * @return multitype:
	 */
	public function getLocations($user, $lastUpdateTime) {
		// $dbLayer = new DbLayer();
		// $dbLayer->connect();
		// TODO: replace with actual DB search
		$result;
		if ($lastUpdateTime == 0) {
			$result = array (
					"This",
					"is",
					"a",
					"new",
					"petition" 
			);
		} else {
			$result = array (
					"But",
					"this",
					"is",
					"old" 
			);
		}
		return $result;
		// $dbLayer->close();
	}

	
	public function placeHolder() {
		
		// if ($this->hasDbConnectionData ()) {
		// $this->dbLayer = new DbLayer ( $this->getDbAddress (), $this->getDbUser (),
		// $this->getDbPass (), $this->getDbName () );
		// } else {
		// $this->dbLayer = new DbLayer ();
		// }
		
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
}