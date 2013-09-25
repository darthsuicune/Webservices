<?php
class AccessTokenProvider {
	const TOKEN_REQUEST = 1;
	const TOKEN_VALIDATION = 2;
	const PARAMETER_ACCESS_TOKEN = "access_token";
	/**
	 * 
	 */
	public function getAccessToken() {
		if ($this->hasValidCredentials ()) {
			return $this->createAccessToken ();
		} else {
			return $this->invalidUserCredentials ( self::TOKEN_REQUEST );
		}
	}
	/**
	 * 
	 * @return string Empty string if AccessToken is not valid. Username otherwise.
	 */
	public static function validateAccessToken() {
		if (self::isValidToken ()) {
			return "hola!";
		} else {
			return self::invalidUserCredentials ( self::TOKEN_VALIDATION );
		}
	}
	/**
	 * 
	 */
	private function createAccessToken() {
	}
	private function hasValidCredentials() {
	}
	private static function isValidToken() {
		return true;
	}
	private static function invalidUserCredentials($action) {
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