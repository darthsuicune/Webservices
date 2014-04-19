<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<?php
$languages = new Strings();
$user = false;
if (isset($_SESSION['user'])) {
	$user = $_SESSION['user'];
}
require_once('header.php');
?>
<BODY>
	<?php
	if ($user && $user->isAllowedTo(Actions::SIDEBAR)) {
		require_once('sidebar.php');
	}
	?>
	<div class="content">
		<center>
			<br> <img src="view/icons/logo.png"><br> <br> <br> <br>
			<form accept-charset="utf8" novalidate="novalidate" autocomplete="on"
				method="POST" action="?q=login" name="Login">
				<?php echo $languages->get(Strings::E_MAIL); ?>
				: <input required="required" name="email" type="text"><br>
				<?php echo $languages->get(Strings::PASSWORD); ?>
				: <input autocomplete="off" required="required" name="password"
					type="password"> <br> <br> <input name="send"
					value="<?php echo $languages->get(Strings::LOGIN); ?>"
					type="submit">
			</form>
			<p>
				<br> <br><?php echo $languages->get(Strings::COOKIES_WARNING); ?> 
			</p>
			<p>
				<a href="?q=recoverPassword">
				<?php echo $languages->get(Strings::RECOVER_PASSWORD); ?></a>
			</p>
		</center>
	</div>
	<?php 
	require_once('footer.php');
	?>
</BODY>
</HTML>
