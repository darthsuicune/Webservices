<?php
$JQUERY = 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js';

$language = new Strings();

$user = false;
if (isset($_SESSION['user'])) {
	$user = $_SESSION['user'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"
	charset="utf-8" />
<link rel="shortcut icon" href="'. $this->getFavIcon() . '" />
<title><?php echo $language->get(Strings::WEB_TITLE) ?>
</title>
<?php
require_once('css/map.css');
?>
<script src="<?php echo $JQUERY; ?>"></script>
<?php 
require_once('scripts/gmaps.php')
?>
</HEAD>
<BODY>
	<?php
	if ($user && $user->isAllowedTo(Actions::SIDEBAR)) {
		require_once('sidebar.php');
	}
	?>
	<div class="content"></div>
	<?php 
	require_once('footer.php');
	?>
</BODY>
</HTML>
