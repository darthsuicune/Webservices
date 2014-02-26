<?php

function testMySqlDao(){
	$pdo = new MockPDO();
	$dao = new MySqlDao($pdo);
	echo testMySqlDaoQuery($dao);
	echo testMySqlDaoInsert($dao);
	echo testMySqlDaoUpdate($dao);
	echo testMySqlDaoDelete($dao);
	echo testMySqlDaoBulkInsert($dao);
}

function testMySqlDaoQuery(MySqlDao $dao){
	echo "testMySqlDaoQuery<br>\n";
	$columns = array();
	$tables = array();
	$where = "";
	$whereArgs = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertIsFalse($result);
	
	$tables = array(UsersContract::USERS_TABLE_NAME);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Single table, empty where ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users TYPE: 2");
	
	$tables = array(UsersContract::USERS_TABLE_NAME, AccessTokenContract::ACCESS_TOKEN_TABLE_NAME);
	$where = "myass=yourass' OR 1=1;";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Multi table, Invalid where ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users NATURAL JOIN accesstoken WHERE myass=yourass' OR 1=1; TYPE: 2");
	
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, empty whereArgs ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertIsFalse($result);
	
	$columns = array();
	$tables = array(UsersContract::USERS_TABLE_NAME);
	$where = UsersContract::USERS_COLUMN_USERNAME . "=?";
	$whereArgs = array("test1");
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Valid where, valid whereArgs ";
	$result = $dao->query($columns, $tables, $where, $whereArgs);
	assertTrue($result, "SELECT * FROM users WHERE username=? TYPE: 2");
}
function testMySqlDaoInsert(MySqlDao $dao){
	echo "testMySqlDaoInsert<br>\n";
	
	$table = "";
	$values = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values ";
	$result = $dao->insert($table, $values);
	assertIsFalse($result);
}
function testMySqlDaoUpdate(MySqlDao $dao){
	echo "testMySqlDaoUpdate<br>\n";
	
	$values = array();
	$table = "";
	$where = "";
	$whereArgs = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values ";
	$result = $dao->update($values, $table, $where, $whereArgs);
	assertIsFalse($result);
}
function testMySqlDaoDelete(MySqlDao $dao){
	echo "testMySqlDaoDelete<br>\n";
	
	$table = "";
	$where = "";
	$whereArgs = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values ";
	$result = $dao->delete($table, $where, $whereArgs);
	assertIsFalse($result);
}
function testMySqlDaoBulkInsert(MySqlDao $dao){
	echo "testMySqlDaoBulkInsert<br>\n";
	
	$table = "";
	$values = array();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;Empty values ";
	$result = $dao->bulkInsert($table, $values);
	assertIsFalse($result);
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
	
	public function execute(array $args){
		return $this->query . join(",", $args);
	}
	public function errorInfo(){
		return $this->query;
	}
	public function closeCursor(){
		return $this->query;
	}
	public function fetchAll($type){
		return $this->query . " TYPE: " . $type;
	}
}