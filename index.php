<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio - Toorganizer</title>
</head>
<body>
  <?php
  // TODO check sesion
  // Revisar si hay sesion activa, si no, redirige a LOGIN.HTML
  session_start();
  $user = isset($_SESSION['user'])?$_SESSION['user']:null;
  ?>
  <h1>Inicio</h1>
  <?php
  if ($user) {
    echo "bienvenido $user";
  } else {
    header("Location:login.html");
  }
  ?>
  
  <form action="./app/loginHandler.php?logout=true" method="post">
    <input type="submit" value="Cerrar Sesion">
  </form>
</body>
</html>