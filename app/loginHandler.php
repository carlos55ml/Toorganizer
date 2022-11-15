<?php
include __DIR__ . '/userHandler.php';

/**
 * recibe un post y un get.
 * GET['isLogin'] para ver si la peticion es un login. SINO, es un register
 */


$isLogin = isset($_GET['isLogin']) ? $_GET['isLogin'] : false;
$isRegister = isset($_GET['isRegister']) ? $_GET['isRegister'] : false;
$logout = isset($_GET['logout']) ? $_GET['logout'] : false;

if ($logout) {
  session_start();
  $_SESSION['user'] = null;
  session_destroy();
  header("Location:./../../index.php");
}

if ($isLogin) {
  $userName = isset($_POST['usernameLogin']) ? $_POST['usernameLogin'] : null;
  $passwordLogin = isset($_POST['passwordLogin']) ? $_POST['passwordLogin'] : null;

  initSession($userName, $passwordLogin);
} else if ($isRegister) {

  // Recoger variables del formulario
  $userName = isset($_POST['usernameRegister']) ? $_POST['usernameRegister'] : null;
  $passwordRegister = isset($_POST['passwordRegister']) ? $_POST['passwordRegister'] : null;
  $confirmPasswordRegister = isset($_POST['confirmPasswordRegister']) ? $_POST['confirmPasswordRegister'] : null;
  $imgFile = isset($_POST['imgFile']) ? $_POST['imgFile'] : null;

  // Si el usuario no existe, añadirlo a la BBDD.
  if (!fetchUser($userName)) {

    // Si no coinciden, vuelta pa tra
    if ($passwordRegister != $confirmPasswordRegister) {
      header("Location:../register.php?wrongPassword=true");
      return;
    }

    // TODO subir imagen a imgur
    $query = DB::preparedQuery(
      "INSERT INTO users(username, passwd) VALUES (?, ?)",
      array($userName, hash("sha256", $passwordRegister))
    );

    initSession($userName, $passwordRegister);
  }
}

function initSession($userName, $passwordLogin) {
  $logged = tryUserLogin($userName, hash("sha256", $passwordLogin));

  if ($logged === true) {
    // TODO pulir sesion

    session_start();
    $_SESSION['user'] = fetchUser($userName)['username'];

    header("Location:../index.php");
  } else {
    echo "$logged";
  }
}
