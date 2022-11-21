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
    echo "<a href='/index.php'>Inicio</a>";
    if ($userObj) {
      echo "<a href='/view/profile.php'>Perfil</a><a href='/app/loginHandler.php?logout=true'>Cerrar sesión</a>";
    } else {
      echo "<a href='/login.php'>Login</a>";
    }
    ?>
  </nav>
</header>