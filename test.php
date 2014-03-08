<?php
include_once('LocationsService.php');
include_once('User.php');

$name = "test1";
$surname = "test1";
$role = "admin";
$email = "denis@localhost";
$accessToken = new AccessToken("whatever");
$user = new User($name, $surname, $role, $email, $accessToken);

$ls = new LocationsService();

print json_encode($ls->getLocations($user, (isset($_GET['lup'])) ? $_GET['lup'] : 0));

