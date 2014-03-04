<?php

function testMySqlDao(){
	$pdo = new MockPDO();
	$dao = new MySqlDao($pdo);
	echo "<td> MySQLDao tests";
	echo "<td>testMySqlDaoQuery<br>\n";
	echo testMySqlDaoQuery($dao);
	echo "</td>\n<td>testMySqlDaoInsert<br>\n";
	echo testMySqlDaoInsert($dao);
	echo "</td>\n<td>testMySqlDaoUpdate<br>\n";
	echo testMySqlDaoUpdate($dao);
	echo "</td>\n<td>testMySqlDaoDelete<br>\n";
	echo testMySqlDaoDelete($dao);
	echo "</td>\n<td>testMySqlDaoBulkInsert<br>\n";
	echo testMySqlDaoBulkInsert($dao);
	echo "</td>";
}

function testMySqlDaoQuery(MySqlDao $dao){
	$columns = array();
	$tables = array();
	$where = "";
	$whereArgs = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values: ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertIsFalse($result);

	$tables = array(UsersContract::USERS_TABLE_NAME);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Single table, empty where: ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertEquals($result, "SELECT * FROM users");

	$tables = array(UsersContract::USERS_TABLE_NAME,
			AccessTokenContract::ACCESS_TOKEN_TABLE_NAME);
	$where = "mytest=yourtest OR 1=1";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Multi table, Where without ?: ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertEquals($result, "SELECT * FROM users NATURAL JOIN accesstoken"
			. " WHERE mytest=yourtest OR 1=1");

	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, empty whereArgs: ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertIsFalse($result);

	$columns = array();
	$whereArgs = array("test1");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, valid whereArgs: ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertEquals($result, "SELECT * FROM users WHERE username=test1");
}

function testMySqlDaoInsert(MySqlDao $dao){
	$table = "";
	$values = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;No table, Empty values: ";
	$result = $dao->insert($table, $values);
	assertIsFalse($result);

	$table = UsersContract::USERS_TABLE_NAME;
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Table defined, empty values: ";
	$result = $dao->insert($table, $values);
	assertIsFalse($result);

	$values = array("somevalue");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Undefined indexes: ";
	$result = $dao->insert($table, $values);
	assertIsFalse($result);

	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"somevalue");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid values: ";
	$result = $dao->insert($table, $values);
	assertEquals($result, "INSERT INTO users (email) VALUES (somevalue)");
}

function testMySqlDaoBulkInsert(MySqlDao $dao){
	$table = "";
	$values = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values: ";
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse($result);
	
	$table = LocationsContract::LOCATIONS_TABLE_NAME;
	$values = array("locpara1", "locpara2");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp; Passing array with values: ";
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse($result);
	
	$values = array(array("locpara1"), "locpara2");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp; Passing array with array and value: ";
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse($result);
	
	$values = array(array("locpara1"), array("locpara2"));
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp; Passing array with sub arrays without index: ";
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse($result);
	
	$values1 = array("locpar1"=>"locval1", "locpar2"=>"locval2");
	$values2 = array("locpara1", "locpara2");
	$values = array($values1, $values2);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid request: ";
	$result = $dao->bulkInsert($table, $values);
	assertEquals($result, "INSERT INTO locations (locpar1,locpar2) VALUES (locval1,locval2),(locpara1,locpara2)");
	
	$values2 = array("locpara1", "locpara2", "locpara3");
	$values = array($values1, $values2);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Too many parameters: ";
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse($result);
}

function testMySqlDaoUpdate(MySqlDao $dao){
	$values = array();
	$table = "";
	$where = "";
	$whereArgs = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty everything: ";
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertIsFalse($result);

	$table = UsersContract::USERS_TABLE_NAME;
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values, set table: ";
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertIsFalse($result);

	$values = array("somevalue");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Undefined indexes: ";
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertIsFalse($result);

	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"somevalue");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid single value: ";
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertEquals($result, "UPDATE users SET (email=somevalue)");

	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"somevalue",
			UsersContract::USERS_COLUMN_ROLE=>"admin");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid multiple values: ";
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertEquals($result, "UPDATE users SET (email=somevalue,role=admin)");

	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, empty whereArgs: ";
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertIsFalse($result);

	$whereArgs = array("test1");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, valid whereArgs: ";
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertEquals($result, "UPDATE users SET (email=somevalue,role=admin) "
			. "WHERE username=test1");
}

function testMySqlDaoDelete(MySqlDao $dao){
	$table = "";
	$where = "";
	$whereArgs = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertIsFalse($result);

	$table = UsersContract::USERS_TABLE_NAME;
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Single table, empty where: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertIsFalse($result);

	$table = "";
	$where = UsersContract::USERS_COLUMN_ROLE ."=?";
	$whereArgs = array("admin");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty table, valid where: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertIsFalse($result);
	
	$table = UsersContract::USERS_TABLE_NAME;
	$where = UsersContract::USERS_COLUMN_ROLE ."=admin";
	$whereArgs = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty table, valid where, empty whereArgs: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertEquals($result, "DELETE FROM users WHERE role=admin");
	
	$where = UsersContract::USERS_COLUMN_ROLE ."=?";
	$whereArgs = array("admin");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty table, valid where, matching whereArgs: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertEquals($result, "DELETE FROM users WHERE role=admin");
}

class MockPDO extends PDO {
	public function __construct(){
	}

	public function query($query){
		return $query;
	}
	public function prepare($query){
		return new MockPdoStatement($query);
	}
}

class MockPdoStatement extends PDOStatement {
	var $query;
	public function __construct($query){
		$this->query = $query;
	}

	public function execute(array $args) {
		if(substr_count($this->query, "?") != count($args)) {
			return false;
		}
		foreach($args as $index=>$value) {
			$this->query = preg_replace('/\?/', $value, $this->query, 1);
		}
		return true;
	}
	public function errorInfo(){
		return $this->query;
	}
	public function closeCursor(){
		return $this->query;
	}
	public function fetchAll($type){
		return $this->query;
	}
}
