<?php
class Root {
	const MAP = "map";
	const ABOUT = "about";
	const CONTACT = "contact";
	const LOGIN = "login";

	var $user;
	var $hasNotice = false;

	public function __construct(User $user = null) {
		$this->user = $user;
	}

	public function setUser(User $user = null){
		$this->user = $user;
	}

	public function showRoot(Content $content, Notice $notice = null) {
		if ($notice) {
			$this->hasNotice = count($notice->notices) > 0;
		}
		$isMap = $content instanceof Map;
		?>
<!DOCTYPE html>
<HTML>
<head>
<link rel="shortcut icon" href="view/icons/favicon.ico" />
<?php
$content->getHtmlHeaders(); 
?>
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="view/css/main.css" rel="stylesheet" type="text/css" />
<title><?php 
echo $_SESSION[SessionsController::LANGUAGE]->get(Strings::WEB_TITLE);
?>
</title>
</head>

<BODY <?php if($isMap) { echo 'onload="initialize()"'; }?>>
	<?php
	$content->showContent($notice);
	?>
</BODY>
</HTML>
<?php }
} ?>