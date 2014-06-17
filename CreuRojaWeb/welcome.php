<?php
function showFirstLogin($address, $database, $username, $password, $lang) {
	
?>
<!DOCTYPE html>
<HTML>
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="view/css/install.css" rel="stylesheet" type="text/css" />
<link href="view/css/notice.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="view/icons/favicon.ico" />
<title><?php echo $lang->get(Strings::INSTALL_TITLE); ?></title>
</head>
<BODY>
	<div class="logo">
		<img src="view/icons/logo.png">
	</div>
	<div class="title">
		<h1>
			<?php echo $lang->get(Strings::INSTALL_TITLE); ?>
		</h1>
	</div>
	<?php
	if ($hasErrors) {
		$notice = new Notice($lang, $errors);
		$notice->showNotice();
	}
	?>
	<div id="install_form">
		<form accept-charset="utf8" novalidate="novalidate" autocomplete="on" method="POST"
			action="install.php" name="Login">
			<label for="<?php echo DB_ADDRESS; ?>"> 
					<?php echo $lang->get(Strings::INSTALL_ADDRESS); ?>:</label> 
			<input required="required" name="<?php echo DB_ADDRESS; ?>" type="text" 
					value="<?php echo (isset($_POST[DB_ADDRESS])) ? $_POST[DB_ADDRESS] : "localhost";?>" />
			<label for="<?php echo DB_DATABASE; ?>"> 
					<?php echo $lang->get(Strings::INSTALL_DATABASE); ?>:</label> 
			<input required="required" name="<?php echo DB_DATABASE; ?>" type="text" 
					value="<?php echo (isset($_POST[DB_DATABASE])) ? $_POST[DB_DATABASE] : "creuroja";?>" />  
			<label for="<?php echo DB_USERNAME; ?>"> 
					<?php echo $lang->get(Strings::INSTALL_USERNAME); ?>:</label> 
			<input required="required" name="<?php echo DB_USERNAME; ?>" type="text" 
					value="<?php echo (isset($_POST[DB_USERNAME])) ? $_POST[DB_USERNAME] : ""; ?>"/> 
			<label for="<?php echo DB_PASSWORD; ?>">
					<?php echo $lang->get(Strings::INSTALL_PASSWORD); ?>: </label> 
			<input autocomplete="off" required="required" name="<?php echo DB_PASSWORD; ?>" 
					type="password" /> 
			<label for="<?php echo DB_CONFIRM_PASSWORD; ?>">
					<?php echo $lang->get(Strings::INSTALL_CONFIRM_PASSWORD); ?>: </label> 
			<input autocomplete="off" required="required" name="<?php echo DB_CONFIRM_PASSWORD; ?>" 
					type="password" /> 
			<input name="send" value="<?php echo $lang->get(Strings::INSTALL_BUTTON); ?>" type="submit" />
		</form>
	</div>
</BODY>
</HTML><?php }
?>