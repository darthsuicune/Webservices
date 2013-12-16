<?php
abstract class Response{
	const NO_ERROR = 0;
	const ERROR_NO_REQUEST = 1;
	const ERROR_WRONG_REQUEST = 2;
	const ERROR_WRONG_ACCESS_TOKEN = 3;
	const ERROR_NO_ACCESS_TOKEN = 4;
	const ERROR_ALREADY_HAS_ACCESS_TOKEN = 5;
	const ERROR_NO_LOGIN_INFORMATION = 6;
	const ERROR_WRONG_LOGIN_INFORMATION = 7;
}
class ErrorResponse extends Response {
	var $errorCode;
	var $errorMessage;
	
	public function __construct($errorCode) {
		http_response_code(400);
		$this->errorCode = $errorCode;
		switch ($errorCode) {
			case self::ERROR_NO_REQUEST :
				$this->errorMessage = "I'M ALIVE!!! (and you're wrong ~~)";
				break;
			case self::ERROR_WRONG_REQUEST :
				$this->errorMessage = "QUIETA PUTA! QUE TE HE VISTO!";
				break;
			case self::ERROR_WRONG_ACCESS_TOKEN :
				$this->errorMessage = "This Access Token is no longer valid.";
				break;
			case self::ERROR_NO_ACCESS_TOKEN :
				$this->errorMessage = "You haven't requested access yet, bitch!";
				break;
			case self::ERROR_ALREADY_HAS_ACCESS_TOKEN:
				$this->errorMessage = "Wait, wat?";
				break;
			case self::ERROR_NO_LOGIN_INFORMATION:
				$this->errorMessage = "Srsly?";
				break;
			case self::ERROR_WRONG_LOGIN_INFORMATION:
				$this->errorMessage = "You bastard!";
				break;
			default :
			    http_response_code(403);
				$this->errorMessage = "QUIETA PUTA! QUE TE HE VISTO ~~";
				break;
		}
	}
}
class LocationsResponse extends Response {
	var $locations;
	
	public function __construct($locations) {
		$this->locations = $locations;
	}
}
class LoginResponse extends Response {
	var $accessToken;
	var $locations;
	public function __construct($accessToken, $locations) {
		$this->accessToken = $accessToken;
		$this->locations = $locations;
	}
}