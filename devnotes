# Toorganizer

## Actores:

- Invitado
    - ver eventos
    - iniciar sesion o registrarse
- User
    - Ver eventos
    - Crear evento (pasa a *organizador*)
    - Participar en eventos (pasa a *participante*)
- Participante
    - Ve el evento que esta participando
    - Tiene acciones de participante de evento (jugar, ver clasif. …)
    - Sigue tenido acciones de *user*
- Organizador
    - Puede administrar eventos (terminar, borrar, expulsar participantes..)
    - Sigue teniendo acciones de *user*
- Admin
    - Tiene todos los poderes
    - Puede modificar admins
    - Puede modificar eventos

## DB

- Users
    - user_id
    - username
    - passwd
    - isAdmin
    - avatarURL
- Events
    - event_id
    - name
    - game
    - logoURL
    - state (pending, running, finished, canceled)
- events_organizers
    - event_id
    - user_id
- events_phases
    - phase_id
    - participantA (user_id)
    - participantB (user_id)
    - resultA
    - resultB
- events_participants
    - user_id
    - event_id
    - phase_id
- chat_messages
    - message_id
    - event_id
    - sender (user_id)
    - message
    - timestamp
