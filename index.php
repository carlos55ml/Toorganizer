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
  include_once __DIR__ . "/app/eventHandler.php";

  // Si el usuario NO esta logeado, redirige a login
  if (!$userObj) {
    header('Location:login.php');
  }
  ?>

  <main>
    <h1>Inicio</h1>
    <?php echo "Bienvenido,  <b>" . $userObj['username']. "</b>"; ?>
    <h3>Estadisticas:</h3>
    <ul>
      <li>Estas participando en <b><?php $eventos = count(fetchParticipantEvents($userObj[0])); echo $eventos? $eventos : "0"; ?></b> evento(s).</li>
      <li>Estas administrando <b><?php $eventos = count(fetchStaffEvents($userObj[0])); echo $eventos? $eventos : "0"; ?></b> evento(s).</li>
      <br>
      <li>Total de eventos actuales: <b><?php $eventos = count(fetchAllEvents()); echo $eventos? $eventos : "0"; ?></b></li>
      <li>Total de usuarios guardados: <b><?php $usuarios = count(fetchAllUsers()); echo $usuarios? $usuarios : "0"; ?></b></li>
    </ul>

    <form action="./app/loginHandler.php?logout=true" method="post">
      <input type="submit" value="Cerrar Sesion">
    </form>
  </main>
</body>

</html>