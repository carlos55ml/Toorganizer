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

  $participant = isset($_GET['participant']) ? $_GET['participant'] : null;
  $admin = isset($_GET['admin']) ? $_GET['admin'] : null;

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
    <?php
    foreach ($events as $event) { ?>
      <a class="link" href="event.php?eId=<?php echo $event['event_id'] ?>">
        <div class="tourney-content">
          <div class="tourney-card">
            <div class="tourney-info">
              <img src="<?php echo $event['logo_url'] ?>" />
              <div class="tourney-data">
                <h1><?php echo $event['name'] ?></h1>
                <h3><?php echo $event['game'] ?></h3>
                <div class="status-owner">
                  <span class="status">
                    <span class="circle circle-<?php echo $event['state'] ?>"></span>
                    <?php
                    foreach (State::cases() as $case) {
                      if ($case->key() == $event['state']) {
                        echo $case->value();
                        break;
                      }
                    }
                    ?>
                  </span>
                  <span class="owner">Owner: <?php echo fetchUserId($event['owner'])['username'] ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    <?php } ?>
  </main>
</body>

</html>