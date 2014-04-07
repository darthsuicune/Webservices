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
        $this->errorCode = $errorCode;
        switch ($errorCode) {
            case self::ERROR_NO_REQUEST :
                http_response_code(400);
                $this->errorMessage = "No hay peticion";
                break;
            case self::ERROR_WRONG_REQUEST :
                http_response_code(400);
                $this->errorMessage = "Peticion no disponible";
                break;
            case self::ERROR_WRONG_ACCESS_TOKEN :
                http_response_code(400);
                $this->errorMessage = "Access token invalido";
                break;
            case self::ERROR_NO_ACCESS_TOKEN :
                http_response_code(403);
                $this->errorMessage = "No hay access token";
                break;
            case self::ERROR_ALREADY_HAS_ACCESS_TOKEN:
                http_response_code(400);
                $this->errorMessage = "Ya tiene access token y solicita nuevo";
                break;
            case self::ERROR_NO_LOGIN_INFORMATION:
                http_response_code(403);
                $this->errorMessage = "Sin user ni pass";
                break;
            case self::ERROR_WRONG_LOGIN_INFORMATION:
                http_response_code(403);
                $this->errorMessage = "User y pass incorrecto";
                break;
            default :
                http_response_code(403);
            $this->errorMessage = "Wait, wat?";
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

class AccessResponse extends Response {
	var $isValid;
	public function __construct($isValid){
		$this->isValid = $isValid;
	}
}