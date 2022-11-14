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
 * @return bool True if succesfully logged.
 */
function tryUserLogin(string $user, string $pass) {
  $userObj = fetchUser($user);
  if (!$userObj) {
    echo "Usuario NO EXISTE";
    return false;
  }
  // TODO encode passwd
  if (!$pass == $userObj['password']) {
    echo "Contrasena incorrecta";
    return false;
  }
  echo "Exito login";

  return true;
}
?>