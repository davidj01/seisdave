<?php
include_once('config.php');

$sql = "SELECT * FROM twilliotest order by ts desc limit 20";

print '<table>';
if ($result=mysqli_query($db,$sql))
  {
  // Fetch one and one row
  while ($row=mysqli_fetch_row($result))
  {
    printf('<tr><td>%s</td><td><pre>%s</pre></td></tr>',$row[0],$row[1]);
  }
  // Free result set
  mysqli_free_result($result);
}
print '</table>';

mysqli_close($db);
?>