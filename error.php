<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ERROR - Toorganizer</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php $error = isset($_COOKIE['errorMessage']) ? $_COOKIE['errorMessage'] : "";  ?>
  <main>
    <div class="center">
      <h1>ERROR:</h1>
      <p><code><?php echo empty($error) ? "Error desconocido" : $error; ?></code></p>
      <br>
      <a href="/"><button id="btnBack">Volver a pagina de inicio</button></a>
    </div>
  </main>
  <?php
  // BORRA LA COOKIE
  setcookie("errorMessage", null, time());
  ?>
</body>

</html>