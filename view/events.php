<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/style.css">
  <title>Eventos - Toorganizer</title>
</head>
<body>
  <?php
  include_once __DIR__ . "/../modules/header.php";
  include_once __DIR__ . "/../app/eventHandler.php";

  $participant = isset($_GET['participant'])?$_GET['participant']:null;
  $admin = isset($_GET['admin'])?$_GET['admin']:null;

  $events = null;

  if ($participant) {
    $events = fetchParticipantEvents($userObj['user_id']);
  }
  if ($admin) {
    $events = fetchStaffEvents($userObj['user_id']);
  }

  if (!$participant and !$admin) {
    $events = fetchAllEvents();
  }
  
  ?>

  <main>
    <?php print_r($events) ?>
  </main>
</body>
</html>