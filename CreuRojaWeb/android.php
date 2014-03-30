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
require_once('AndroidClient.php');

// $clientConfig = new ClientConfiguration(ClientConfiguration::ANDROID);
// $androidClient = $clientConfig->getClient();
$androidClient = new AndroidClient();
echo $androidClient->handleRequest();
