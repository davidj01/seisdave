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

<?php
	require_once('appvars.php');
	require_once('connectvars.php');

	// Connect to the database
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if (isset($_POST['keyword'])) {
	// Filter
	$keyword = trim ($_POST['keyword']);

	// Select statement
	$search = "SELECT id, name FROM users WHERE name LIKE '%$keyword%'";
	// Display
	$result = mysqli_query($dbc, $search) or die('query did not work');
	if (!$result){
	echo "problem";
	exit();
	}

	  echo '<table>';
	  while ($row = mysqli_fetch_array($result)) {
		if (isset($_SESSION['id'])) {
		  echo '<td><a href="viewprofile.php?id=' . $row['id'] . '">' . $row['name'] . '</a></td></tr>';
		}
		else {
		  echo '<td>' . $row['name'] . '</td></tr>';
		}
	  }
	  echo '</table>';

	while($result_arr = mysqli_fetch_array( $result ))
	{
	echo $result_arr['name'];
	echo " ";
	echo "<br>";
	echo "<br>";
	}
	$anymatches=mysqli_num_rows($result);
	if ($anymatches == 0)
	{
	   echo "Nothing was found that matched your query.<br><br>";
	}
	}

	mysqli_close($dbc);
?>

</body>
</html>