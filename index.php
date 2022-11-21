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
  <div class="bg-img"></div>

  <?php
  include __DIR__ . '/modules/header.php';

  // Si el usuario NO esta logeado, redirige a login
  if (!$userObj) {
    header('Location:login.php');
  }
  ?>

  <main>
    <h1>Inicio</h1>
    <?php echo "bienvenido " . $userObj['username']; ?>

    <form action="./app/loginHandler.php?logout=true" method="post">
      <input type="submit" value="Cerrar Sesion">
    </form>
  </main>
</body>

</html>