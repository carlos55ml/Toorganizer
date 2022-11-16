<?php
include __DIR__ . '/DB.php';

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

// TODO properly handle login
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
  // TODO encode passwd
  if ($pass !== $userObj['passwd']) {
    return "CONTRASENA INCORRECTA";
  }

  return true;
}

function getAvatarUrl($user) {
  $userObj = fetchUser($user);
  if (is_null($userObj)) {
    return "";
  } else {
    return $userObj['avatar_url'];
  }
}
?>