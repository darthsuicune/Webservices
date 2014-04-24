<?php
class Root {
	const MAP = "map";
	const ABOUT = "about";
	const CONTACT = "contact";
	const LOGIN = "login";

	var $languages;
	var $user;
	var $hasError = false;
	var $errors = array();

	public function __construct(Strings $lang, User $user = null) {
		$this->languages = $lang;
		$this->user = $user;
	}

	public function showRoot($type = self::LOGIN) {
		?>

<!DOCTYPE html>
<HTML>
<head>
<link rel="shortcut icon" href="view/icons/favicon.ico" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<?php if (strcmp($type, self::MAP) == 0) { ?>
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

<BODY
<?php if(strcmp($type, self::MAP) == 0) { echo 'onload="initialize()"'; }?>>
	<?php
	require_once('header.php');

	if($this->user) {
		switch($type){
			case self::ABOUT:
				require_once('static/about.php');
				break;
			case self::CONTACT:
				require_once('static/contact.php');
				break;
			case self::LOGIN:
				require_once('login.php');
				break;
			case self::MAP:
				require_once('map.php');
				break;
			default:
				require_once('login.php');
				break;
		}
	} else {
		require_once('login.php');
	}
	require_once('footer.php');
	?>
</BODY>
</HTML>
<?php }
} ?>