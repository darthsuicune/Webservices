<?php
class AccessTokenProvider {
	const TOKEN_REQUEST = 1;
	const TOKEN_VALIDATION = 2;
	const PARAMETER_ACCESS_TOKEN = "access_token";
	const TOKEN_ERROR_INVALID_USER_CREDENTIALS = 0;
	/**
	 * 
	 */
	public function getAccessToken($user, $pass) {
		if ($this->hasValidCredentials ($user, $pass)) {
			return $this->createAccessToken ($user);
		} else {
			return $this->invalidUserCredentials ( self::TOKEN_REQUEST );
		}
	}
	/**
	 * 
	 * @return boolean
	 */
	public function validateAccessToken($token) {
		//1-Check if the token is still in the DB
		return true;
	}
	/**
	 * 
	 */
	private function createAccessToken($user) {
		//1-Create random crap
		//2-Store random crap in DB related to the user
		//3-Return random crap to user as Access Token
	}
	private function hasValidCredentials($user,$pass) {
		//1-Validate user and password against DB
		return true;
	}
	private function invalidUserCredentials($action) {
		switch ($action) {
			case self::TOKEN_REQUEST :
				return "";
			case self::TOKEN_VALIDATION :
				return "";
			default :
				return "";
		}
	}
	
	/**
	 * Methods for checking user values
	 */
	const DB_FIELD_USERNAME = 'username';
	const DB_FIELD_PASSWORD = 'password';
	const DB_SELECT_USER_QUERY = 'SELECT * FROM users WHERE ';
	public function isValidUser($username, $password) {
		$mysqli = $this->connect ();
		$result = $mysqli->query ( 
				self::DB_SELECT_USER_QUERY . self::DB_FIELD_USERNAME . '=\'' . $username . '\' AND ' .
						 self::DB_FIELD_PASSWORD . '=\'' . $password . '\'' );
		if ($result == false) {
			return false;
		}
		$res = $result->field_count;
		$result->close ();
		$mysqli->close ();
		return $res > 0;
	}
}