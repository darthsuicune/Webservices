<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<title>Mapa de Creu Roja Barcelona</title>
</head>
<body>
	<h2>Recuperar contrasenya</h2>
	<form accept-charset="utf8" target="_self" autocomplete="off"
		method="POST" action="?q=recoverPassword" name="PassRecover">
		<input hidden="hidden" name="email" value="<?php echo $_GET['email']; ?>"/>
		Contrasenya: <input autocomplete="off" maxlength="60"
			required="required" name="password" type="password"><br>
		Confirmeu contrasenya: <input maxlength="60" required="required"
			name="confirmpass" type="password"><br> <br> <input
			form="register" name="submit" value="Enviar" type="submit"><br>
	</form>
	<p>
		<br>
	</p>
</body>
</html>
