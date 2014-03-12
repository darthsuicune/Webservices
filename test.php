<?php
include_once('LocationsService.php');
include_once('User.php');

require_once('DbLayer.php');

// $name = "test1";
// $surname = "test1";
// $role = "admin";
// $email = "denis@localhost";
// $accessToken = new AccessToken("whatever");
// $user = new User($name, $surname, $role, $email, $accessToken);

// $ls = new LocationsService();

// print json_encode($ls->getLocations($user, (isset($_GET['lup'])) ? $_GET['lup'] : 0));

$dbLayer = new DbLayer();
echo "testing db connection...";

if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
	pass();
	testcalls($dbLayer);
} else {
	fail();
	echo "Error message: ";
	var_dump($dbLayer->pdo->errorInfo());
}

function testcalls($dbLayer){
	echo "Testing insert...";
	testInsert($dbLayer);
	echo "Testing update...";
	testUpdate($dbLayer);
	echo "Testing query...";
	testQuery($dbLayer);
	echo "Testing delete...";
	testDelete($dbLayer);
}

function testInsert(DbLayer $dbLayer){
	$table = UsersContract::USERS_TABLE_NAME;
	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"user@example.com",
			UsersContract::USERS_COLUMN_NAME=>"user",
			UsersContract::USERS_COLUMN_PASSWORD=>password_hash("user", PASSWORD_BCRYPT),
			UsersContract::USERS_COLUMN_PASSWORD_RESET_TIME=>0,
			UsersContract::USERS_COLUMN_PASSWORD_RESET_TOKEN=>"asdfasdf",
			UsersContract::USERS_COLUMN_ROLE=>"social",
			UsersContract::USERS_COLUMN_SURNAME=>"example");

	$result = $dbLayer->insert($table, $values);
	var_dump($result);
	if($result){
		pass();
	} else {
		var_dump($dbLayer->pdo->errorInfo());
		fail();
	}
}

function testUpdate(DbLayer $dbLayer){
	$table = UsersContract::USERS_TABLE_NAME;
	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"valid@email.de",
			UsersContract::USERS_COLUMN_NAME=>"other_user",
			UsersContract::USERS_COLUMN_PASSWORD=>password_hash("other_password", PASSWORD_BCRYPT),
			UsersContract::USERS_COLUMN_PASSWORD_RESET_TIME=>2,
			UsersContract::USERS_COLUMN_PASSWORD_RESET_TOKEN=>"fdasfdsa",
			UsersContract::USERS_COLUMN_ROLE=>"socorros",
			UsersContract::USERS_COLUMN_SURNAME=>"what");

	$where = UsersContract::USERS_COLUMN_E_MAIL . "=?";
	$whereArgs = array("user@example.com");
	$result = $dbLayer->update($values, $table, $where, $whereArgs);

	var_dump($result);
	if($result == array()){
		pass();
	} else {
		var_dump($dbLayer->pdo->errorInfo());
		fail();
	}
}

function testQuery(DbLayer $dbLayer){
	$columns = array();
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = "";
	$whereArgs = array();
	$result = $dbLayer->query($columns, $tables, $where, $whereArgs);
	var_dump($result);
	if($result){
		pass();
	} else {
		var_dump($dbLayer->pdo->errorInfo());
		fail();
	}
}

function testDelete(DbLayer $dbLayer){
	$table = UsersContract::USERS_TABLE_NAME;
	$where = UsersContract::USERS_COLUMN_E_MAIL . "=?";
	$whereArgs = array("valid@email.de");
	$result = $dbLayer->delete($table, $where, $whereArgs);
	var_dump($result);
	if($result == array()){
		pass();
	} else {
		var_dump($dbLayer->pdo->errorInfo());
		fail();
	}
}

function pass(){
	echo "<font color=\"green\">PASSED</font><br>\n";
}

function fail(){
	echo "<font color=\"red\"><b>FAILED</b></font><br>";
}