<?php
include __DIR__ . '/../app/userHandler.php';

session_start();
$sessionUser = isset($_SESSION['user']) ? $_SESSION['user'] : "Anonimo";

$userObj = $sessionUser !== "Anonimo" ? fetchUser($sessionUser) : null;
?>

<header>
  <?php
  if (isset($userObj)) {
  ?>
    <a href="/view/profile.php">
      <div id="userBox">
        <p id="username"><?php echo $userObj['username'] ?></p>
        <img id="imgUser" src=<?php echo getAvatarUrl($userObj['username']) ?> alt="">
      </div>
    </a>
  <?php } ?>

  <div class="bg-header"><span class='whitebold'><a href="/">Toorganizer</a></span></div>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <nav>
    <?php
    /**
     * Añadir rutas al navegador y comprobar si esta activo o no
     */
    function addToNav($name, $path) {
      if ($path == $_SERVER['REQUEST_URI']) {
        echo "<a href='#' class='active'>$name</a>";
      } else {
        echo "<a href='$path'>$name</a>";
      }
    }

    addToNav('Inicio', '/index.php');

    if ($userObj) {
    ?><div class="submenu"><?php addToNav("Eventos <i class='fa fa-caret-down'></i>", "/view/events.php") ?><div class="submenu-content">
          <?php
          $eventLinks = array(
            "Mis eventos" => "/view/events.php?participant=true",
            "Buscar eventos" => "/view/events.php",
            "Administrar eventos" => "/view/events.php?admin=true",
            "Crear evento" => "/view/createEvent.php"
          );

          foreach ($eventLinks as $name => $path) {
            addToNav($name, $path);
          }
          ?>

          <!-- Dejar todo esta linea junta para quitar espacio nav -->
        </div></div><div class="submenu"><?php addToNav("Perfil <i class='fa fa-caret-down'></i>", "/view/profile.php") ?>
        <div class="submenu-content">
          <?php
          $loginLinks = array(
            "Mi perfil" => '/view/profile.php',
            "Ver perfiles" => '/view/profiles.php',
            "Cerrar sesión" => '/app/loginHandler.php?logout=true'
          );

          foreach ($loginLinks as $name => $path) {
            addToNav($name, $path);
          }
          ?>
        </div>
      </div>
    <?php
    } else {
      addToNav('Login', '/login.php');
    }
    ?>
  </nav>
</header>

<div class="bg-img"></div>