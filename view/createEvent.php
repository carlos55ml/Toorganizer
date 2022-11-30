<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Evento - Toorganizer</title>
  <link rel="stylesheet" href="/style.css">
</head>

<body>
  <?php
  include __DIR__ . '/../modules/header.php';

  // Si el usuario no esta logeado, redirige a index
  if (!$userObj['username']) {
    header('Location:/index.php');
  }
  ?>

  <main>
    <form action="/app/eventHandler.php?isCreate=true" method="post" class="userForm" enctype="multipart/form-data">
      <h1>Crear Evento</h1>
      <label for="eventName" class="col-30">Nombre del evento: </label>
      <input type="text" class="col-60" name="eventName" id="eventName">
      <br>
      <label for="eventGameName" class="col-30">Nombre del juego: </label>
      <input type="text" class="col-60" name="eventGameName" id="eventGameName">
      <br>
      <label for="imgFile" class="col-30">Logo del evento: </label>
      <input type="file" class="col-60" name="imgFile" id="imgFile" accept=".png, .jpg, .jpeg">
      <br>
      <input type="number" name="ownerId" hidden value=<?php echo $userObj['user_id'] ?>>
      <div class="center">
        <button type="submit" id="btnLogin">Crear Evento</button>
      </div>
    </form>
  </main>
</body>

</html>