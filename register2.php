<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<title>register</title>
</head>
<body>
	<h2>Register</h2>
	<form accept-charset="utf8" autocomplete="off" method="POST"
		action="?q=register" name="Register">
		email: <input
			autocomplete="on"
			pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"
			maxlength="80" required="required" name="email" type="email"><br>
		<h4>Hint: Enter a new password for this service. It is suggested that is not shared with other services, such as mail or social networks.</h4>
		<h4>We are *NOT* asking for your e-mail password.</h4>
		<?php 
			putHiddenFields();
		?>

		password: <input autocomplete="off"
			maxlength="60" required="required" name="password" type="password"><br>
		confirm password: <input maxlength="60" required="required"
			name="confirmpass" type="password"><br> <br>
			 
			<input name="send" type="submit"><br>
	</form>
</body>
</html>
<?php 
function putHiddenFields(){
	echo "<input type=\"hidden\" name=\"name\" value=\"" . $_POST[Index::NAME]. "\" >";
	echo "<input type=\"hidden\" name=\"surname\" value=\"" . $_POST[Index::SURNAME]. "\" >";
	echo "<input type=\"hidden\" name=\"roles\" value=\"" . $_POST[Index::ROLES]. "\" >";
}