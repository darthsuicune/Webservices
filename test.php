<?php
include_once('LocationsService.php');
include_once('LoginService.php');
include_once('User.php');

require_once('DbLayer.php');
?>
<table border=1>
<tr><td>
<?php
echo "testing login service";
$dbLayer = new DbLayer();


function testCheckUser(LoginService $ls){
	$email = "user@example.com";
	$password = sha1("user");
	$result = $ls->checkUser($email, $password);
	if($result != null){
		pass();
	} else {
		var_dump($result);
		fail();
	}
}
function testAccessToken(LoginService $ls){
	$dbLayer = new DbLayer();
	$token = "token";
	$values = array(UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN => $token, UsersContract::ACCESS_TOKEN_EMAIL => 1);
	$dbLayer->insert(UsersContract::ACCESS_TOKEN_TABLE_NAME, $values);
	
	$result = $ls->validateAccessToken($token);
	if($result != null){
		pass();
		$dbLayer->delete(UsersContract::ACCESS_TOKEN_TABLE_NAME, UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN . "=?", array("token"));
	} else {
		var_dump($result);
		fail();
	}
}
?>
</td>
</tr>
<tr>
<td>
<?php 
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
	$ls = new LoginService();
	
	echo "Testing insert...";
	testInsert($dbLayer);
	
	echo "Testing check user...";
	testCheckUser($ls);
	
	echo "Testing update...";
	testUpdate($dbLayer);
	
	echo "Testing access token";
	testAccessToken($ls);
	
	echo "Testing query...";
	testQuery($dbLayer);
	echo "Testing delete...";
	testDelete($dbLayer);
}

function testInsert(DbLayer $dbLayer){
	$table = UsersContract::USERS_TABLE_NAME;
	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"user@example.com",
			UsersContract::USERS_COLUMN_NAME=>"user",
			UsersContract::USERS_COLUMN_PASSWORD=>password_hash(sha1("user"), PASSWORD_BCRYPT),
			UsersContract::USERS_COLUMN_PASSWORD_RESET_TIME=>0,
			UsersContract::USERS_COLUMN_PASSWORD_RESET_TOKEN=>"asdfasdf",
			UsersContract::USERS_COLUMN_ROLE=>"social",
			UsersContract::USERS_COLUMN_SURNAME=>"example");

	$result = $dbLayer->insert($table, $values);
	var_dump($result);

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
	var_dump($result);
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
	var_dump($result);
	if($result === array()){
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
?>
</td></tr>
</table>