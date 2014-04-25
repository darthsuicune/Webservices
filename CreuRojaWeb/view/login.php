<div id="content">
	<div class="logo">
		<img src="view/icons/logo.png">
	</div>
	<?php if($this->hasErrors){
		require_once('error.php');
	} ?>
	<div class="login_form">
		<form accept-charset="utf8" novalidate="novalidate" autocomplete="on"
			method="POST" action="?q=login" name="Login">
			<label for="email"> <?php echo $this->languages->get(Strings::E_MAIL); ?>:
			</label> <input required="required" name="email" type="text" /> <label
				for="password"><?php echo $this->languages->get(Strings::PASSWORD); ?>: </label>
			<input autocomplete="off" required="required" name="password"
				type="password" /> <input name="send"
				value="<?php echo $this->languages->get(Strings::LOGIN_BUTTON); ?>"
				type="submit" />
		</form>
	</div>
	<div class="password_recovery">
		<p>
			<a href="?q=recoverPassword"> <?php 
				echo $this->languages->get(Strings::RECOVER_PASSWORD); ?>
			</a>
		</p>
	</div>
	<div class="cookies_warning">
		<p>
			<?php echo $this->languages->get(Strings::COOKIES_WARNING); ?>
		</p>
	</div>
</div>
