<?php
require_once("controller/AndroidClient.php");
require_once("controller/AndroidClientImpl.php");

$androidClient = new AndroidClientImpl();
return $androidClient->handleRequest();