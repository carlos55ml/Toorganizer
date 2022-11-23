<?php
include __DIR__ . '/DB.php';
include __DIR__ . '/image.php';




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $changeAvatar = isset($_GET['changeAvatar'])?$_GET['changeAvatar']:false;
  if($changeAvatar) changeAvatar();
}

function changeAvatar() {
  $tId = isset($_GET['tId'])?$_GET['tId']:null;
  if (is_null($tId)) {
    // TODO error al subir
    echo "ERROR";
    return;
  }
  $avatarUrl = uploadAvatar();
  if (is_null($avatarUrl)) {
    DB::preparedQuery(
      'UPDATE users SET avatar_url = DEFAULT WHERE user_id = ?',
      Array($tId)
    );
  } else {
    DB::preparedQuery(
      'UPDATE users SET avatar_url = ? WHERE user_id = ?',
      Array($avatarUrl, $tId)
    );
  }
  header("Location:/view/profile.php");
}

/**
 * Fetch an specific user from DB
 * @param string $user The user to find
 * @return mixed The user Object, or null if no match.
 */
function fetchUser(string $user) {
  $query = 'SELECT * FROM users WHERE username = ?';
  $values = array($user);
  $result = DB::preparedQuery($query, $values);
  return empty($result[0]) ? null : $result[0];
}

/**
 * Fetch an specific user from DB
 * @param int $id The user id to find
 * @return mixed The user Object, or null if no match.
 */
function fetchUserId(int $id) {
  $query = 'SELECT * FROM users WHERE user_id = ?';
  $values = array($id);
  $result = DB::preparedQuery($query, $values);
  return empty($result[0]) ? null : $result[0];
}

/**
 * Fetch all users from DB
 * @return mixed The user array, or null if no match.
 */
function fetchAllUsers() {
  $query = 'SELECT * FROM users';
  $result = DB::query($query);
  return empty($result) ? null : $result;
}

/**
 * Try to log an user, given username and password.
 * This will return true if user exist and password is correct, false otherwise.
 * @param string $user Username.
 * @param string $pass Password.
 * @return mixed True if succesfully logged, Error string if error
 */
function tryUserLogin(string $user, string $pass) {
  $userObj = fetchUser($user);
  if (!$userObj) {
    return "'$user' NO EXISTE";
  }
  if ($pass !== $userObj['passwd']) {
    return "CONTRASENA INCORRECTA";
  }

  return true;
}

/**
 * Funcion que devuelve el avatar de un usuario
 * @param string $user nombre del usuario.
 * @return string String vacio si no existe el usuario, si existe devuelve la url.
 */
function getAvatarUrl($user) {
  return is_null($user) ? "" : fetchUser($user)['avatar_url'];
}

function uploadAvatar() {
  if (empty($_FILES["imgFile"]["name"])) {
    return;
  }
  $link = uploadToImgur($_FILES);
  return $link;
}
