<?php
include __DIR__ . '/DB.php';
include __DIR__ . '/image.php';

enum State {
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

/**
 * Crea un evento y guardalo a la base de datos.
 * @param string $name Nombre del evento.
 * @param string $game Juego en el que se basa el evento.
 * @param string $logoUrl URL del logo.
 * @param State $state Estado del evento.
 * @param int $ownerId ID del usuario que lo ha creado.
 * @return bool Devuelve true si se ha guardado correctamente el evento.
 */
function createEvent(string $name, string $game, string $logoUrl, State $state = State::pending, int $ownerId ) {
  // TODO create event
}

?>