<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="icon" href="icons/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="icons/favicon.ico" type="image/x-icon"/>
    <title>Creu Roja Barcelona</title>
  </head>
  <body>
    <center><br><img src="icons/logo.png"><br><br><br><br>
    <?php
    if ($error) {
    ?>
    <div class="error_message">
    <strong><?php echo $error; ?></strong>
    </div>
    <?php
    }
    ?>
    <br>
    <form accept-charset="utf8" novalidate="novalidate" autocomplete="on"
      method="POST" action="?q=login" name="Login"> 
      Correu electrònic: <input required="required"
        name="email" type="text"><br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contrasenya: <input autocomplete="off" required="required" name="password" type="password"><br><br>
      <input name="send" value="Iniciar sessió" type="submit">
    </form>
    <p><br><br>
    Aquest mapa fa servir cookies per millorar l'experiència d'ús, si inicies sessió entenem que acceptes l'ús de cookies.
    </p>
    <p>
    <a href="http://testing.r0uzic.net/password_reset/new">Ha oblidat la seva contrasenya?</a>
  </body>
</html>
