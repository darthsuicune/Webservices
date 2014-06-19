<?php
include_once('LocationsService.php');
include_once('LoginService.php');
include_once('User.php');

require_once('DbLayer.php');
?>
<table border=1>
<tr>
<td>
<?php 
echo "testing db connection...";
$dbLayer = new DbLayer();

if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
	pass();
	testcalls($dbLayer);
	testLocations();
} else {
	fail();
	echo "Error message: ";
	var_dump($dbLayer->pdo->errorInfo());
}

function testLocations() {
	$ls = new LocationsService();
	$user = new User("name", "surname", UsersContract::ROLE_ADMIN, "asdf@asdf.asdf", "token");
	
	echo "Testing locations...";
	testGetLocations($user, $ls);
	echo "Testing locations...";
	testGetAllLocations($user, $ls);
	echo "Testing web locations...";
	testGetWebLocations($user, $ls);
}
function testGetLocations(User $user, LocationsService $ls) {
	$lastUpdateTime = "2014-06-01 18:25:27";
	$result = $ls->getLocations($user, $lastUpdateTime);
	if(count($result) < 40) {
		pass();
	} else {
		var_dump($result);
		fail();
	}
}
function testGetAllLocations(User $user, LocationsService $ls) {
	$lastUpdateTime = 0;
	$result = $ls->getLocations($user, $lastUpdateTime);
	if(count($result) > 40) {
		pass();
	} else {
		var_dump($result);
		fail();
	}
}

function testGetWebLocations(User $user, LocationsService $ls) {
	$result = $ls->getWebLocations($user);
	if(count($result) > 40) {
		pass();
	} else {
		var_dump($result);
		fail();
	}
}

function testcalls($dbLayer){
	$ls = new LoginService();
	
	echo "Testing insert...";
	testInsert($dbLayer);
	
	echo "Testing check user...";
	testCheckUser($ls);
	
	echo "Testing update...";
	testUpdate($dbLayer);
	
	echo "Testing query...";
	$id = testQuery($dbLayer);
	
	echo "Testing access token";
	testAccessToken($ls, $id);
	
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
			UsersContract::USERS_COLUMN_ROLE=>"admin",
			UsersContract::USERS_COLUMN_SURNAME=>"example");

	$result = $dbLayer->insert($table, $values);

	if($result === array()){
		pass();
	} else {
		var_dump($dbLayer->pdo->errorInfo());
		fail();
	}
}

function testUpdate(DbLayer $dbLayer){
	$table = UsersContract::USERS_TABLE_NAME;
	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"valid@email.de",
			UsersContract::USERS_COLUMN_PASSWORD=>password_hash("other_password", PASSWORD_BCRYPT),
			UsersContract::USERS_COLUMN_PASSWORD_RESET_TIME=>2,
			UsersContract::USERS_COLUMN_PASSWORD_RESET_TOKEN=>"fdasfdsa",
			UsersContract::USERS_COLUMN_ROLE=>"socorros",
			UsersContract::USERS_COLUMN_SURNAME=>"what");

	$where = "`".UsersContract::USERS_COLUMN_E_MAIL . "`=?";
	$whereArgs = array("user@example.com");
	$result = $dbLayer->update($values, $table, $where, $whereArgs);
	if($result === array()){
		pass();
	} else {
		var_dump($dbLayer->pdo->errorInfo());
		fail();
	}
}

function testQuery(DbLayer $dbLayer){
	$columns = array();
	$tables = UsersContract::USERS_TABLE_NAME;
	$where = "";
	$whereArgs = array();
	$result = $dbLayer->query($columns, $tables, $where, $whereArgs);
	var_dump($result);
	if($result){
		pass();
		return $result[0][UsersContract::USERS_COLUMN_ID];
	} else {
		var_dump($dbLayer->pdo->errorInfo());
		fail();
	}
}

function testDelete(DbLayer $dbLayer){
	$table = UsersContract::USERS_TABLE_NAME;
	$where = UsersContract::USERS_COLUMN_NAME . "=?";
	$whereArgs = array("user");
	$result = $dbLayer->delete($table, $where, $whereArgs);
	if($result === array()){
		pass();
	} else {
		var_dump($dbLayer->pdo->errorInfo());
		fail();
	}
}

function testCheckUser(LoginService $ls){
	$dbLayer = new DbLayer();
	include_once("Register.php");
	$register = new Register();
	$email = "weirdmail@example.com";
	$password = "user";
	$hash = password_hash($password, PASSWORD_BCRYPT);
	$roles = UsersContract::ROLE_ADMIN;
	$name = "asdf";
	$surname = "asdfasdf";
	$register->registerUser($hash, $email, $roles, $name, $surname);
	
	$result = $ls->checkUser($email, $password);
	if($result != null){
		pass();
	} else {
		var_dump($result);
		fail();
	}
	$dbLayer->delete(UsersContract::USERS_TABLE_NAME, UsersContract::USERS_COLUMN_E_MAIL . "=?", array($email));
	$dbLayer->delete(UsersContract::ACCESS_TOKEN_TABLE_NAME,
			UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN . "=?", array($result->accessToken->accessTokenString));
}
function testAccessToken(LoginService $ls, $id){
	$dbLayer = new DbLayer();
	$token = "token";
	$values = array(UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN => $token, 
			UsersContract::ACCESS_TOKEN_ID => $id);
	$dbLayer->insert(UsersContract::ACCESS_TOKEN_TABLE_NAME, $values);

	$result = $ls->validateAccessToken($token);
	if($result != null){
		pass();
	} else {
		var_dump($result);
		fail();
	}
	
	$dbLayer->delete(UsersContract::ACCESS_TOKEN_TABLE_NAME,
			UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN . "=?", array($token));
}
function pass(){
	echo "<font color=\"green\">PASSED</font><br>\n";
}

function fail(){
	echo "<font color=\"red\"><b>FAILED</b></font><br>";
}
?>
</td></tr>
</table>