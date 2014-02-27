<?php
require_once("test/MySqlDaoTest.php");
require_once("inc/DataStorage.php");
require_once("inc/MySqlDao.php");

require_once("inc/UsersContract.php");
require_once("inc/AccessTokenContract.php");
require_once("inc/LocationsContract.php");

echo "<table border='1'><tr>\n";
testMySqlDao();
echo "</tr>\n";
// echo "<table><tr>" . testLocationsProviderImpl() . "</tr>\n";
// echo "<table><tr>" . testLoginProviderImpl() . "</tr>\n";
// echo "<table><tr>" . testWebClientImpl() . "</tr>\n";
// echo "<table><tr>" . testUser() . "</tr>\n";

function assertTrue($result, $expected){
	if(strcmp($result, $expected) === 0){
		echo "<font color=\"green\">PASSED </font><br>\n";
	} else {
		echo "<font color=\"red\"><b>FAILED</b></font><br>\n";
	}
}

function assertFalse($result, $expected){
	if(!strcmp($result, $expected) === 0){
		echo "<font color=\"green\">PASSED </font><br>\n";
	} else {
		echo "<font color=\"red\"><b>FAILED</b></font><br>\n";
	}
}

function assertIsFalse($result){
	if($result === false){
		echo "<font color=\"green\">PASSED </font><br>\n";
	} else {
		echo "<font color=\"red\"><b>FAILED</b></font><br>\n";
	}
}