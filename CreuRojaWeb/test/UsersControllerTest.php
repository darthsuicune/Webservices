<?php

function testUsersController(){
	$provider = new MockUserProvider();
	$controller = new UsersControllerImpl($provider);
	echo "<td> UserController tests";
	echo "<td>testGetUserFromEmail<br>\n";
	testControllerGetUserFromEmail($controller);
	echo "<td>testGetUserFromLoginData<br>\n";
	testControllerValidateUserFromLoginData($controller);
	echo "<td>testGetUserFromAccessToken<br>\n";
	testControllerValidateUserFromAccessToken($controller);
	echo "<td>testGetUserList<br>\n";
	testControllerGetUserList($controller);
	echo "</td><br>\n";
}

function testControllerGetUserFromEmail(UsersController $controller) {
	$user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");

	$email = false;
	$result = $controller->getUserFromEmail($email);
	assertIsFalse("Email is false", $result);

	$email = "";
	$result = $controller->getUserFromEmail($email);
	assertIsFalse("Email is empty", $result);

	$email = "tralara";
	$result = $controller->getUserFromEmail($email);
	assertIsFalse("Email is invalid", $result);

	$email = "Email@something.com";
	$result = $controller->getUserFromEmail($email);
	assertEquals("Valid email", $result, $user1);
}

function testControllerValidateUserFromLoginData(UsersController $controller) {
	$user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");

	$email = false;
	$password = false;
	$user = $controller->validateUserFromLoginData($email, $password);
	assertIsFalse("Email is false", $user);

	$email = "";
	$user = $controller->validateUserFromLoginData($email, $password);
	assertIsFalse("Empty email", $user);

	$email = "email";
	$user = $controller->validateUserFromLoginData($email, $password);
	assertIsFalse("Invalid email", $user);

	$email = "Email@something.com";
	$password = "";
	$user = $controller->validateUserFromLoginData($email, $password);
	assertIsFalse("Valid email, wrong password", $user);

	$password = "passwordTest";
	$user = $controller->validateUserFromLoginData($email, $password);
	assertIsFalse("Valid data, unhashed password", $user);

	$password = sha1("passwordTest");
	$user = $controller->validateUserFromLoginData($email, $password);
	assertEquals("Valid data, hashed password", $user, $user1);
}

function testControllerValidateUserFromAccessToken(UsersController $controller) {
	$user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");

	$token = false;
	$user = $controller->validateUserFromAccessToken($token);
	assertIsFalse("Token is false", $user);

	$token = "";
	$user = $controller->validateUserFromAccessToken($token);
	assertIsFalse("Empty token", $user);

	$token = "token";
	$user = $controller->validateUserFromAccessToken($token);
	assertIsFalse("Invalid token", $user);

	$token = "validAccessTokenThatHas40CharactersTotal";
	$user = $controller->validateUserFromAccessToken($token);
	assertEquals("Valid token", $user, $user1);
}

function testControllerGetUserList(UsersController $controller) {
	$user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");
	$user2 = new User("Name2", "Surname2", "Email2@something.com", "role2", 1, "ca");
	
	$result = $controller->getUserList();
	assertEquals("Empty parameter", $result, array());
	
	$result = $controller->getUserList(null);
	assertEquals("Null list", $result, array());
	
	$result = $controller->getUserList(array());
	assertEquals("Empty list", $result, array());
	
	$result = $controller->getUserList(array("role"));
	assertEquals("Gets partial list", $result, array($user1));
	
	$result = $controller->getUserList(array("role", "role2"));
	assertEquals("Gets user list", $result, array($user1, $user2));
}


class MockUserProvider implements UsersProvider {
	var $user1, $user2;
	var $password = "passwordTest";
	var $accessToken = "validAccessTokenThatHas40CharactersTotal";

	public function __construct() {
		$this->user1 = new User("Name", "Surname", "Email@something.com", "role", 0, "ca");
		$this->user2 = new User("Name2", "Surname2", "Email2@something.com", "role2", 1, "ca");		
	}

	public function getUserFromEmail($email){
		if(strcmp($email, $this->user1->email) == 0) {
			return $this->user1;
		}
		return false;
	}
	public function getUserFromLoginData($email, $password){
		if((strcmp($email, $this->user1->email) == 0)
				&& (strcmp($password, sha1($this->password)) == 0)) {
			return $this->user1;
		}
		return false;
	}
	public function getUserFromAccessToken($accessToken){
		if(strcmp($accessToken, $this->accessToken) == 0) {
			return $this->user1;
		}
		return false;
	}

	public function getUserList(array $roles) {
		if($roles == array("role", "role2")){
			return array($this->user1, $this->user2);
		} else if($roles == array("role")){
			return array($this->user1);
		} else {
			return array();
		}
	}
}