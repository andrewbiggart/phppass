<?php
	require('_includes/functions.php');
	include('_includes/config.php');
	
	$username = $_POST['email'];
	$username = stripslashes($username);
	$username = mysql_real_escape_string($username);
	
	$sql      = "SELECT staff_id, staff_name, staff_email FROM staff_newT WHERE staff_email='$username'";
    	$result   = mysql_query($sql);
	$count    = mysql_num_rows($result);
	$row      = mysql_fetch_array($result);
	$sid      = $row['staff_id'];
	$sname    = $row['staff_name'];
	$semail   = $row['staff_email'];
	
	if($count != "0"){
		
		require("_includes/hashing.php");
    		$hasher = new PasswordHash(8, false);
		$pass1  = auth_code(10);
		$pass2  = $hasher->HashPassword($pass1);
	
		$sql2 = "UPDATE staff_newT SET staff_password = '$pass2' WHERE staff_id = '$sid'";
		$result2 = mysql_query($sql2);
		
		if($result){
			$to      = $semail;
			$headers = "From: ABE <john.smith@test.com>\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= "Reply-To: ABE <noreply@test.com>\n";
			$headers .= "X-Priority: 1\n";
			$headers .= "X-MSmail-Priority: High\n";																												
			$subject = "ABE - Password reminder";
			$message  = '<html><body>';
			$message .= 	'<table cellpadding="0" cellspacing="0" border="0" align="center" width="595">';
			$message .= 		'<tr><td style="width:595px; height:100px; padding:20px 0;"><img src="http://test.com/_assets/images/logo.png" alt="Logo" style="margin:"0 auto;" /></td></tr>';
			$message .= 		'<tr><td style="width:595px; padding-bottom:10px;">Hi ' . $sname . '</td></tr>';
			$message .= 		'<tr><td style="width:595px; padding-bottom:10px;">Your temporary password for ABE is : <b style="color:#E50077;">' . $pass1 . '</b></td></tr>';
			$message .= 		'<tr><td style="width:595px; padding-bottom:10px;">Do not forget to change your password after you log in. Try and use a variation of letters, numbers, and symbols to keep the system as secure as possible.</td></tr>';
			$message .= 		'<tr><td style="width:595px; padding-bottom:10px;">If you have not requested to change your password, please forward this email to the digital team.</td></tr>';
			$message .= 		'<tr><td style="width:595px; padding-bottom:10px;">Best regards,</td></tr>';
			$message .= 		'<tr><td style="width:595px;">ABE</td></tr>';
			$message .= 	'</table>';
			$message .= '</body></html>';			
			

			
			if (@mail($to, $subject, $message, $headers)) {	
				echo "1";
			}
			else{
				echo "2";
			}
		}
		else{
			echo "3";
		}
	}
	else{
		echo "4";
	}
?>
