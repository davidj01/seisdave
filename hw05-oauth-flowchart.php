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
	  <a href="misc.php">Misc</a> &nbsp; | &nbsp;
	  <a href="logout.php">Log Out</a> <!-- (<?php echo $_SESSION['username'] ?>) -->
	  </div>
	</div>
	<div>
	  <form method="post" action="searchresults.php">
		<label for="keyword">Non-Ajax Search:</label>
		<input type="text" name="keyword" />
		<input type="submit" name="search" value="Search" />
	  </form>
	  <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search using:<a href="searchajax1.htm">&nbsp;&nbsp;&nbsp;<strong>Ajax Search</strong></a>&nbsp;&nbsp;&nbsp;or&nbsp;&nbsp;&nbsp;<a href="searchajax2.htm"><strong>Ajax/Jquery Search</strong></a>
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

</td>
<td>
<br />
<br />
<br />
Oauth - process diagram of the flow of data:
<br />
<br />
<img src="images/flowchart-oauth.png" />
</td></tr></table>

</body>
</html>
