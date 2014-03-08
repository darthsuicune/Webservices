<?php
require_once('model/MySqlDao.php');
require_once('model/UsersProviderImpl.php');

require_once("ClientConfiguration.php");
require_once("controller/AndroidClient.php");
require_once("controller/AndroidClientImpl.php");

$clientConfig = new ClientConfiguration();
$androidClient = new AndroidClientImpl($clientConfig->getWebService());
echo $androidClient->handleRequest();
