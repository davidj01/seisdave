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
	require_once('appvars.php');
	require_once('connectvars.php');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if($_POST)
{
$q = $_POST['search'];

$query = "select id, name from users where name like '%$q%' order by name";
/*$query = "select id, name, username from users where name like '%$q%' or username like '%$q%' order by id LIMIT 25";*/
$result = mysqli_query($con, $query);

while($row = mysqli_fetch_array($result))
    if (isset($_SESSION['id'])) {
      echo '<a href="viewprofile.php?id=' . $row['id'] . '">' . $row['name'] . '</a><br />';
    }
    else {
      echo '<a href="viewprofile.php?id=' . $row['id'] . '">' . $row['name'] . '</a><br />';
    }

/*{
$name = $row['name'];
$username = $row['username'];
$b_name = '' .$q. '';
$b_username = '' .$q. '<br />';
$final_name = str_ireplace($q, $b_name, $name);
$final_username = str_ireplace($q, $b_username, $username);

?>
<div>
<span><br /><?php echo '<a href="viewprofile.php?id=' . $row['id'] . '">' . $final_name . '</a><br />'; ?></span>&nbsp;<br/><?php echo $final_username; ?><br/>
</div>
<?php
}*/

}

	$anymatches=mysqli_num_rows($result);
	if ($anymatches == 0)
	{
	   echo "Nothing was found that matched your search.<br><br>";
	}

?>