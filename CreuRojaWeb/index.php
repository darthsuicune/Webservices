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
require_once('Client.php');
require_once('WebClient.php');

session_start();

// $clientConfig = new ClientConfiguration(ClientConfiguration::WEB);
// $webClient = $clientConfig->getClient();
$webClient = new WebClient();
$webClient->handleRequest();