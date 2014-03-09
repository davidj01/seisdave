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

  if(isset($_POST['submit']))
  {
  	$message = $_POST['message'];
  }

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  $query = "INSERT INTO messages (id, username, date, message) " .
    "VALUES ('', '{$_SESSION['username']}', NOW(), '$message')";

  $result = mysqli_query($dbc, $query) or die('Error querying database.');

  header("Location: viewprofile.php"); /* Redirect browser */
  exit();

  mysqli_close($dbc);
?>
