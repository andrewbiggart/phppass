<?php require('_includes/functions.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome to ABE | Login</title>
<link rel="stylesheet" type="text/css" href="_assets/css/style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script src="_assets/js/login.js" type="text/javascript"></script>
</head>

<body>
	<div id="login-wrapper"> 
        <div id="login-response">
            <?php
    
                $redirect = htmlspecialchars($_GET['redirect']);
                        
                if(isset($_COOKIE['authcode'])){
                            
                    include("_includes/config.php");
                     
		    // Select staff details that match the authcode cookie. 
					        
                    $authcookie  = htmlspecialchars($_COOKIE['authcode']);
                            
                    $sql         = "SELECT staff_id, staff_name, staff_level, staff_login_current FROM staff_newT WHERE staff_authcode='$authcookie'";
                    $result      = mysql_query($sql);
                    $count       = mysql_num_rows($result);
                    $row         = mysql_fetch_array($result);
            
                    $sid         = $row['staff_id'];
                    $name        = $row['staff_name'];
                    $level       = $row['staff_level'];
                    $current     = $row['staff_login_current'];
                            
                    if($count==1){
    
			// Create new authcode and update the users table.
	
                        $new_authcode  = auth_code(30);
                        $sql2    = "UPDATE staff_newT SET staff_status = 'Logged In', staff_authcode = '$new_authcode' WHERE staff_id = '$sid'";
                        $result2 = mysql_query($sql2);
                                
                        if($result2){
							
			    // Set session / cookie variables and redirect the user.
							
                            session_register("uid");
                            session_register("uname");
                            session_register("ulevel");
                            $_SESSION["uid"]    = $sid;
                            $_SESSION["uname"]  = $name;
                            $_SESSION["ulevel"] = $level;
                            setcookie("userid" ,$sid, time() + 86400 * 365 * 2);
                            setcookie("authcode", $new_authcode, time() + 86400 * 365 * 2);
                
                            if(!empty($redirect)) {
                                header("Location:" . $redirect) ;
                                exit(); 
                            } // Redirect variable isn't empty.
                            else {
								
				if($level == "Admin") {
					header("location:pending.php");
					exit();
				} // Admin check
				else {
					header("location:index.php");
					exit();
				}
                            } // Redirect variable id empty.
                                    
                        }
                                
                    } // Authcode cookie does match database entry.
                    else {
                                
                        include("_includes/config.php");
						
			// Check userid cookie against the database to see if they still have an active authcode.
						
                        $uid3        = $_COOKIE['userid'];
                        $sql3        = "SELECT staff_name FROM staff_newT WHERE staff_id = '$uid3' AND staff_authcode != ''";
                        $result3     = mysql_query($sql3);
                        $count3      = mysql_num_rows($result3);
                        $row3        = mysql_fetch_array($result3);
                        $staff_name  = $row3['staff_name'];
                            
                        if($count3 > 0) {
                            
			    // Delete authcode cookie.
			    setcookie("authcode", "", time() - 3600);
			    $sql4    = "UPDATE staff_newT SET staff_status = 'Logged Out', staff_authcode = '' WHERE staff_id = '$uid3'";
                            $result4 = mysql_query($sql4);
							
			    if($result4) {
                            	echo "<div class=\"error rounded5 shadow\">Authentication expired for $staff_name! Please login.</div>";
			    } // User has been logged out.
							
                        } // User has got an active authcode, renew authcode cookiedisplay expired message.
                        else {
			    // Delete authcode cookie.
                            setcookie("authcode", "", time() - 3600);
                        } // User hasn't got an active authcode, remove authcode cookie.
                                    
                    } // Authcode cookie doesn't match database entry.
                                         
                }// Authcode cookie is set.
            ?>      
        </div><!-- / login-response --> 
        <div id="login-box">
            <div id="login-box-inner">
                <div id="login-form">
                    <form name="loginform" id="loginform" method="post">
                        <div class="inputs-row">
                            <input type="text" name="username" id="username" class="rounded5" value="" size="40" tabindex="10">
                            <input type="password" name="password" id="password" class="rounded5" value="" size="20" tabindex="20" maxlength="72">
                            <a id="login-forgotten" class="left">Lost your password?</a><img src="_assets/images/loading.gif" alt="Loading..." id="login-form-loading" class="loading" />
                        </div><!-- / inputs-row -->
                        <div class="actions-row">
                            <input type="checkbox" name="remember" id="remember"> <a id="rememberme" class="unchecked"></a>&nbsp;Remember me
                            <input type="submit" name="login-btn" id="login-btn" class="btn rounded10 right" value="Log In" tabindex="100" />
                        </div><!-- / actions-row -->
                        <div class="cleaner"></div><!-- / cleaner -->
                    </form>
                </div><!-- / login-form -->
                <div id="forgot-form" style="display:none;">
                    <form name="forgotform" id="forgotform" method="post">
                    	<div class="inputs-row">
							<input type="text" id="email" name="email" class="rounded5" value="" size="40" tabindex="120" />
                        	<a id="login-login" class="left">Return to login page</a><img src="_assets/images/loading.gif" alt="Loading..." id="forgot-form-loading" class="loading" />
                        </div><!-- / inputs-row -->
                        <div class="actions-row">
                        	<input type="submit" id="retrieve-btn" name="retrieve-btn" class="btn rounded10 right" value="Retrieve" tabindex="140" />
                        </div><!-- / actions-row -->
                        <div class="cleaner"></div><!-- / cleaner -->
                    </form>
                </div><!-- / forgot-form -->
                <div class="cleaner"></div><!-- / cleaner -->
            </div><!-- / login-box-inner -->
        </div><!-- / login-box -->
        <div class="cleaner"></div><!-- / cleaner -->
    </div><!-- / login-wrapper -->
</body>
</html>
