<?php
	include_once('config-sms.php');
	print_r($_POST);

	foreach ($_POST as $k => $v) {
	  $ans .= $k.'='.$v."\n";
	}

	echo $ans;
	mysqli_query($db,"INSERT INTO twilliotest (dump) VALUES ('$ans')");

	mysqli_close($db);
?>