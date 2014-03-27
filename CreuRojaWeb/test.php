<?php
foreach (glob("controller/*.php") as $filename)
{
    require_once($filename);
}
foreach (glob("model/*.php") as $filename)
{
	require_once($filename);
}
foreach (glob("l10n/*.php") as $filename)
{
	require_once($filename);
}
foreach (glob("db/*.php") as $filename)
{
	require_once($filename);
}
foreach (glob("test/*.php") as $filename)
{
	require_once($filename);
}

echo "<table border='1'>\n";
echo "\t<tr>" . testMySqlDao() . "</tr>\n";
echo "\t<tr>" . testLocationsProviderImpl() . "</tr>\n";
echo "\t<tr>" . testLocalization() . "</tr>\n";
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