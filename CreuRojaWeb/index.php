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

$clientConfig = new ClientConfiguration();
$webClient = new WebClientImpl(new MockController());
echo $webClient->handleRequest();
