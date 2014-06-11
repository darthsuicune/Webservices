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
	const USERS_COLUMN_PASSWORD_RESET_TOKEN = "resettoken";
	const USERS_COLUMN_PASSWORD_RESET_TIME = "resettime";

	const ACCESS_TOKEN_TABLE_NAME = "accesstoken";
	const ACCESS_TOKEN_EMAIL = "user_id";
	const ACCESS_TOKEN_COLUMN_LOGIN_TOKEN = "token";

	const ROLE_SOCIAL = "social";
	const ROLE_SOCORROS = "socorros";
	const ROLE_SOCIAL_SOCORROS = "socialsocorros";
	const ROLE_MARITIMOS = "maritimos";
	const ROLE_ADMIN = "admin";
	const ROLE_SOCORROS_MARITIMOS = "socorrosmaritimos";
	const ROLE_REGISTER = "register";
}

class User {
	var $name;
	var $surname;
	var $role;
	var $email;
	var $accessToken;

	function __construct( $name, $surname, $role, $email, $accessToken){
		$this->name = $name;
		$this->role = $role;
		$this->email = $email;
		$this->accessToken = new AccessToken($accessToken);
	}

	public function getAllowedTypes(){
		$types = array();
		switch($this->role){
			case UsersContract::ROLE_SOCIAL_SOCORROS:
				$types[] = LocationsContract::TYPE_SOCIAL;
			case UsersContract::ROLE_SOCORROS:
				$this->addSocorros($types);
				break;
			case UsersContract::ROLE_SOCORROS_MARITIMOS:
				$this->addSocorros($types);
			case UsersContract::ROLE_MARITIMOS:
				$types[] = LocationsContract::TYPE_MARITIMO;
				break;
			case UsersContract::ROLE_SOCIAL:
				$types[] = LocationsContract::TYPE_SOCIAL;
				$types[] = LocationsContract::TYPE_ASAMBLEA;
				break;
			case UsersContract::ROLE_ADMIN:
				$this->addSocorros($types);
				$types[] = LocationsContract::TYPE_SOCIAL;
				$types[] = LocationsContract::TYPE_MARITIMO;
				break;
			case UsersContract::ROLE_REGISTER:
				// The register users don't see points
				break;
		}
		return $types;
	}

	function addSocorros(&$array){
		$array[] = LocationsContract::TYPE_ADAPTADAS;
		$array[] = LocationsContract::TYPE_ASAMBLEA;
		$array[] = LocationsContract::TYPE_BRAVO;
		$array[] = LocationsContract::TYPE_CUAP;
		$array[] = LocationsContract::TYPE_HOSPITAL;
		$array[] = LocationsContract::TYPE_NOSTRUM;
		$array[] = LocationsContract::TYPE_TERRESTRE;
		return $array;
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
			$subject = "Solicitud de recuperacion de contrasenya";
			$message = "Ha solicitado un cambio de contrasenya.
				
			Se le envia este correo para confirmar que ha sido usted y no un tercero."
			. "Este link expira tras pasar las 4 horas siguientes a su peticion. En caso ".
			"de que necesite mas tiempo, necesitara solicitarlo de nuevo: "
			. "<a href='http://voluntarios.tk/index.php?q=recoverPassword&email=$email&token=" . substr($token, 0, 30) ."'>Cambio de contrasenya</a>";
			echo "$message";
			//return mail($to, $subject, $message);
		} else {
			return false;
		}
		return true;
		
	}
	
	public static function generateToken($name, $surname, $role, $email){
		$accessToken = AccessToken::createAccessToken();
		$dbLayer = new DbLayer();
		if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
			$result = $dbLayer->insert(UsersContract::ACCESS_TOKEN_TABLE_NAME,
					array(
							UsersContract::ACCESS_TOKEN_EMAIL=>$email,
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
					UsersContract::USERS_COLUMN_PASSWORD_RESET_TOKEN=>sha1($currentTime));
			$table = UsersContract::USERS_TABLE_NAME;
			$where = UsersContract::USERS_COLUMN_E_MAIL . "=?";
			$whereArgs = array($email);
			$dbLayer->update($values, $table, $where, $whereArgs);
			return sha1($currentTime);
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

