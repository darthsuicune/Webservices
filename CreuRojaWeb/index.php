<?php
require_once('model/MySqlDao.php');
require_once('model/UsersProviderImpl.php');

require_once("ClientConfiguration.php");
require_once("controller/WebClient.php");
require_once("controller/WebClientImpl.php");

$clientConfig = new ClientConfiguration();
$webClient = new WebClientImpl($clientConfig->getWebService());
echo $webClient->handleRequest();