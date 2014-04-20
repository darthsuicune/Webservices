<?php
$isMap = false;
$languages = new Strings(Strings::ENGLISH);
$user = false;
if (isset($_SESSION['user'])) {
	$user = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<HTML>
	<head>
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<?php if ($isMap) { ?>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<?php require_once('scripts/gmaps.php');
		} else { ?>
		<meta content="text/html; charset=UTF-8" http-equiv="content-type" />
		<?php } ?>
		<link href="view/css/main.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="view/icons/favicon.ico" />
		<title><?php 
		$strings = new Strings();
		echo $strings->get(Strings::WEB_TITLE);
		?></title>
	</head>
	
	<BODY <?php if($isMap) { echo 'onload="initialize()"'; }?>>
		<?php
		require_once('header.php');
		if($isMap) {
			require_once('map.php');
		} else {
			require_once('login.php');
		}
		require_once('footer.php');
		?>
	</BODY>
</HTML>
