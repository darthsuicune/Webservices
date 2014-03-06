<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<title>Mapa de Creu Roja Barcelona</title>
</head>
<body>
	<h2>Registre de nou usuari</h2>
	<form accept-charset="utf8" autocomplete="off" method="POST"
		action="?q=register" name="Register">
		Correu electrònic: <input
			autocomplete="on"
			pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"
			maxlength="80" required="required" name="email" type="email"><br>
		<h4>Avís: Ara et demanarem la contrasenya per aquest mapa. Recomanem que utilitzis una contrasenya diferent del teu correu electrònic o xarxes socials.</h4>
		<?php 
			echo "<input type=\"hidden\" name=\"name\" value=\"" . $_POST[Index::NAME]. "\" >\n";
			echo "<input type=\"hidden\" name=\"surname\" value=\"" . $_POST[Index::SURNAME]. "\" >\n";
			echo "<input type=\"hidden\" name=\"roles\" value=\"" . $_POST[Index::ROLES]. "\" >\n";
		?>

		Contrasenya: <input autocomplete="off"
			maxlength="60" required="required" name="password" type="password"><br>
		Confirmeu contrasenya: <input maxlength="60" required="required"
			name="confirmpass" type="password"><br> <br>
			 
			<input name="send" type="submit"><br>
	</form>
</body>
</html>