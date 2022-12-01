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
  header("Location:./../index.php");
}

if ($isLogin) {
  $userName = isset($_POST['usernameLogin']) ? xss_clean($_POST['usernameLogin']) : null;
  $passwordLogin = isset($_POST['passwordLogin']) ? xss_clean($_POST['passwordLogin']) : null;

  if (is_null($userName) or is_null($passwordLogin)) {
    setcookie("errorMessage", "No se han rellenado todos los campos.", 0, "/");
    header("Location:/error.php");
  }

  initSession($userName, $passwordLogin);
} 

if ($isRegister) {
  // Recoger variables del formulario
  $userName = isset($_POST['usernameRegister']) ? xss_clean($_POST['usernameRegister']) : null;
  $passwordRegister = isset($_POST['passwordRegister']) ? xss_clean($_POST['passwordRegister']) : null;
  $confirmPasswordRegister = isset($_POST['confirmPasswordRegister']) ? xss_clean($_POST['confirmPasswordRegister']) : null;

  if (is_null($userName) or is_null($passwordRegister) or is_null($confirmPasswordRegister)) {
    setcookie("errorMessage", "No se han rellenado todos los campos.", 0, "/");
    header("Location:/error.php");
  }

  // Si el usuario no existe, añadirlo a la BBDD.
  if (!fetchUser($userName)) {

    // Si no coinciden, vuelta pa tra
    if ($passwordRegister != $confirmPasswordRegister) {
      header("Location:../register.php?wrongPassword=true");
      return;
    }

    $avatarUrl = uploadAvatar();
    if (is_null($avatarUrl)) {
      $query = DB::preparedQuery(
        "INSERT INTO users(username, passwd) VALUES (?, ?)",
        array($userName, hash("sha256", $passwordRegister))
      );
    } else {
      $query = DB::preparedQuery(
        "INSERT INTO users(username, passwd, avatar_url) VALUES (?, ?, ?)",
        array($userName, hash("sha256", $passwordRegister), $avatarUrl)
      );
    }

    initSession($userName, $passwordRegister);
  } else {
    setcookie("errorMessage", "El usuario ya existe.", 0, "/");
    header("Location:/error.php");
  }
}

/**
 * Funcion para iniciar sesion en la pagina web.
 * @param string $username Username.
 * @param string $password Password.
 */
function initSession($username, $password) {
  $logged = tryUserLogin($username, hash("sha256", $password));

  if ($logged === true) {
    session_start();
    $_SESSION['user'] = fetchUser($username)['username'];

    header("Location:../index.php");
  } else {
    setcookie("errorMessage", $logged, 0, "/");
    header("Location:/error.php");
  }
}

