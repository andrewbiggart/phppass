<?php 
	session_start();
	$url   = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$uid   = $_SESSION["uid"];
	
	if (!isset($uid)) {
		
		if ($url != "") {
			header("location:login.php?redirect=".$url);
			exit();
			die();
		}
		else {
			header("location:login.php");
			exit();
			die();	
		}	
	} // User isn't logged in.
?>