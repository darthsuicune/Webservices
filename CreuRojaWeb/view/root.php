<?php
class Root {
	var $isMap = false;
	var $languages;
	var $user = false;
	var $hasError;
	var $errors = array();
	
	public function __construct() {
		$this->languages = new Strings(Strings::ENGLISH);
		if (isset($_SESSION['user'])) {
			$this->user = $_SESSION['user'];
		}
	}
	
	public function showRoot() { 
?>

<!DOCTYPE html>
<HTML>
<head>
<link rel="shortcut icon" href="view/icons/favicon.ico" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<?php if ($this->isMap) { ?>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<?php require_once('scripts/gmaps.php');
		} else { ?>
<meta content="text/html; charset=UTF-8" http-equiv="content-type" />
<?php } ?>
<link href="view/css/main.css" rel="stylesheet" type="text/css" />
<title><?php 
echo $this->languages->get(Strings::WEB_TITLE);
?>
</title>
</head>

<BODY <?php if($this->isMap) { echo 'onload="initialize()"'; }?>>
	<?php
	require_once('header.php');
	
	if(isset($_GET['q']) && strcmp($_GET['q'], "about") == 0) {
		require_once('static/about.php');
	} else if(isset($_GET['q']) && strcmp($_GET['q'], "contact") == 0) {
		require_once('static/contact.php');
	} else if($this->isMap) {
		require_once('map.php');
	} else {
		require_once('login.php');
	}
	require_once('footer.php');
	?>
</BODY>
</HTML>
<?php }
} ?>