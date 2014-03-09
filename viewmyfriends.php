<?php
  session_start();

  // If the session vars are not set, try to set them with a cookie
  if (!isset($_SESSION['id'])) {
    if (isset($_COOKIE['id']) && isset($_COOKIE['username'])) {
      $_SESSION['id'] = $_COOKIE['id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Davebook - View All Users</title>
  <link rel="stylesheet" type="text/css" href="style_main.css" />
</head>
<body>
  <div class="logo"><br /><br /><img src="images/davebook.png" />
  <h4>If they're not on davebook they're not your friend.</h4>
  <div class="bluebox"><a href="viewprofile.php">My Profile</a> &nbsp; | &nbsp;
  <a href="viewallusers.php">View All Users</a> &nbsp; | &nbsp;
  <a href="logout.php">Log Out</a> (<?php echo $_SESSION['username'] ?>)</div></div>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Retrieve the user data from MySQL
  $query = "select distinct id, username, name, picture FROM users where username in (select friend as username from relationships where username = '" . $_SESSION['username'] . "') order by name";
  $data = mysqli_query($dbc, $query);

  // Loop through the array of user data, formatting it as HTML
  echo '<h4>My Friends:</h4>';
  echo '<table>';
  while ($row = mysqli_fetch_array($data)) {
    if (is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) {
      echo '<tr><td><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['name'] . '" /></td>';
    }
    else {
      echo '<tr><td><img src="' . MM_UPLOADPATH . 'nopic.jpg' . '" alt="' . $row['name'] . '" /></td>';
    }
    if (isset($_SESSION['id'])) {
      echo '<td><a href="viewprofile.php?id=' . $row['id'] . '">' . $row['name'] . '</a><br /><br /><a href="removefriend.php?id=' . $row['id'] . '">Remove Friend</a></td></tr>';
    }
    else {
      echo '<td>' . $row['name'] . '</td></tr>';
    }
  }
  echo '</table>';

  mysqli_close($dbc);
?>

</body>
</html>