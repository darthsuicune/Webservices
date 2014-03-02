<?php
include_once('LocationsService.php');
include_once('User.php');

$username = "test1";
$role = "admin";
$email = "meh";
$accessToken = new AccessToken("whatever");
$user = new User($username, $role, $email, $accessToken);

$ls = new LocationsService();
print json_encode($ls->getLocations($user, "1393731020114"));