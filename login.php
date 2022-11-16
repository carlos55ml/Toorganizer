<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Toorganizer</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
  include __DIR__ . '/modules/header.php';

  // Si el usuario esta logeado, redirige a index
  if (isset($userObj['user'])) {
    header('Location:index.php');
  }
  ?>

  <h1>Login</h1>
  <!-- TODO pagina login -->
  <!-- POST a loginHandler.php (revisar para nombre campos) -->
  <form action="./app/loginHandler.php?isLogin=true" method="post" class="userForm">
    <label for="usernameLogin">Nombre de usuario: </label>
    <input type="text" name="usernameLogin" id="usernameLogin">
    <br>
    <label for="passwordLogin">Contraseña: </label>
    <input type="password" name="passwordLogin" id="passwordLogin">
    <br>
    <input type="submit" value="Inicia Sesion" id="btnLogin">
    <a href="register.php"><button id="btnToRegister" type="button">Registrate</button></a>
  </form>
</body>
</html>