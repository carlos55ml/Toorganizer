<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Toorganizer</title>
</head>

<body>
  <h1>Register</h1>

  <?php
  // Comprobar si las contraseñas no coinciden despues de intentar registrarse
  $wrongPassword = isset($_GET['wrongPassword']) ? $_GET['wrongPassword'] : null;

  if ($wrongPassword) { ?>
    <h3>ERROR: Las contraseñas no coinciden</h3>
  <?php } ?>

  <!-- TODO pagina Register -->
  <form action="./app/loginHandler.php?isRegister=true" method="post" id="RegisterForm">
    <label for="usernameRegister">Nombre de usuario: </label>
    <input type="text" name="usernameRegister" id="usernameRegister" required>
    <br>
    <label for="passwordRegister">Contraseña: </label>
    <input type="password" name="passwordRegister" id="passwordRegister" required>
    <br>
    <label for="confirmPasswordRegister">Repetir contraseña: </label>
    <input type="password" name="confirmPasswordRegister" id="confirmPasswordRegister" required>
    <br>
    <label for="imgFile">Foto de perfil: </label>
    <input type="file" name="imgFile" id="imgFile">
    <br>
    <a href="login.html"><button type="button">Inicia Sesion</button></a>
    <input type="submit" value="Registrarse" id="btnRegister">
  </form>
</body>

</html>