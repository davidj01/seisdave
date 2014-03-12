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

<?php
	require_once('appvars.php');
	require_once('connectvars.php');

$q = $_GET['q'];

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 if (!$con)
   {
   die('Could not connect: ' . mysqli_error($con));
   }

$sql="SELECT id, name FROM users WHERE name LIKE '%$q%' ORDER BY name";

$result = mysqli_query($con,$sql);

  while ($row = mysqli_fetch_array($result)) {
    if (isset($_SESSION['id'])) {
      echo '<a href="viewprofile.php?id=' . $row['id'] . '">' . $row['name'] . '</a><br />';
    }
    else {
      echo '<a href="viewprofile.php?id=' . $row['id'] . '">' . $row['name'] . '</a><br />';
    }
  }

/*	while($result_arr = mysqli_fetch_array( $result ))
	{
	echo '<a href="viewprofile.php?id=' . $row['id'] . '">' . $result_arr['name'] . '</a>';
	echo $result_arr['name'];
	echo " ";
	echo "<br>";
	}	*/

	$anymatches=mysqli_num_rows($result);
	if ($anymatches == 0)
	{
	   echo "Nothing was found that matched your query.<br><br>";
	}

mysqli_close($con);
?>