<?php
 include __DIR__ . '/userHandler.php';

/**
 * recibe un post y un get.
 * GET['isLogin'] para ver si la peticion es un login. SINO, es un register
 */


$isLogin = isset($_GET['isLogin'])?$_GET['isLogin']:false;
$logout = isset($_GET['logout'])?$_GET['logout']:false;

if ($logout) {
  session_start();
  $_SESSION['user'] = null;
  session_destroy();
  header("Location:./../../index.php");
}

if ($isLogin) {
  $userName = isset($_POST['usernameLogin'])?$_POST['usernameLogin']:null;
  // TODO password encoding
  $passwordLogin = isset($_POST['passwordLogin'])?$_POST['passwordLogin']:null;
  $logged = tryUserLogin($userName, $passwordLogin);

  if($logged === true) {
    // TODO pulir sesion

    session_start();
    $_SESSION['user'] = fetchUser($userName)['username'];
    
    header("Location:../index.php");
  } else {
    echo "$logged";
  }
} else {
  // TODO register handler
}
?>