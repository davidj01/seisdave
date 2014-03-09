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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Davebook - View Profile</title>
  <link rel="stylesheet" type="text/css" href="style_main.css" />
</head>
<body>
  <div class="logo"><br /><br /><img src="images/davebook.png" />
	  <h4>If they're not on davebook they're not your friend.</h4>
	  <div class="bluebox"><a href="viewprofile.php">My Profile</a> &nbsp; | &nbsp;
	  <a href="viewallusers.php">View All Users</a> &nbsp; | &nbsp;
	  <a href="logout.php">Log Out</a> (<?php echo $_SESSION['username'] ?>)
	  </div>
  </div>

<table><tr><td width="300px">
<?php

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['id'])) {
    echo '<p class="login">Please <a href="index.php">log in</a> to access this page.</p>';
    exit();
  }
  else {
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '.</p>');
  }

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Grab the profile data from the database
  if (!isset($_GET['id'])) {
    $query = "SELECT username, name, gender, birthdate, city, state, picture FROM users WHERE id = '" . $_SESSION['id'] . "'";
  }
  else {
    $query = "SELECT username, name, gender, birthdate, city, state, picture FROM users WHERE id = '" . $_GET['id'] . "'";
  }
  $data = mysqli_query($dbc, $query);

  if (mysqli_num_rows($data) == 1) {
    // The user row was found so display the user data
    $row = mysqli_fetch_array($data);
    echo '<table>';
    if (!empty($row['username'])) {
      echo '<tr><td class="label">Username:</td><td>' . $row['username'] . '</td></tr>';
    }
    if (!empty($row['name'])) {
      echo '<tr><td class="label">Name:</td><td>' . $row['name'] . '</td></tr>';
    }
    if (!empty($row['gender'])) {
      echo '<tr><td class="label">Gender:</td><td>';
      if ($row['gender'] == 'M') {
        echo 'Male';
      }
      else if ($row['gender'] == 'F') {
        echo 'Female';
      }
      else {
        echo '?';
      }
      echo '</td></tr>';
    }
    if (!empty($row['birthdate'])) {
      if (!isset($_GET['id']) || ($_SESSION['id'] == $_GET['id'])) {
        // Show the user their own birthdate
        echo '<tr><td class="label">Birthdate:</td><td>' . $row['birthdate'] . '</td></tr>';
      }
      else {
        // Show only the birth year for everyone else
        list($year, $month, $day) = explode('-', $row['birthdate']);
        echo '<tr><td class="label">Year born:</td><td>' . $year . '</td></tr>';
      }
    }
    if (!empty($row['city']) || !empty($row['state'])) {
      echo '<tr><td class="label">Location:</td><td>' . $row['city'] . ', ' . $row['state'] . '</td></tr>';
    }
    if (!empty($row['picture'])) {
      echo '<tr><td class="label">Picture:</td><td><img src="' . MM_UPLOADPATH . $row['picture'] .
        '" alt="Profile Picture" /></td></tr>';
    }
    echo '</table>';
    if (!isset($_GET['id']) || ($_SESSION['id'] == $_GET['id'])) {
      echo '<p>Would you like to <a href="editprofile.php">edit your profile</a>?</p>';
    }
  } // End of check for a single row of user results
  else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
  }
?>

<br />
<form method="post" action="messagepost.php">
  <label for="other">Post a Message (4,000 character max):</label><br />
  <textarea id="message" name="message" maxlength="4000" cols="25" rows="6"></textarea><br />
  <input type="submit" name="submit" value="Submit" />
</form>
<?php
  // Retrieve the friend data from MySQL
  $query = "SELECT username, friend FROM relationships WHERE username = '" . $_SESSION['username'] . "'";
  $data2 = mysqli_query($dbc, $query);

  // Loop through the array of user data, formatting it as HTML
  echo '<br /><h4><a href="viewmyfriends.php">My Friends:</a></h4>';
  echo '<table>';
  while ($row = mysqli_fetch_array($data2)) {
    echo '<tr><td>' . $row['friend'] . '<br /><br /><br /></td></tr>';
    }
  echo '</table>';

  mysqli_close($dbc);
?>

</td>
<td>

<?php

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Retrieve the message data from MySQL
  $query = "select distinct username, date, message from messages where username = '" . $_SESSION['username'] . "' OR username in (select friend as username from relationships where username = '" . $_SESSION['username'] . "') order by date desc limit 25";
  $data3 = mysqli_query($dbc, $query);

  // Loop through the array of message data, formatting it as HTML
  echo '<h4>Messages:</h4>';
  echo '<table>';
  while ($row = mysqli_fetch_array($data3)) {
    echo '<tr><td>' . $row['username'] . ' &nbsp; ' . $row['date'] . '<br /><br />' . $row['message'] . '<br /><br /><br /></td></tr>';
    }
  echo '</table>';

  mysqli_close($dbc);
?>
</td></tr></table>

</body>
</html>
