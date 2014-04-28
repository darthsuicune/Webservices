<?php
const DB_ADDRESS = "address";
const DB_USERNAME = "username";
const DB_PASSWORD = "password";
const DB_CONFIRM_PASSWORD = "confirmPassword";
const DB_DATABASE = "database";

require_once("l10n/Strings.php");
require_once('view/notice.php');
require_once('model/DataStorage.php');
require_once('model/MySqlDao.php');
foreach (glob("install/*.php") as $filename)
{
	require_once($filename);
}

if(!file_exists("config.php")){ //TODO Remove ! mark
	header("Location: index.php");
} else {
	$language = Strings::getDefaultLanguage();

	if(isset($_POST[DB_ADDRESS]) && isset($_POST[DB_DATABASE])
			&& isset($_POST[DB_USERNAME]) && isset($_POST[DB_PASSWORD])
			&& isset($_POST[DB_CONFIRM_PASSWORD])) {
		doInstall($language);
	} else {
		showInstallForm($language);
	}
}

function doInstall($language) {
	$lang = new Strings($language);

	$address = $_POST[DB_ADDRESS];
	$database = $_POST[DB_DATABASE];
	$username = $_POST[DB_USERNAME];
	$password = $_POST[DB_PASSWORD];
	$confirmPassword = $_POST[DB_CONFIRM_PASSWORD];

	$errors = array();
	if($address == "") {
		if(count($errors) == 0) {
			$errors[] = Notice::NOTICE_TYPE_ERROR;
		}
		$errors[] = $lang->get(Strings::INSTALL_ERROR_EMPTY_ADDRESS);
	}
	if($database == "") {
		if(count($errors) == 0) {
			$errors[] = Notice::NOTICE_TYPE_ERROR;
		}
		$errors[] = $lang->get(Strings::INSTALL_ERROR_EMPTY_DATABASE);
	}
	if($username == "") {
		if(count($errors) == 0) {
			$errors[] = Notice::NOTICE_TYPE_ERROR;
		}
		$errors[] = $lang->get(Strings::INSTALL_ERROR_EMPTY_USERNAME);
	}
	if($password == "") {
		if(count($errors) == 0) {
			$errors[] = Notice::NOTICE_TYPE_ERROR;
		}
		$errors[] = $lang->get(Strings::INSTALL_ERROR_EMPTY_PASSWORD);
	}
	if($confirmPassword == "") {
		if(count($errors) == 0) {
			$errors[] = Notice::NOTICE_TYPE_ERROR;
		}
		$errors[] = $lang->get(Strings::INSTALL_ERROR_EMPTY_PASSWORD_CONFIRMATION);
	}
	if(strcmp($password, $confirmPassword) != 0) {
		if(count($errors) == 0) {
			$errors[] = Notice::NOTICE_TYPE_ERROR;
		}
		$errors[] = $lang->get(Strings::INSTALL_ERROR_PASSWORDS_DONT_MATCH);
	}

	if(count($errors) > 0) {
		showInstallForm($language, $errors);
	} else {
		if(initializeDb($address, $database, $username, $password)){
			writeData($address, $database, $username, $password);
			require_once("welcome.php");
			showFirstLogin($address, $database, $username, $password, $lang);
		} else {
			$errors[] = Notice::NOTICE_TYPE_ERROR;
			$errors[] = $lang->get(Strings::INSTALL_ERROR_CANNOT_CONNECT);
			showInstallForm($language, $errors);
		}
	}
}

function writeData($address, $database, $username, $password) {
	$filename = "config.php";
	$data = '<?php

	$DB_ADDRESS = "' . $address . '"
	$DB_DATABASE = "' . $database . '"
	$DB_USERNAME = "' . $username . '"
	$DB_PASSWORD = "' . $password . '"
	$CHARSET = "UTF8"';

	print $data;
}

function initializeDb($address, $database, $username, $password){
	$dsn = "mysql:dbname=$database;host=$address;charset=UTF8";
	try {
		$pdo = new PDO($dsn, $username, $password);
		$statement = readfile("db/installscript");
		$pdo->exec($statement);
		return true;
	} catch (PDOException $e) {
		error_log($e->getMessage());
		return false;
	}
}

function showInstallForm($language, $errors = array()) {
	$lang = new Strings($language);
	$hasErrors = count($errors) > 0;
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
</HTML>
<?php 
} ?>