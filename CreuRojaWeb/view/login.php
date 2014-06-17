<?php class Login implements Content {
	
	public function showContent(Notice $notice = null) {
		$lang = $_SESSION[SessionsController::LANGUAGE];
		$hasNotice = count($notice) > 0;
		?>
<div id="content">
	<div class="logo">
		<img src="view/icons/logo.png">
	</div>
	<?php 
		if($hasNotice){
			$notice->showNotice();
		} ?>
	<div class="login_form">
		<form accept-charset="utf8" novalidate="novalidate" autocomplete="on"
			method="POST" action="?q=login" name="Login">
			<label for="email"> <?php echo $lang->get(Strings::E_MAIL); ?>: </label> 
			<input required="required" name="email" type="text" /> 
			<label for="password"><?php echo $lang->get(Strings::PASSWORD); ?>: </label>
			<input autocomplete="off" required="required" name="password" type="password" /> 
			<input name="send" value="<?php echo $lang->get(Strings::LOGIN_BUTTON); ?>" type="submit" />
		</form>
	</div>
	<div class="password_recovery">
		<p>
			<a href="?q=recoverPassword"> <?php 
				echo $lang->get(Strings::RECOVER_PASSWORD); ?>
			</a>
		</p>
	</div>
	<div class="cookies_warning">
		<p>
			<?php echo $lang->get(Strings::COOKIES_WARNING); ?>
		</p>
	</div>
</div>
<?php 
		$footer = new Footer();
		$footer->showFooter();
	}
	
	public function getHtmlHeaders() { ?>
<meta content="text/html; charset=UTF-8" http-equiv="content-type" />
<link href="view/css/notice.css" rel="stylesheet" type="text/css" />
	<?php }
}?>