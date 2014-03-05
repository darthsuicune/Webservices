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
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertIsFalse("Empty values", $result);

	$tables = array(UsersContract::USERS_TABLE_NAME);
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertEquals("Single table, empty where", $result, "SELECT * FROM users");

	$tables = array(UsersContract::USERS_TABLE_NAME,
			AccessTokenContract::ACCESS_TOKEN_TABLE_NAME);
	$where = "mytest=yourtest OR 1=1";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertEquals("Multi table, Where without ?", $result, "SELECT * FROM users NATURAL JOIN accesstoken"
			. " WHERE mytest=yourtest OR 1=1");

	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertIsFalse("Valid where, empty whereArgs", $result);

	$columns = array();
	$whereArgs = array("test1");
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertEquals("Valid where, valid whereArgs", $result, "SELECT * FROM users WHERE username=test1");
}

function testMySqlDaoInsert(MySqlDao $dao){
	$table = "";
	$values = array();
	$result = $dao->insert($table, $values);
	assertIsFalse("No table, Empty values", $result);

	$table = UsersContract::USERS_TABLE_NAME;
	$result = $dao->insert($table, $values);
	assertIsFalse("Table defined, empty values", $result);

	$values = array("somevalue");
	$result = $dao->insert($table, $values);
	assertIsFalse("Undefined indexes", $result);

	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"somevalue");
	$result = $dao->insert($table, $values);
	assertEquals("Valid values", $result, "INSERT INTO users (email) VALUES (somevalue)");
}

function testMySqlDaoBulkInsert(MySqlDao $dao){
	$table = "";
	$values = array();
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse("Empty values", $result);
	
	$table = LocationsContract::LOCATIONS_TABLE_NAME;
	$values = array("locpara1", "locpara2");
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse("Passing array with values", $result);
	
	$values = array(array("locpara1"), "locpara2");
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse("Passing array with array and value", $result);
	
	$values = array(array("locpara1"), array("locpara2"));
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse("Passing array with sub arrays without index", $result);
	
	$values1 = array("locpar1"=>"locval1", "locpar2"=>"locval2");
	$values2 = array("locpara1", "locpara2");
	$values = array($values1, $values2);
	$result = $dao->bulkInsert($table, $values);
	assertEquals("Valid request", $result, "INSERT INTO locations (locpar1,locpar2) VALUES (locval1,locval2),(locpara1,locpara2)");
	
	$values2 = array("locpara1", "locpara2", "locpara3");
	$values = array($values1, $values2);
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse("Too many parameters", $result);
}

function testMySqlDaoUpdate(MySqlDao $dao){
	$values = array();
	$table = "";
	$where = "";
	$whereArgs = array();
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertIsFalse("Empty everything", $result);

	$table = UsersContract::USERS_TABLE_NAME;
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertIsFalse("Empty values, set table", $result);

	$values = array("somevalue");
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertIsFalse("Undefined indexes", $result);

	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"somevalue");
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertEquals("Valid single value", $result, "UPDATE users SET (email=somevalue)");

	$values = array(UsersContract::USERS_COLUMN_E_MAIL=>"somevalue",
			UsersContract::USERS_COLUMN_ROLE=>"admin");
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertEquals("Valid multiple values", $result, "UPDATE users SET (email=somevalue,role=admin)");

	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertIsFalse("Valid where, empty whereArgs", $result);

	$whereArgs = array("test1");
	$result = $dao->update($table, $values, $where, $whereArgs);
	assertEquals("Valid where, valid whereArgs", $result, "UPDATE users SET (email=somevalue,role=admin) "
			. "WHERE username=test1");
}

function testMySqlDaoDelete(MySqlDao $dao){
	$table = "";
	$where = "";
	$whereArgs = array();
	$result = $dao->delete($table, $where, $whereArgs);
	assertIsFalse("Empty values", $result);

	$table = UsersContract::USERS_TABLE_NAME;
	$result = $dao->delete($table, $where, $whereArgs);
	assertIsFalse("Single table, empty where", $result);

	$table = "";
	$where = UsersContract::USERS_COLUMN_ROLE ."=?";
	$whereArgs = array("admin");
	$result = $dao->delete($table, $where, $whereArgs);
	assertIsFalse("Empty table, valid where", $result);
	
	$table = UsersContract::USERS_TABLE_NAME;
	$where = UsersContract::USERS_COLUMN_ROLE ."=admin";
	$whereArgs = array();
	$result = $dao->delete($table, $where, $whereArgs);
	assertEquals("Empty table, valid where, empty whereArgs", $result, "DELETE FROM users WHERE role=admin");
	
	$where = UsersContract::USERS_COLUMN_ROLE ."=?";
	$whereArgs = array("admin");
	$result = $dao->delete($table, $where, $whereArgs);
	assertEquals("Empty table, valid where, matching whereArgs", $result, "DELETE FROM users WHERE role=admin");
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
