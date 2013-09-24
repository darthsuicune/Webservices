<?php
class AccessTokenProvider {
	const TOKEN_REQUEST = 1;
	const TOKEN_VALIDATION = 2;
	const PARAMETER_ACCESS_TOKEN = "access_token";
	public function getAccessToken() {
		if ($this->hasValidCredentials ()) {
			return $this->createAccessToken ();
		} else {
			return $this->invalidUserCredentials ( self::TOKEN_REQUEST );
		}
	}
	public static function validateAccessToken() {
		if (self::isValidToken ()) {
			return true;
		} else {
			return self::invalidUserCredentials ( self::TOKEN_VALIDATION );
		}
	}
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
				break;
			case self::TOKEN_VALIDATION :
				break;
			default :
				break;
		}
	}
}