<?php
include_once __DIR__ . '/DB.php';
include_once __DIR__ . '/image.php';

enum State {
  case setup;
  case pending;
  case running;
  case finished;
  case canceled;
}

/**
 * Devuelve todos los eventos guardados.
 * @return mixed Array con todos los eventos
 */
function fetchAllEvents() {
  $events = DB::query('SELECT * FROM events');
  return $events;
}

function fetchEvent($eventId) {
  return DB::preparedQuery('SELECT * FROM events WHERE event_id=?', array($eventId));
}

function fetchParticipantEvents($userId) {
  $queryString = 'SELECT e.* FROM events e, event_participants ep WHERE e.event_id=ep.event_id AND ep.user_id=?';
  $queryValues = array($userId);

  return DB::preparedQuery($queryString, $queryValues);
}

/**
 * Anade un nuevo organizador a un evento
 * @param int $event El evento al que anadir.
 * @param int $organizer El usuario organizador a anadir.
 */
function addOrganizerToEvent($event, $organizer) {
  $queryString = 'INSERT INTO event_organizers(event_id, user_id) VALUES (?, ?)';
  $queryValues = array($event, $organizer);
  DB::preparedQuery($queryString, $queryValues);
}

/**
 * Devuelve todos los organizadores de un evento en concreto.
 * @param int $event El evento del que sacar los organizadores
 * @return array Todos los organizadores del evento dado
 */
function getEventOrganizers($event) {
  $queryString = 'SELECT * FROM event_organizers WHERE event_id=?';
  $queryValues = array($event);
  $result = DB::preparedQuery($queryString, $queryValues);
  return $result;
}

/**
 * Crea un evento y guardalo a la base de datos.
 * @param string $name Nombre del evento.
 * @param string $game Juego en el que se basa el evento.
 * @param string $logoUrl URL del logo.
 * @param State $state Estado del evento.
 * @param int $ownerId ID del usuario que lo ha creado.
 * @return bool Devuelve true si se ha guardado correctamente el evento.
 */
function createEvent(string $name, string $game, string $logoUrl, State $state = State::setup, int $ownerId ) {
  $queryString = 'INSERT INTO events(name, game, logo_url, state, owner) VALUES (?, ?, ?, ?, ?)';
  $queryValues = array($name, $game, $logoUrl, $state->name, $ownerId);
  $result = DB::preparedQueryRetId($queryString, $queryValues);
  if ($result) {
    $eventId = $result;
    addOrganizerToEvent($eventId, $ownerId);
    header("Location:/view/event.php?eId=$eventId");
  } else {
    setcookie("errorMessage", "Error al crear el evento.", 0, "/");
    header("Location:/error.php");
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $isCreate = isset($_GET['isCreate'])?$_GET['isCreate']:null;
  if ($isCreate) {
    $eventName = isset($_POST['eventName'])?$_POST['eventName']:"null";
    $eventGameName = isset($_POST['eventGameName'])?$_POST['eventGameName']:"null";
    $eventLogo = uploadLogo();
    $ownerId = isset($_POST['ownerId'])? (int)$_POST['ownerId']:0;

    createEvent($eventName, $eventGameName, $eventLogo, State::setup, $ownerId);
  }
}


function uploadLogo() {
  if (empty($_FILES["imgFile"]["name"])) {
    return "";
  }
  $link = uploadToImgur($_FILES);
  return $link;
}
?>