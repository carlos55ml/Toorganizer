<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio - Toorganizer</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php
  include __DIR__ . '/modules/header.php';

  // Si el usuario NO esta logeado, redirige a login
  if (!$userObj) {
    header('Location:login.php');
  }
  ?>
  <h1>Inicio</h1>
  <?php
  if ($userObj) {
    echo "bienvenido ". $userObj['username'];
  } else {
    header("Location:login.php");
  }
  ?>

  <form action="./app/loginHandler.php?logout=true" method="post">
    <input type="submit" value="Cerrar Sesion">
  </form>
</body>

</html>