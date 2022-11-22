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
  <nav>
    <?php
    $indexPath = '/index.php';

    /**
     * Añadir rutas al navegador y comprobar si esta activo o no
     */
    function addToNav($name, $path) {
      if ($path == $_SERVER['SCRIPT_NAME']) {
        echo "<a href='$path' class='active'>$name</a>";
      } else {
        echo "<a href='$path'>$name</a>";
      }
    }

    addToNav('Inicio', '/index.php');

    if ($userObj) {
      $loginLinks = array(
        "Perfil" => '/view/profile.php',
        "Cerrar sesión" => '/app/loginHandler.php?logout=true'
      );

      foreach ($loginLinks as $name => $path) {
        addToNav($name, $path);
      }
    } else {
      addToNav('Login', '/login.php');
    }
    ?>
  </nav>
</header>

<div class="bg-img"></div>