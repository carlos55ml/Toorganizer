<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil - Toorganizer</title>
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <?php
  include __DIR__ . '/../modules/header.php';
  if (!$userObj) {
    header('Location:/login.php');
  }

  // pasamos id del usuario que queremos ver por GET
  $id = isset($_GET['id']) ? $_GET['id'] : null;
  $isAdmin = $userObj['isAdmin'];
  // si no pasamos id por GET, esta sera la id del usuario logueado.
  if (is_null($id)) {
    $targetUserObj = $userObj;
  } else {
    // el usuario a mostrar
    if ($isAdmin) {
      $targetUserObj = fetchUserId($id);
    } else {
      header("Location:/view/profile.php");
    }
  }
  ?>

  <main>
    <?php if (!is_null($targetUserObj)) { ?>
      <form action="" class="userForm">
        <img class="img-round" src="<?php echo $targetUserObj['avatar_url']; ?>" alt="Avatar de usuario" class="user-avatar-view">
        <h1>Perfil: <span><?php echo $targetUserObj['username']; ?></span></h1>
        <label for="usernameField" class="col-30">Nombre de usuario: </label>
        <input type="text" name="usernameField" id="usernameField" class="col-60" disabled value="<?php echo $targetUserObj['username']; ?>">
        <br>
        <label for="imgUrl" class="col-30">URL de avatar: </label>
        <input type="text" name="imgUrl" id="imgUrl" class="col-60" disabled value="<?php echo $targetUserObj['avatar_url']; ?>">
        <br>
        <label for="esAdmin" class="col-30">Es admin: </label>
        <input type="text" name="esAdmin" id="esAdmin" class="col-60" disabled value="<?php echo $targetUserObj['isAdmin'] ? "Si." : "No."; ?>">
        <!-- // TODO mostrar eventos activos que participa. -->
      </form>
    <?php } else { ?>
      <form action="" class="userForm">
        <h1>Usuario no encontrado...</h1>
      </form>
    <?php } ?>
  </main>
</body>

</html>