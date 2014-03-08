<?php

require_once("model/DataStorage.php");
require_once("model/MySqlDao.php");
require_once("model/Location.php");
require_once("model/LocationsProvider.php");
require_once("model/User.php");
require_once("model/LocationsProviderImpl.php");

require_once("db/UsersContract.php");
require_once("db/AccessTokenContract.php");
require_once("db/LocationsContract.php");

require_once("test/MySqlDaoTest.php");
require_once("test/LocationsProviderTest.php");


echo "<table border='1'>\n";
echo "\t<tr>" . testMySqlDao() . "</tr>\n";
echo "\t<tr>" . testLocationsProviderImpl() . "</tr>\n";
// echo "\t<tr>" . testLoginProviderImpl() . "</tr>\n";
// echo "\t<tr>" . testWebClientImpl() . "</tr>\n";
echo "</table>";

function assertEquals($condition, $result, $expected){
	passTest($condition, areEqual($result, $expected));
}

function assertNotEquals($condition, $result, $expected){
	passTest($condition, !areEqual($result, $expected));
}

function areEqual($obj_a, $obj_b){
	$isEqual = false;
	if(is_array($obj_a) && is_array($obj_b)){
		$isEqual = true;
		for($i = 0; $i < count($obj_a); $i++){
			if($obj_a[$i] != $obj_b[$i]){
				$isEqual = false;
				break;
			}
		}
	} else if (!is_array($obj_a) && !is_array($obj_b)){
		if(strcmp($obj_a, $obj_b) == 0){
			$isEqual = true;
		}
	}
	return $isEqual;
}

function assertIsTrue($condition, $result){
	passTest($condition, $result);
}

function assertIsFalse($condition, $result){
	passTest($condition, !$result);
}

function passTest($condition, $isPassed){
	if($isPassed === true){
		echo "\t&nbsp;&nbsp;&nbsp;&nbsp;$condition: <font color=\"green\">PASSED</font><br>\n";
	} else {
		echo "\t&nbsp;&nbsp;&nbsp;&nbsp;$condition: <font color=\"red\"><b>FAILED</b></font><br>\n";
	}
}