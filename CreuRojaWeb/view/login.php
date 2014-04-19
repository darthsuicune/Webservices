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
	// 	if ($user && $user->isAllowedTo(Actions::MENU)) {
	require_once('menu.php');
	// 	}
	?>
	<div class="content">
		<div class="logo">
			<img src="view/icons/logo.png">
		</div>
		<div class="login_form">
			<form accept-charset="utf8" novalidate="novalidate" autocomplete="on"
				method="POST" action="?q=login" name="Login">
				<label for="email"> <?php echo $languages->get(Strings::E_MAIL); ?>:
				</label> 
				<input required="required" name="email" type="text" />
				<label for="password"><?php echo $languages->get(Strings::PASSWORD); ?>:
				</label> 
				<input autocomplete="off" required="required" name="password" 
					type="password" />
				<input name="send"
					value="<?php echo $languages->get(Strings::LOGIN); ?>"
					type="submit" />
			</form>
		</div>
		<div class="password_recovery">
			<p>
				<a href="?q=recoverPassword"> <?php 
				echo $languages->get(Strings::RECOVER_PASSWORD); ?>
				</a>
			</p>
		</div>
		<div class="cookies_warning">
			<p>
				<?php echo $languages->get(Strings::COOKIES_WARNING); ?>
			</p>
		</div>
	</div>
	<?php 
	require_once('footer.php');
	?>
</BODY>
</HTML>
