<?php
include_once('User.php');
include_once('DbLayer.php');
class LoginService {
	const TOKEN_REQUEST = 1;
	const TOKEN_VALIDATION = 2;
	const TOKEN_ERROR_INVALID_USER_CREDENTIALS = 0;
	/**
	 *
	 */
	public function checkUser($email, $password) {
		if($email == null || $email == "" || $password == null || $password == ""
				|| filter_var($email, FILTER_VALIDATE_EMAIL) == false){
			return null;
		}
		$projection = array(
				UsersContract::USERS_COLUMN_NAME,
				UsersContract::USERS_COLUMN_SURNAME,
				UsersContract::USERS_COLUMN_PASSWORD,
				UsersContract::USERS_COLUMN_E_MAIL,
				UsersContract::USERS_COLUMN_ROLE
		);
		$tables = array(UsersContract::USERS_TABLE_NAME);
		$where = UsersContract::USERS_COLUMN_E_MAIL . "=?";
		$whereargs = array($email);
		$user = $this->getUserData($projection, $tables, $where, $whereargs);
		if($user != null &&
				password_verify($password, $user[UsersContract::USERS_COLUMN_PASSWORD])){
			return User::generateToken($user[UsersContract::USERS_COLUMN_NAME],
					$user[UsersContract::USERS_COLUMN_SURNAME],
					$user[UsersContract::USERS_COLUMN_ROLE],
					$user[UsersContract::USERS_COLUMN_E_MAIL]);
		} else {
			return null;
		}
	}

	/**
	 *
	 * @return User $user
	 */
	public function validateAccessToken($tokenString) {
		if($tokenString == null || $tokenString == "") {
			return null;
		}
		$projection = array(
				UsersContract::USERS_TABLE_NAME . "." . UsersContract::USERS_COLUMN_E_MAIL,
				UsersContract::USERS_COLUMN_ROLE,
				UsersContract::ACCESS_TOKEN_TABLE_NAME . "." . UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN
		);
		$tables = array(UsersContract::USERS_TABLE_NAME, UsersContract::ACCESS_TOKEN_TABLE_NAME);
		$where = UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN . "=?";
		$whereargs = array(
				$tokenString
		);
		$user = $this->getUserData($projection, $tables, $where, $whereargs);
		if($user != null){
			return new User(
					$user[UsersContract::USERS_COLUMN_NAME],
					$user[UsersContract::USERS_COLUMN_SURNAME],
					$user[UsersContract::USERS_COLUMN_ROLE],
					$user[UsersContract::USERS_COLUMN_E_MAIL],
					$user[UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN]
			);
		} else {
			return null;
		}
	}

	public function getWebUser($email, $password){
		$projection = array(
				UsersContract::USERS_COLUMN_NAME,
				UsersContract::USERS_COLUMN_SURNAME,
				UsersContract::USERS_COLUMN_PASSWORD,
				UsersContract::USERS_COLUMN_E_MAIL,
				UsersContract::USERS_COLUMN_ROLE
		);
		$tables = array(UsersContract::USERS_TABLE_NAME);
		$where = UsersContract::USERS_COLUMN_E_MAIL. "=?";
		$whereargs = array($email);
		$user = $this->getUserData($projection, $tables, $where, $whereargs);
		if($user != null &&
				password_verify(sha1($password), $user[UsersContract::USERS_COLUMN_PASSWORD])){
			return User::generateToken($user[UsersContract::USERS_COLUMN_NAME],
					$user[UsersContract::USERS_COLUMN_SURNAME],
					$user[UsersContract::USERS_COLUMN_ROLE],
					$user[UsersContract::USERS_COLUMN_E_MAIL]);
		} else {
			return null;
		}
	}


	function getUserData($projection, $tables, $where, $whereargs){
		$dbLayer = new DbLayer();
		if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
			$data = $dbLayer->query($projection, $tables, $where, $whereargs);
			$row;
			if($data == null || !is_array($data)){
				$row = null;
			} else {
				$row = $data[0];
			}
			return $row;
		} else {
			return null;
		}
	}
}