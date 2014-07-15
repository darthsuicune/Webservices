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
require_once('ClientConfiguration.php');
require_once('AndroidClient.php');

$clientConfig = new ClientConfiguration();
$androidClient = $clientConfig->getClient(ClientConfiguration::ANDROID);


