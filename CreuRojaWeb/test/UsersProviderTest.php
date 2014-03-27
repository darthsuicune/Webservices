<?php

function testUsersProviderImpl(){
	$storage = new MockUserStorage();
	$provider = new UserProviderImpl($storage);
	echo "<td> UserProvider tests";
	echo "<td>testGetUserFromEmail<br>\n";
	testGetUserFromEmail($provider);
	echo "<td>testGetUserFromAccessToken<br>\n";
	testGetUserFromAccessToken($provider);
	echo "</td><br>\n";
}

function testGetUserFromEmail(UsersProvider $provider) {
	$email = false;
	$user = $provider->getUserFromEmail($email);
	assertIsFalse("Email is false", $user);
	$email = "";
	$user = $provider->getUserFromEmail($email);
	assertIsFalse("Empty email", $user);
	$email = "";
	$user = $provider->getUserFromEmail($email);
	assertIsFalse("Valid email", $user);
}

function testGetUserFromAccessToken(UsersProvider $provider) {

}


class MockUserStorage implements DataStorage {


	public function __construct(){
	}

	public function query(array $columns, array $tables, $where, array $whereArgs) {
		if(($where == "") || (substr_count($where, "?") != count($whereArgs))){
			return false;
		}

		return false;
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