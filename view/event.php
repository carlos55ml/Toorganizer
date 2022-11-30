<?php
include_once __DIR__ . "/../app/eventHandler.php";

$thisEvent = null;
$eventNotFound = false;
$eventId = isset($_GET['eId'])?$_GET['eId']:null;

// si no se ha pasado el evento por get, va a la pagina generica
if(!is_null($eventId) or !empty($eventId)) {
  $result = fetchEvent($eventId);
  // si encuentra el evento lo guarda en el objeto
  if($result) {
    $thisEvent = $result[0];
  } else {
    $thisEvent = null;
  }
} else {
  header("Location:/view/events.php");
}

// si hay objeto de evento, hace cosas
if($thisEvent) {
  $eventNotFound = false;
  $eventName = $thisEvent['name'];
} else {
  $eventNotFound = true;
  $eventName = "NO ENCONTRADO";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/style.css">
  <title><?php echo $eventName ?> - Toorganizer</title>
</head>
<body>
  <?php
  include_once __DIR__ . "/../modules/header.php";
  ?>
  <main>
  <?php if($eventNotFound) { ?>
    <div class="center">
      <h1>Evento no encontrado</h1>
    </div>
  <?php } else { ?>
    
  <?php } ?>
  </main>
</body>
</html>