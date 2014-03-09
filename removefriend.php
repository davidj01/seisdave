<?php

  require_once('appvars.php');
  require_once('connectvars.php');

  session_start();

  // If the session vars are not set, try to set them with a cookie
  if (!isset($_SESSION['id'])) {
    if (isset($_COOKIE['id']) && isset($_COOKIE['username'])) {
      $_SESSION['id'] = $_COOKIE['id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>

<?php

//  $id = $_POST['id'];

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $query = "SELECT username FROM users WHERE id = '" . $_GET['id'] . "'";
  $result = mysqli_query($dbc, $query);
  $friend = $result->fetch_object()->username;

//  echo 'GET on id returns ' . $_GET['id'] . '<br />';
//  echo 'SESSION on id returns ' . $_SESSION['id'] . '<br />';
//  echo 'COOKIE on id returns ' . $_COOKIE['id'] . '<br />';
//  echo 'SESSION on username returns ' . $_SESSION['username'] . '<br />';
//  echo 'COOKIE on username returns ' . $_COOKIE['username'] . '<br />';
//  echo 'result variable returns ' . $friend . '<br />';

  mysqli_close($dbc);

?>

<?php

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $query = "DELETE FROM relationships WHERE username = '" . $_SESSION['username'] . "' AND friend = '$friend'";
  $result = mysqli_query($dbc, $query);

  mysqli_close($dbc);

  header("Location: viewmyfriends.php"); /* Redirect browser */
  exit();

?>