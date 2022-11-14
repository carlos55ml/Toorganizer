<?php
 include __DIR__ . '/userHandler.php';

/**
 * recibe un post y un get.
 * GET['isLogin'] para ver si la peticion es un login. SINO, es un register
 */


$isLogin = isset($_GET['isLogin'])?$_GET['isLogin']:false;

if ($isLogin) {
  $userName = isset($_POST['usernameLogin'])?$_POST['usernameLogin']:null;
  // TODO password encoding
  $passwordLogin = isset($_POST['passwordLogin'])?$_POST['passwordLogin']:null;
  tryUserLogin($userName, $passwordLogin);
} else {
  // TODO register handler
}
?>