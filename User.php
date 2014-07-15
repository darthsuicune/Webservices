<?php
include_once('Location.php');
class UsersContract {
	/**
	 * Users table
	 */
	const USERS_TABLE_NAME = "users";
	const USERS_COLUMN_ID = "id";
	const USERS_COLUMN_NAME = "name";
	const USERS_COLUMN_SURNAME = "surname";
	const USERS_COLUMN_PASSWORD = "password_digest";
	const USERS_COLUMN_E_MAIL = "email";
	const USERS_COLUMN_ROLE = "role";
	const USERS_COLUMN_ACTIVE = "active";
	const USERS_COLUMN_PASSWORD_RESET_TOKEN = "resettoken";
	const USERS_COLUMN_PASSWORD_RESET_TIME = "resettime";

	const ACCESS_TOKEN_TABLE_NAME = "sessions";
	const ACCESS_TOKEN_ID = "user_id";
	const ACCESS_TOKEN_COLUMN_LOGIN_TOKEN = "token";

	const ROLE_ADMIN = "admin";
	const ROLE_VOLUNTEER = "volunteer";
	const ROLE_TECHNICIAN = "technician";
}

class User {
	var $name;
	var $surname;
	var $role;
	var $email;
	var $accessToken;

	function __construct( $name, $surname, $role, $email, $accessToken){
		$this->name = $name;
		$this->surname = $surname;
		$this->role = $role;
		$this->email = $email;
		$this->accessToken = new AccessToken($accessToken);
	}

	public function changePassword($newPassword){
		$dbLayer = new DbLayer();
		if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL) {
			$password = password_hash($newPassword, PASSWORD_BCRYPT);
			$values = array(UsersContract::USERS_COLUMN_PASSWORD=>$password);
			$table = UsersContract::USERS_TABLE_NAME;
			$where = UsersContract::USERS_COLUMN_E_MAIL . "=?";
			$whereArgs = array($this->email);
			$dbLayer->update($values, $table, $where, $whereArgs);
			return true;
		}
		return false;
	}

	public function createNewPassword($email){
		$token = self::createPasswordValidationToken($email);
		if($token){
			$to = $email;
			$subject = "Sol·licitud de recuperació de contrasenya";
			$message = "Heu sol·licitat un canvi de contrasenya per al mapa de Creu Roja.
			
Se li envia aquest correu per confirmar que és vostè qui sol·licita el canvi de contrasenya. Aquest enllaç expira després de passar les 4 hores següents a la seva petició.

http://creuroja.net/index.php?q=recoverPassword&email=$email&token=" . substr($token, 0, 30) ."";
			$headers = 'From: 08000-Tècnics Socors Oficina Local de Barcelona <tecnicssocors@creuroja.org>' . "\r\n" .
				   'Reply-To: 08000-Tècnics Socors Oficina Local de Barcelona <tecnicssocors@creuroja.org>' . "\r\n";
			return mail($to, $subject, $message, $headers);
		} else {
			return false;
		}
		return true;
		
	}
	
	public static function generateToken($name, $surname, $role, $email, $id){
		$accessToken = AccessToken::createAccessToken();
		$dbLayer = new DbLayer();
		if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
			$result = $dbLayer->insert(UsersContract::ACCESS_TOKEN_TABLE_NAME,
					array(
							UsersContract::ACCESS_TOKEN_ID=>$id,
							UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN=>$accessToken->accessTokenString
					));
			return new User($name, $surname, $role, $email, $accessToken->accessTokenString);
		} else {
			return null;
		}
	}
	
	function createPasswordValidationToken($email){
		$dbLayer = new DbLayer();
		if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
			$currentTime = round(microtime(true) * 1000);
			$values = array(UsersContract::USERS_COLUMN_PASSWORD_RESET_TIME=>$currentTime,
					UsersContract::USERS_COLUMN_PASSWORD_RESET_TOKEN=>$currentTime);
			$table = UsersContract::USERS_TABLE_NAME;
			$where = UsersContract::USERS_COLUMN_E_MAIL . "=?";
			$whereArgs = array($email);
			$dbLayer->update($values, $table, $where, $whereArgs);
			return $currentTime;
		}
		return false;
	}
}

class AccessToken {
	var $accessTokenString;

	public function __construct($accessToken){
		$this->accessTokenString = $accessToken;
	}

	public function isValid() {
		return ($this->accessTokenString != null && $this->accessTokenString != "");
	}

	public static function createAccessToken(){
		//This method generates a random string.
		$token = new AccessToken(substr(sha1(microtime()), 0, 30));
		return $token;
	}
}

