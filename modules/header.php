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
    <a href="/view/profile.php?id=<?php echo $userObj['user_id'] ?>">
      <div id="userBox">
        <p id="username"><?php echo $userObj['username'] ?></p>
        <img id="imgUser" src=<?php echo getAvatarUrl($userObj['username']) ?> alt="">
      </div>
    </a>
  <?php } ?>

  <div class="bg-header"><span class='whitebold'>Toorganizer</span></div>
  <nav>
    <?php
    $indexPath = '/index.php';

    // TODO perfeccionar esta mierda
    if ($indexPath == $_SERVER['SCRIPT_NAME']) {
      echo "<a href='/index.php' class='active'>Inicio</a>";
    } else {
      echo "<a href='/index.php'>Inicio</a>";
    }

    if ($userObj) {
      $loginLinks = array(
        "Perfil" => '/view/profile.php',
        "Cerrar sesión" => '/app/loginHandler.php?logout=true'
      );

      foreach ($loginLinks as $name => $path) {
        if ($path == $_SERVER['SCRIPT_NAME']) {
          echo "<a href='$path' class='active'>$name</a>";
        } else {
          echo "<a href='$path'>$name</a>";
        }
      }
    } else {
      if ('/login.php' == $_SERVER['SCRIPT_NAME']) {
        echo "<a href='/login.php' class='active'>Login</a>";
      } else {
        echo "<a href='/login.php'>Login</a>";
      }
    }
    ?>
  </nav>
</header>