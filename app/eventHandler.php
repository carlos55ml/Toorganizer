<?php
include_once __DIR__ . '/DB.php';
include_once __DIR__ . '/image.php';
include_once __DIR__ . './../app/utils.php';

enum State: string {
  case setup = 'En preparacion'; // El evento esta siendo configurado.
  case pending = 'Pendiente'; // El evento esta pendiente de empezar.
  case running = 'En curso'; // El evento esta en curso.
  case finished = 'Finalizado'; // El evento esta finalizado.
  case canceled = 'Cancelado'; // El evento ha sido cancelado.
}

/**
 * DEVUELVE EVENTOS
 */

/**
 * Devuelve todos los eventos guardados.
 * @return mixed Array con todos los eventos
 */
function fetchAllEvents() {
  $events = DB::preparedQuery('SELECT * FROM events', array());
  return $events;
}

/**
 * Devuelve un evento en especifico buscando su id
 * @param int $eventId Id del evento a buscar
 * @return mixed El objeto del evento
 */
function fetchEvent($eventId) {
  return DB::preparedQuery('SELECT * FROM events WHERE event_id=?', array($eventId));
}

/**
 * Devuelve solo los eventos en los que este participando un usuario en particular
 * @param int $userId El usuario que queremos buscar
 * @return mixed Array con los eventos en los que el usuario participa.
 */
function fetchParticipantEvents($userId) {
  $queryString = 'SELECT e.* FROM events e, event_participants ep WHERE e.event_id=ep.event_id AND ep.user_id=?';
  $queryValues = array($userId);

  return DB::preparedQuery($queryString, $queryValues);
}

/**
 * Devuelve solo los eventos en los que este administrando un usuario en particular
 * @param int $userId El usuario que queremos buscar
 * @return mixed Array con los eventos en los que el usuario administra.
 */
function fetchStaffEvents($userId) {
  $queryString = 'SELECT e.* FROM events e, event_organizers eo WHERE e.event_id=eo.event_id AND eo.user_id=?';
  $queryValues = array($userId);

  return DB::preparedQuery($queryString, $queryValues);
}

/**
 * DEVUELVE USUARIOS
 */

/**
 * Devuelve los participantes de un evento
 * @param int $eventId La id del evento
 * @return mixed Array con los participantes del evento
 */
function fetchEventParticipants($eventId) {
  $queryString =
    "SELECT u.* FROM users u, events e, event_participants ep
   WHERE u.user_id=ep.user_id 
   AND e.event_id=ep.event_id 
   AND e.event_id=?";

  $queryValues = array($eventId);
  return DB::preparedQuery($queryString, $queryValues);
}

/**
 * Devuelve los admins de un evento
 * @param int $eventId La id del evento
 * @return mixed Array con los admins del evento
 */
function fetchEventAdmins($eventId) {
  $queryString =
    "SELECT u.* FROM users u, events e, event_organizers eo
  WHERE u.user_id=eo.user_id 
  AND e.event_id=eo.event_id 
  AND e.event_id=?";

  $queryValues = array($eventId);
  return DB::preparedQuery($queryString, $queryValues);
}

/**
 * GESTION DE USUARIOS CON EVENTOS
 */

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

function addParticipantToEvent($eventId, $participantId) {
  $queryString = 
  "INSERT INTO event_participants(user_id, event_id) VALUES
  (?, ?)";
  $queryValues = array($participantId, $eventId);
  DB::preparedQuery($queryString, $queryValues);
}


/**
 * FUNCIONES VARIAS
 */
/**
 * Crea un evento y guardalo a la base de datos.
 * @param string $name Nombre del evento.
 * @param string $game Juego en el que se basa el evento.
 * @param string $logoUrl URL del logo.
 * @param State $state Estado del evento.
 * @param int $ownerId ID del usuario que lo ha creado.
 * @return bool Devuelve true si se ha guardado correctamente el evento.
 */
function createEvent(string $name, string $game, string $logoUrl, State $state = State::setup, int $ownerId) {
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


/**
 * LOGICA CREACION EVENTOS
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $isCreate = isset($_GET['isCreate']) ? $_GET['isCreate'] : null;
  if ($isCreate) {
    $eventName = isset($_POST['eventName']) ? xss_clean($_POST['eventName']) : "null";
    $eventGameName = isset($_POST['eventGameName']) ? xss_clean($_POST['eventGameName']) : "null";
    $eventLogo = uploadLogo();
    $ownerId = isset($_POST['ownerId']) ? (int)xss_clean($_POST['ownerId']) : 0;

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
