<?php
require_once('UsersProvider.php');

class UsersProviderImpl implements UsersProvider {
	var $dataStorage;
	public function __construct(DataStorage $dataStorage){
		$this->dataStorage = $dataStorage;
	}

	public function getUserFromEmail($email) {
		$columns = array(UsersContract::COLUMN_E_MAIL, UsersContract::COLUMN_ID,
				UsersContract::COLUMN_NAME, UsersContract::COLUMN_SURNAME,
				UsersContract::COLUMN_ROLE);
		$tables = array(UsersContract::TABLE_NAME);
		$where = UsersContract::COLUMN_E_MAIL . "=?";
		$whereArgs = array($email);
		$result = $this->dataStorage->query($columns, $tables, $where, $whereArgs);
		return $this->getUserObject($result[0]);
	}

	public function getUserFromLoginData($email, $password) {
		$columns = array(UsersContract::COLUMN_E_MAIL, UsersContract::COLUMN_ID,
				UsersContract::COLUMN_NAME, UsersContract::COLUMN_SURNAME,
				UsersContract::COLUMN_ROLE, UsersContract::COLUMN_PASSWORD);
		$tables = array(UsersContract::TABLE_NAME);
		$where = UsersContract::COLUMN_E_MAIL . "=?";
		$whereArgs = array($email);
		$result = $this->dataStorage->query($columns, $tables, $where, $whereArgs);
		if(password_verify($password, $result[0][UsersContract::COLUMN_PASSWORD])) {
			return $this->getUserObject($result[0]);
		} else {
			return false;
		}
	}

	public function getUserFromAccessToken($accessToken) {
		$columns = array(AccessTokenContract::COLUMN_LOGIN_TOKEN, UsersContract::COLUMN_ID,
				UsersContract::COLUMN_E_MAIL, UsersContract::COLUMN_NAME,
				UsersContract::COLUMN_SURNAME, UsersContract::COLUMN_ROLE);
		$tables = array(AccessTokenContract::TABLE_NAME, UsersContract::TABLE_NAME);
		$where = AccessTokenContract::USER_ID . "=?";
		$whereArgs = array($accessToken);
		$result = $this->dataStorage->query($columns, $tables, $where, $whereArgs);
		return $this->getUserObject($result[0]);
	}

	public function getUserList(array $roles) {
		$columns = array(UsersContract::COLUMN_ID, UsersContract::COLUMN_E_MAIL, 
				UsersContract::COLUMN_NAME, UsersContract::COLUMN_SURNAME, 
				UsersContract::COLUMN_ROLE);
		$tables = array(UsersContract::TABLE_NAME);
		$where = UsersContract::COLUMN_ROLE . " IN (" 
				. implode(',', array_fill(0, count($roles), '?'))
				. ")";
		$whereArgs = $roles;
		$result = $this->dataStorage->query($columns, $tables, $where, $whereArgs);
		$userList = array();
		foreach($result as $userArray) {
			$userList[] = $this->getUserObject($userArray);
		}
		return $userList;
	}

	function getUserObject(array $userArray) {
		if(isset($userArray[UsersContract::COLUMN_NAME])) {
			return new User($userArray[UsersContract::COLUMN_NAME],
					$userArray[UsersContract::COLUMN_SURNAME],
					$userArray[UsersContract::COLUMN_E_MAIL],
					$userArray[UsersContract::COLUMN_ROLE],
					$userArray[UsersContract::COLUMN_ID]);
		} else {
			return null;
		}
	}
}