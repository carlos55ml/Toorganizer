<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Toorganizer</title>
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

  <?php
  // Comprobar si las contraseñas no coinciden despues de intentar registrarse
  $wrongPassword = isset($_GET['wrongPassword']) ? $_GET['wrongPassword'] : null;

  if ($wrongPassword) { ?>
    <h3>ERROR: Las contraseñas no coinciden</h3>
  <?php } ?>

  <!-- TODO pagina Register -->
  <form action="./app/loginHandler.php?isRegister=true" method="post" id="RegisterForm" class="userForm" enctype="multipart/form-data">
    <h1>Register</h1>

    <label for="usernameRegister" class="col-30">Nombre de usuario: </label>
    <input type="text" class="col-60" name="usernameRegister" id="usernameRegister" required>
    <br>
    <label for="passwordRegister" class="col-30">Contraseña: </label>
    <input type="password" class="col-60" name="passwordRegister" id="passwordRegister" required>
    <br>
    <label for="confirmPasswordRegister" class="col-30">Repetir contraseña: </label>
    <input type="password" class="col-60" name="confirmPasswordRegister" id="confirmPasswordRegister" required>
    <br>
    <label for="imgFile" class="col-30">Foto de perfil: </label>
    <input type="file" class="col-60" name="imgFile" id="imgFile" accept=".png, .jpg, .jpeg">
    <br>
    <div class="center">
      <a href="login.php"><button type="button">Inicia Sesion</button></a>
      <input type="submit" value="Registrarse" id="btnRegister">
    </div>
  </form>
</body>

</html>