<?php
  require_once('connectvars.php');

  // Start the session
  session_start();

  // Clear the error message
  $error_msg = "";

  // If the user is not logged in, try to log them in
  if (!isset($_SESSION['id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT id, username FROM users WHERE username = '$user_username' AND password = '$user_password'";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the profile page
          $row = mysqli_fetch_array($data);
          $_SESSION['id'] = $row['id'];
          $_SESSION['username'] = $row['username'];
          setcookie('id', $row['id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewprofile.php';
          header('Location: ' . $home_url);
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else {
        // The username/password were not entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Davebook</title>
  <link rel="stylesheet" type="text/css" href="style_login.css" />
</head>
<body>
  <div class="logo"><br /><br /><img src="images/davebook.png" />
	  <h4>If they're not on davebook they're not your friend.</h4><br /><br />
  </div>

<?php
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['id'])) {
    echo '<p class="error">' . $error_msg . '</p>';
?>

<div>
  <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
    <label for="username">Username:</label>
    <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br /><br />
    <label for="password">Password:</label>
    <input type="password" name="password" /><br /><br />
    <label for="login"></label>
    <input type="submit" value="Log In" name="submit" />
  </form>
</div>
<div><br /><br />Not a member? <a href="signup.php">&nbsp;&nbsp;&nbsp;Sign up here!</a></div>
<?php
  }
  else {
    // Confirm the successful log-in
    echo('<div><p class="login">You are logged in as ' . $_SESSION['username'] . '.</p></div>');
  }
?>

</body>
</html>
