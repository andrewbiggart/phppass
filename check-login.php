            <?php
					
                    if($_POST["email"] != "" && $_POST["psw"] != ""){
                            
                        include("_includes/config.php");
						
			$username_p        = htmlspecialchars(mysql_real_escape_string($_POST["email"]));
                        $password_p        = htmlspecialchars(mysql_real_escape_string($_POST["psw"]));
			$remember          = htmlspecialchars(mysql_real_escape_string($_POST["remember"]));
			$redirect          = htmlspecialchars($_GET['redirect']);
                
                        if (strlen($password_p) < 73) {
                              
			    // Check email address enter exists and store password.
							        
                            $sql           = "SELECT staff_password FROM staff_newT WHERE staff_email='$username_p'";
                            $result        = mysql_query($sql);
                            $row           = mysql_fetch_array($result);
							
				if($result) {
                                
					// Hash entered password and check it against stored password.
								    
					require("_includes/hashing.php");
					$hasher        = new PasswordHash(8, false);
					$stored_hash   = "*";
					$stored_hash   = $row['staff_password'];
					$check         = $hasher->CheckPassword($password_p, $stored_hash);
										
					if($check){
									
						require('_includes/functions.php');
										
						//	Passwords have matched, select all user data.
										
						$sql1      = "SELECT staff_id, staff_name, staff_level, staff_login_current FROM staff_newT WHERE staff_email='$username_p'";
						$result1   = mysql_query($sql1);
						$row1      = mysql_fetch_array($result1);
									
						$sid       = $row1['staff_id'];
						$name      = $row1['staff_name'];
						$level     = $row1['staff_level'];
						$current   = $row1['staff_login_current'];
									
						// Create new authcode variable.
											
						$authcode  = auth_code(30);
									
						// Update staff status and authcode.
									
						$sql2      = "UPDATE staff_newT SET staff_status = 'Logged In', staff_authcode = '$authcode' WHERE staff_id = '$sid'";
						$result2   = mysql_query($sql2);
											
						if($result1 && $result2){
										
							// Update last logged in date.
												
							$sql3    = "UPDATE staff_newT SET staff_login_last = '$current' WHERE staff_id = '$sid'";
							$result3 = mysql_query($sql3);
										
							if($result3){
											 
								// Update current logged in date.
													
								$date    = date('Y-m-d H:i:s');
								$sql4    = "UPDATE staff_newT SET staff_login_current = '$date' WHERE staff_id = '$sid'";
								$result4 = mysql_query($sql4);
													
								if($result4){
												
									// Set session / cookie variables and redirect the user.
									session_register("uid");
									session_register("uname");
									session_register("ulevel");
									$_SESSION["uid"]    = $sid;
									$_SESSION["uname"]  = $name;
									$_SESSION["ulevel"] = $level;
									setcookie("userid" ,$sid, mktime (0, 0, 0, 12, 31, 9999));
														
									if($remember == "true") { 
										setcookie("authcode", $authcode, time() + 86400 * 365 * 2); 
									} // Check if the user wants to be remembered.
									
									if(!empty($redirect)) {
										echo $redirect; 
									} // Check if the user has been redirected from another page.
									else {
										echo 2;			
									}
												
								} // Check if the users current login status has been updated.
								else {
									echo 3;
								}
													
							} // Check if the users login status has been updated.
							else {
								echo 3;
							}
											
						} // Check if the users status has been updated.
						else {
							echo 3;
						}
										
					} // Check the entered password against the stored hash.
					else {
						echo 4;
					}
							
				}// Check email address is in the database
				else {
					echo 5;	
				} 
                                    
                        } // Checked the character length of the password.
                        else {
                            echo 6;
                        }
                                
                    } // Check both fields have been filled in.
					else {
            	        echo 7;
                    }
                
            ?> 
