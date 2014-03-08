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
		$userRow = $this->getUserData($projection, $tables, $where, $whereargs);
		
		if($userRow != null &&
				password_verify($password, $userRow[UsersContract::USERS_COLUMN_PASSWORD])){
			return User::generateToken($userRow[UsersContract::USERS_COLUMN_NAME],
					$userRow[UsersContract::USERS_COLUMN_SURNAME],
					$userRow[UsersContract::USERS_COLUMN_ROLE],
					$userRow[UsersContract::USERS_COLUMN_E_MAIL]);
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
				UsersContract::USERS_COLUMN_NAME,
				UsersContract::USERS_COLUMN_SURNAME,
				UsersContract::USERS_COLUMN_ROLE,
				UsersContract::ACCESS_TOKEN_TABLE_NAME . "." . UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN
		);
		$tables = array(UsersContract::USERS_TABLE_NAME, UsersContract::ACCESS_TOKEN_TABLE_NAME);
		$where = UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN . "=?";
		$whereargs = array(
				$tokenString
		);
		$userRow = $this->getUserData($projection, $tables, $where, $whereargs);
		if($userRow != null){
			return new User(
					$userRow[UsersContract::USERS_COLUMN_NAME],
					$userRow[UsersContract::USERS_COLUMN_SURNAME],
					$userRow[UsersContract::USERS_COLUMN_ROLE],
					$userRow[UsersContract::USERS_COLUMN_E_MAIL],
					$userRow[UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN]
			);
		} else {
			return null;
		}
	}

	public function getUserFromEmail($email){
		$projection = array(
				UsersContract::USERS_COLUMN_NAME,
				UsersContract::USERS_COLUMN_SURNAME,
				UsersContract::USERS_COLUMN_E_MAIL,
				UsersContract::USERS_COLUMN_ROLE
		);
		$tables = array(UsersContract::USERS_TABLE_NAME);
		$where = UsersContract::USERS_COLUMN_E_MAIL . "=?";
		$whereargs = array($email);
		$userRow = $this->getUserData($projection, $tables, $where, $whereargs);
		if($userRow != null){
			return new User(
					$userRow[UsersContract::USERS_COLUMN_NAME],
					$userRow[UsersContract::USERS_COLUMN_SURNAME],
					$userRow[UsersContract::USERS_COLUMN_ROLE],
					$userRow[UsersContract::USERS_COLUMN_E_MAIL],
					"");
		}
		return false;
	}
	
	public function canResetPassword($email, $token){
		$dbLayer = new DbLayer();
		if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
			$columns = array();
			$tables = array(UsersContract::USERS_TABLE_NAME);
			$where = UsersContract::USERS_COLUMN_E_MAIL . "=? AND "
					. UsersContract::USERS_COLUMN_PASSWORD_RESET_TOKEN . "=?";
			$whereArgs = array($email, $token);
			$userRow = $dbLayer->query($columns, $tables, $where, $whereArgs);
			$userRow = $userRow[0];
			if($userRow != null
					&& $userRow[UsersContract::USERS_COLUMN_PASSWORD_RESET_TOKEN] == $token) {
				$time = $userRow[UsersContract::USERS_COLUMN_PASSWORD_RESET_TIME];
				//1 hour * 60 mins * 60 secs * 1000 milisecs
				$isStillValid = (($time + 1*60*60*1000) > round(microtime(true) * 1000));
				$this->resetPasswordToken($email); 
				return $isStillValid;
			}
		}
		return false;
	}
	
	function resetPasswordToken($email){
		$dbLayer = new DbLayer();
		if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
			$values = array(UsersContract::USERS_COLUMN_PASSWORD_RESET_TIME=>0);
			$table = UsersContract::USERS_TABLE_NAME;
			$where = UsersContract::USERS_COLUMN_E_MAIL . "=?";
			$whereArgs = array($email);
			return $dbLayer->update($values, $table, $where, $whereArgs);
		}
		return false;
	}
	
	public function updateUser($email, $newPassword){
		$user = $this->getUserFromEmail($email);
		return $user->changePassword($newPassword);
	}

	function getUserData($projection, $tables, $where, $whereargs){
		$dbLayer = new DbLayer();
		if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
			$data = $dbLayer->query($projection, $tables, $where, $whereargs);
			if($data != null && is_array($data)){
				$data = $data[0];
			}
			return $data;
		} else {
			return null;
		}
	}
}
