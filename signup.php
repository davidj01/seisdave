<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Davebook - Sign Up</title>
  <link rel="stylesheet" type="text/css" href="style_login.css" />
</head>
<body>
  <div class="logo"><br /><br /><img src="images/davebook.png" />
	  <h4>If they're not on davebook they're not your friend.</h4><br />
  </div>
<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
      // Make sure someone is not already registered using this username
      $query = "SELECT * FROM users WHERE username = '$username'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO users (username, password, join_date) VALUES ('$username', '$password1', NOW())";
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Your new account has been successfully created. You are now ready to <a href="index.php"><u>log in</u></a>.</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p class="error">An account already exists for this username. Please use a different username.</p>';
        $username = "";
      }
    }
    else {
      echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
    }
  }

  mysqli_close($dbc);
?>
<div>
  <p>Please enter your username and desired password to sign up for Davebook.</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br /><br />
      <label for="password1">Password:</label>
      <input type="password" id="password1" name="password1" /><br /><br />
      <label for="password2">Password (confirm):</label>
      <input type="password" id="password2" name="password2" /><br /><br />
    <input type="submit" value="Sign Up" name="submit" />
  </form>
</div>
<div><br /><br /><a href="index.php">Back to log in</a></div>
</body>
</html>
