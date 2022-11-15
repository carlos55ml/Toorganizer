<?php
include __DIR__ . '../app/userHandler.php';

session_start();
$sessionUser = isset($_SESSION['user'])?$_SESSION['user']:"Anonimo";
$userObj = array();

if ($sessionUser !== "Anonimo") {
  $userObj = fetchUser($sessionUser);
}


?>