<?php
require_once("test/MySqlDaoTest.php");
require_once("inc/DataStorage.php");
require_once("inc/MySqlDao.php");
require_once("inc/UsersContract.php");
require_once("inc/AccessTokenContract.php");
require_once("inc/LocationsContract.php");

require_once("inc/Location.php");
require_once("test/LocationsProviderTest.php");
require_once("inc/LocationsProvider.php");
require_once("inc/User.php");
require_once("inc/LocationsProviderImpl.php");

echo "<table border='1'>\n";
echo "\t<tr>" . testMySqlDao() . "</tr>\n";
echo "\t<tr>" . testLocationsProviderImpl() . "</tr>\n";
// echo "\t<tr>" . testLoginProviderImpl() . "</tr>\n";
// echo "\t<tr>" . testWebClientImpl() . "</tr>\n";
echo "</table>";

function assertEquals($condition, $result, $expected){
	$isEqual = false;
	if(is_array($result) && is_array($expected)){
		$isEqual = true;
		for($i = 0; $i < count($result); $i++){
			if($result[$i] != $expected[$i]){
				$isEqual = false;
				break;
			}
		}
	} else if (!is_array($result) && !is_array($expected)){
		if(strcmp($result, $expected) == 0){
			$isEqual = true;
		}
	}
	passTest($condition, $isEqual);
}

function assertNotEquals($condition, $result, $expected){
	$isEqual = false;
	if(is_array($result) && is_array($expected)){
		$isEqual = true;
		for($i = 0; $i < count($result); $i++){
			if($result[$i] != $expected[$i]){
				$isEqual = false;
				break;
			}
		}
	} else if (!is_array($result) && !is_array($expected)){
		if(strcmp($result, $expected) != 0){
			$isEqual = true;
		}
	} else {
		$isEqual = true;
	}
	passTest($condition, !$isEqual);
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