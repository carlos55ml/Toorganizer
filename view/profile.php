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
$id = isset($_GET['id'])?$_GET['id']:null;

// si no pasamos id por GET, esta sera la id del usuario logueado.
if (is_null($id)) {
  $id = $userObj['user_id'];
}

// el usuario a mostrar
$targetUserObj = fetchUserId($id);

// TODO mostrar datos usuario

?>

<div class="bg-img"></div>

<main>
  <?php
  echo $targetUserObj['username'];
  ?>
</main>
</body>
</html>