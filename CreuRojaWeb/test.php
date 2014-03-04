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
require_once("inc/LocationsProviderImpl.php");
require_once("inc/User.php");

echo "<table border='1'>\n";
echo "\t<tr>" . testMySqlDao() . "</tr>\n";
echo "\t<tr>" . testLocationsProviderImpl() . "</tr>\n";
// echo "\t<tr>" . testLoginProviderImpl() . "</tr>\n";
// echo "\t<tr>" . testWebClientImpl() . "</tr>\n";
// echo "\t<tr>" . testUser() . "</tr>\n";
echo "</table>";

function assertEquals($result, $expected){
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

function assertIsTrue($result){
	if($result === true){
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