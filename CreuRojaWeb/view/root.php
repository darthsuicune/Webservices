<?php
class Root {
	const MAP = "map";
	const ABOUT = "about";
	const CONTACT = "contact";
	const LOGIN = "login";

	var $languages;
	var $user;
	var $hasErrors = false;
	var $errors = array();

	public function __construct(Strings $lang, User $user = null) {
		$this->languages = $lang;
		$this->user = $user;
	}
	
	public function setUser(User $user){
		$this->user = $user;
	}

	public function showRoot($type = self::LOGIN, $hasErrors = false, array $errors = null) {
		if($hasErrors) {
			$this->hasErrors = $hasErrors;
			$this->errors = $errors;
		}
		$isMap = strcmp($type, self::MAP) == 0;
		?>

<!DOCTYPE html>
<HTML>
<head>
<link rel="shortcut icon" href="view/icons/favicon.ico" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<?php if ($isMap) { ?>
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

<BODY <?php if($isMap) { echo 'onload="initialize()"'; }?>>
	<?php
	require_once('header.php');

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

	require_once('footer.php');
	?>
</BODY>
</HTML>
<?php }
} ?>