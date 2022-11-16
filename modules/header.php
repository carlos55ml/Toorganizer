<?php
include __DIR__ . '/../app/userHandler.php';

session_start();
$sessionUser = isset($_SESSION['user']) ? $_SESSION['user'] : "Anonimo";

$userObj = $sessionUser !== "Anonimo" ? fetchUser($sessionUser) : null;
?>

<header>
  <div class="imgHeader">Toorganizer</div>
  <nav>
    <a href="index.php">Inicio</a>
    <?php
    if (isset($sessionUser['user'])) {
      echo "<a href='profile.php'>Perfil</a>";
      echo "<a href='#'>Cerrar sesión</a>";
    } else {
      echo "<a href='login.php'>Login</a>";
    }
    ?>
  </nav>
</header>