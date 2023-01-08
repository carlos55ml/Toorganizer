<?php
include_once __DIR__ . "/../app/eventHandler.php";

$thisEvent = null;
$eventNotFound = false;
$eventId = isset($_GET['eId']) ? $_GET['eId'] : null;

// si no se ha pasado el evento por get, va a la pagina generica
if (!is_null($eventId) or !empty($eventId)) {
  $result = fetchEvent($eventId);
  // si encuentra el evento lo guarda en el objeto
  if ($result) {
    $thisEvent = $result[0];
  } else {
    $thisEvent = null;
  }
} else {
  header("Location:/view/events.php");
}

// si hay objeto de evento, hace cosas
if ($thisEvent) {
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
    <?php if ($eventNotFound) { ?>
      <div class="center">
        <h1>Evento no encontrado</h1>
      </div>
    <?php } else {
      $creator = fetchUserId($thisEvent['owner']);
      $isParticipant = isEventParticipant($thisEvent[0], $userObj[0]);
      $isAdmin = isEventAdmin($thisEvent[0], $userObj[0]);
      $canJoin;
      foreach (State::cases() as $key => $case) {
        if ($case->key() == $thisEvent['state']) {
          $canJoin = $case->canJoin();
          break;
        }
      }
    ?>
      <!-- \/ TODO EL CONTENIDO DEL EVENTO DENTRO DE ESTOS CORCHETES (control de que evento exista) \/ -->
      <div class="event-header center">
        <span class="event-name"><?php echo $thisEvent['name'] ?></span> <br><br>
        Juego: <span class="game-name"><?php echo $thisEvent['game'] ?></span> <br>
        Creador: <a href="./profile.php?id=<?php echo $creator[0] ?>" class="link"><span class="creator-name"><?php echo $creator['username'] ?></span></a>
        Estado: <span class="event-state"><b><?php
                                          foreach (State::cases() as $case) {
                                            if ($case->key() == $thisEvent['state']) {
                                              echo $case->value();
                                              break;
                                            }
                                          }
                                          ?></b></span>
      <?php if ($isAdmin){ ?>
        <form action="./../app/eventHandler.php" method="post">
          <input type="hidden" name="eventId" value="<?php echo $thisEvent[0] ?>">
          <input type="hidden" name="action" value="changeState">
          <select name="newState" id="newState">
            <?php foreach (State::cases() as $key => $case) { ?>
              <option value="<?php echo $case->key() ?>"><?php echo $case->value() ?></option>
            <?php } ?>
          </select>
          <input type="submit" value="Cambiar estado">
        </form>
      <?php } ?>
      <?php if($canJoin and !$isParticipant) { ?>
        <form action="./../app/eventHandler.php" method="post">
          <input type="hidden" name="action" value="addParticipant">
          <input type="hidden" name="eventId" value="<?php echo $thisEvent[0] ?>">
          <input type="hidden" name="userId" value="<?php echo $userObj[0] ?>">
          <input type="submit" value="Quiero participar!" class="join-event">
        </form>
      <?php }
      if ($isParticipant){ ?>
      <form action="./../app/eventHandler.php" method="post">
          <input type="hidden" name="action" value="leaveEvent">
          <input type="hidden" name="eventId" value="<?php echo $thisEvent[0] ?>">
          <input type="hidden" name="userId" value="<?php echo $userObj[0] ?>">
          <input type="submit" value="Dejar evento" class="leave-event">
        </form>
      <?php } ?>
      </div>
      <div class="event-info">
        <div class="event-organizers">
          <b>Lista admins</b>
          <?php $admins = fetchEventAdmins($thisEvent[0]) ?>
          <ul>
            <?php foreach ($admins as $k => $v) { ?>
              <?php if ($v[0] == $thisEvent['owner']) { ?>
                <li><b><?php echo $v[0] ?> - <?php echo $v['username'] ?></b></li>
              <?php } else { ?>
                <?php if ($isAdmin) { ?>
                  <li><b><?php echo $v[0] ?></b> - <?php echo $v['username'] ?> <button class="deleteAdmin" name="deleteAdmin" value="<?php echo $v[0] ?>">Eliminar</button></li>
                <?php } else { ?>
                  <li><b><?php echo $v[0] ?></b> - <?php echo $v['username'] ?></li>
                <?php } ?>
              <?php } ?>
            <?php } ?>
          </ul>
          <?php if ($isAdmin) { ?>
            <form action="./../app/eventHandler.php" method="post">
              <input type="hidden" name="action" value="anadirAdmin">
              <input type="hidden" name="eventId" value="<?php echo $thisEvent[0] ?>">
              <label for="anadirInput">Añadir organizador: </label>
              <select name="anadirInput" id="anadirInput">
                <?php
                $users = fetchNonAdmins($thisEvent[0]);
                foreach ($users as $k => $v) { ?>
                  <option value="<?php echo $v[0] ?>"><?php echo $v[0] . " - " . $v['username'] ?></option>
                <?php } ?>
              </select>
              <input type="submit" value="Añadir">
            </form>
          <?php } ?>
          
        </div>
        <div class="event-participants">
          <b>Lista participantes</b>
          <?php $participants = fetchEventParticipants($thisEvent[0]); ?>
          <ul>
            <?php foreach ($participants as $key => $participant) { 
                    if($isAdmin){ ?>
                    <li> <?php echo $participant[0]. " - ".$participant['username'] ?> <button class="deleteParticipant" name="deleteParticipant" value="<?php echo $participant[0] ?>">Eliminar</button> </li>
              <?php } else { ?>
                <li> <?php echo $participant[0]. " - ".$participant['username'] ?> </li>
            <?php }
            } ?>
          </ul>
        </div>
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
      <script>
        $(document).ready(function() {
          $('.deleteAdmin').click(function() {
            var target = $(this).val()
            $.ajax({
              type: "POST",
              url: './../app/eventHandler.php',
              data: {
                'action': 'deleteAdminFromEvent',
                'eventId': <?php echo $thisEvent[0] ?>,
                'targetId': target
              },
              success: function(r) {
                location.reload()
              }
            })
          })
          $('.deleteParticipant').click(function(){
            var target = $(this).val()
            $.ajax({
              type: "POST",
              url: './../app/eventHandler.php',
              data: {
                'action': 'leaveEvent',
                'eventId': <?php echo $thisEvent[0] ?>,
                'userId': target
              },
              success: function(r) {
                location.reload()
              }
            })
          })
        })
      </script>
      <!-- /\ TODO EL CONTENIDO DEL EVENTO DENTRO DE ESTOS CORCHETES (control de que evento exista) /\ -->
    <?php } ?>
  </main>
</body>

</html>