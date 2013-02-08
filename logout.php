<?php
	session_start();
	include('_includes/config.php');
	$sid    = $_COOKIE['userid'];
	$sql    = "UPDATE staff_newT SET staff_status = 'Logged Out', staff_authcode = '' WHERE staff_id = '$sid'";	
	$result = mysql_query($sql);
	
	if($result){
		session_destroy();
		setcookie ("userid", "", time() - 3600);
		setcookie ("authcode", "", time() - 3600);
		header("location:login.php");
	}
	else{
		exit();
	}
?>
