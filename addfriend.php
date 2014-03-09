<?php

  require_once('appvars.php');
  require_once('connectvars.php');

  session_start();

  // If the session vars are not set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>

<?php

//  $user_id = $_POST['user_id'];

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $query = "SELECT username FROM users WHERE user_id = '" . $_GET['user_id'] . "'";
  $result = mysqli_query($dbc, $query);
  $friend = $result->fetch_object()->username;

//  echo 'GET on user_id returns ' . $_GET['user_id'] . '<br />';
//  echo 'SESSION on user_id returns ' . $_SESSION['user_id'] . '<br />';
//  echo 'COOKIE on user_id returns ' . $_COOKIE['user_id'] . '<br />';
//  echo 'SESSION on username returns ' . $_SESSION['username'] . '<br />';
//  echo 'COOKIE on username returns ' . $_COOKIE['username'] . '<br />';
//  echo 'result variable returns ' . $friend . '<br />';

  mysqli_close($dbc);

?>

<?php

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $query = "INSERT INTO relationships (rel_id, username, friend) VALUES ('', '" . $_SESSION['username'] . "', '$friend')";
  $result = mysqli_query($dbc, $query);

  mysqli_close($dbc);

  header("Location: viewallusers.php"); /* Redirect browser */
  exit();

?>