<?php

function testUsersProviderImpl(){
	$storage = new MockUserStorage();
	$provider = new UsersProviderImpl($storage);
	echo "<td> UserProvider tests";
	echo "<td>testGetUserFromEmail<br>\n";
	testGetUserFromEmail($provider);
	echo "<td>testGetUserFromLoginData<br>\n";
	testGetUserFromLoginData($provider);
	echo "<td>testGetUserFromAccessToken<br>\n";
	testGetUserFromAccessToken($provider);
	echo "<td>testGetUserList<br>\n";
	testGetUserList($provider);
	echo "</td><br>\n";
}

function testGetUserFromEmail(UsersProvider $provider) {
	$user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");

	$email = false;
	$user = $provider->getUserFromEmail($email);
	assertisFalse("Email is false", $user, $user1);
	
	$email = "";
	$user = $provider->getUserFromEmail($email);
	assertIsFalse("Empty email", $user);
	
	$email = "email";
	$user = $provider->getUserFromEmail($email);
	assertIsFalse("Invalid email", $user);
	
	$email = "Email@something.com";
	$user = $provider->getUserFromEmail($email);
	assertEquals("Valid email", $user, $user1);
}

function testGetUserFromLoginData(UsersProvider $provider) {
	$user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");
	
	$email = "Email@something.com";
	$password = "";
	$user = $provider->getUserFromLoginData($email, $password);
	assertIsFalse("Valid email, wrong password", $user);
	
	$password = "passwordTest";
	$user = $provider->getUserFromLoginData($email, $password);
	assertIsFalse("Valid data, unhashed password", $user);

	$password = sha1("passwordTest");
	$user = $provider->getUserFromLoginData($email, $password);
	assertEquals("Valid data, hashed password", $user, $user1);
}

function testGetUserFromAccessToken(UsersProvider $provider) {
	$user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");
	
	$token = false;
	$user = $provider->getUserFromAccessToken($token);
	assertIsFalse("Token is false", $user);
	
	$token = "";
	$user = $provider->getUserFromAccessToken($token);
	assertIsFalse("Empty token", $user);
	
	$token = "token";
	$user = $provider->getUserFromAccessToken($token);
	assertIsFalse("Invalid token", $user);
	
	$token = "accessTokenThatHas30Characters";
	$user = $provider->getUserFromAccessToken($token);
	assertEquals("Valid token", $user, $user1);
}

function testGetUserList(UsersProvider $provider) {
	$user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");
	$user2 = new User("Name2", "Surname2", "Email2@something.com", "role2", 1, "ca");
	
	$result = $provider->getUserList(array("role"));
	assertEquals("Gets partial list", $result, array($user1));
	
	$result = $provider->getUserList(array("role", "role2"));
	assertEquals("Gets user list", $result, array($user1, $user2));
}

class MockUserStorage implements DataStorage {
	var $user1;
	var $user2;
	var $password;
	var $token = "accessTokenThatHas30Characters";

	public function __construct(){
		$this->user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");
		$this->user2 = new User("Name2", "Surname2", "Email2@something.com", "role2", 1, "ca");
		$this->password = password_hash(sha1("passwordTest"), PASSWORD_BCRYPT);
	}

	public function query(array $columns, array $tables, $where, array $whereArgs) {
		if(($where == "") || (substr_count($where, "?") != count($whereArgs))){
			return false;
		}
		if(strpos($where, UsersContract::COLUMN_ROLE) !== false) {
			if($whereArgs == array("role", "role2")){
				return array($this->user1->to_array(), $this->user2->to_array());
			} else if($whereArgs == array("role")){
				return array($this->user1->to_array());
			}
		} else if($whereArgs[0] == $this->user1->email || $whereArgs[0] == $this->token) {
		return array(array(UsersContract::COLUMN_NAME=>$this->user1->name,
				UsersContract::COLUMN_SURNAME=>$this->user1->surname,
				UsersContract::COLUMN_E_MAIL=>$this->user1->email,
				UsersContract::COLUMN_ROLE=>$this->user1->role,
				UsersContract::COLUMN_ID=>$this->user1->id,
				UsersContract::COLUMN_PASSWORD=>$this->password,
				UsersContract::COLUMN_LANGUAGE=>$this->user1->language));
		} else {
			return array(array());
		}
	}

	public function insert($table, array $values) {
	}

	public function bulkInsert($table, array $values) {

	}

	public function update($table, array $values, $where, array $whereArgs) {
	}

	public function delete($table, $where, array $whereArgs) {
	}
}