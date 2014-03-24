<?php
  global $db;
  $db = @mysqli_connect('mysql.bromad.com', 'davols17', 'fNmrjLsp', 'seisdave');
  if (mysqli_connect_errno())
  {
    echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
  }
?>