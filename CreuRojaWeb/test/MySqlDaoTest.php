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
	assertTrue($result, "SELECT * FROM users");
	
	$tables = array(UsersContract::USERS_TABLE_NAME, AccessTokenContract::ACCESS_TOKEN_TABLE_NAME);
	$where = "myass=yourass' OR 1=1;'";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Multi table, Invalid where: ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users NATURAL JOIN accesstoken WHERE myass=yourass' OR 1=1;'");
	
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, empty whereArgs: ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertIsFalse($result);
	
	$columns = array();
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	$whereArgs = array("test1");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, valid whereArgs: ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users WHERE username=test1");
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
	assertTrue($result, "INSERT INTO users (email) VALUES (somevalue)");
	}
function testMySqlDaoUpdate(MySqlDao $dao){
	$values = array();
	$table = "";
	$where = "";
	$whereArgs = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values: ";
	$result = $dao->update($values, $table, $where, $whereArgs);
	assertIsFalse($result);
	
	$tables = array(UsersContract::USERS_TABLE_NAME);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Single table, empty where: ";
	$result = $dao->update($values, $table, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users");
	
	$tables = array(UsersContract::USERS_TABLE_NAME, AccessTokenContract::ACCESS_TOKEN_TABLE_NAME);
	$where = "myass=yourass' OR 1=1;'";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Multi table, Invalid where: ";
	$result = $dao->update($values, $table, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users NATURAL JOIN accesstoken WHERE myass=yourass' OR 1=1;'");
	
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, empty whereArgs: ";
	$result = $dao->update($values, $table, $where, $whereArgs);
	assertIsFalse($result);
	
	$columns = array();
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	$whereArgs = array("test1");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, valid whereArgs: ";
	$result = $dao->update($values, $table, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users WHERE username=?");
}
function testMySqlDaoDelete(MySqlDao $dao){
	$table = "";
	$where = "";
	$whereArgs = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertIsFalse($result);
	
	$tables = array(UsersContract::USERS_TABLE_NAME);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Single table, empty where: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertTrue($result, "INSERT INTO users VALUES ()");
	
	$tables = array(UsersContract::USERS_TABLE_NAME, AccessTokenContract::ACCESS_TOKEN_TABLE_NAME);
	$where = "myass=yourass' OR 1=1;'";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Multi table, Invalid where: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users NATURAL JOIN accesstoken WHERE myass=yourass' OR 1=1;'");
	
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, empty whereArgs: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertIsFalse($result);
	
	$columns = array();
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	$whereArgs = array("test1");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, valid whereArgs: ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users WHERE username=test1");
}
function testMySqlDaoBulkInsert(MySqlDao $dao){
	$table = "";
	$values = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values: ";
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse($result);
	
	$tables = array(UsersContract::USERS_TABLE_NAME);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Single table, empty where: ";
	$result = $dao->bulkInsert($table, $values);
	assertTrue($result, "SELECT * FROM users");
	
	$tables = array(UsersContract::USERS_TABLE_NAME, AccessTokenContract::ACCESS_TOKEN_TABLE_NAME);
	$where = "myass=yourass' OR 1=1;'";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Multi table, Invalid where: ";
	$result = $dao->bulkInsert($table, $values);
	assertTrue($result, "SELECT * FROM users NATURAL JOIN accesstoken WHERE myass=yourass' OR 1=1;'");
	
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, empty whereArgs: ";
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse($result);
	
	$columns = array();
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	$whereArgs = array("test1");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, valid whereArgs: ";
	$result = $dao->bulkInsert($table, $values);
	assertTrue($result, "SELECT * FROM users WHERE username=?");
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
	public function beginTransaction(){
		return true;
	}
	public function commit(){
		return true;
	}
	public function rollBack(){
		return false;
	}
}

class MockPdoStatement extends PDOStatement {
	var $query;
	public function __construct($query){
		$this->query = $query;
	}
	
	public function execute(array $args){
		if(substr_count($this->query, "?") != count($args)){
			return false;
		}
		foreach($args as $index=>$value){
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