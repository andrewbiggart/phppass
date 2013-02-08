$(document).ready(function() {
    
	//////////////////////////////////////////////////////////////
	// Create checkbox animation
	//////////////////////////////////////////////////////////////
	$("#rememberme").click(function(e) {
		e.preventDefault();
		if($(this).hasClass('unchecked')){
			$("#remember").attr('checked','checked');
			$(this).removeClass('unchecked');
			$(this).addClass('checked');
		}
		else if($(this).hasClass('checked')){
			$("#remember").removeAttr('checked');
			$(this).removeClass('checked');
			$(this).addClass('unchecked');
		}
	});
	
	//////////////////////////////////////////////////////////////
	// Show forgotten password form
	//////////////////////////////////////////////////////////////
	$("#login-forgotten").click(function(e) {
		e.preventDefault();
		$("#login-response").empty();
		$("#login-form").fadeOut(100, function() {
			$("#login-response").html("<div class=\"msg rounded5 shadow\">Please enter your email address. You will receive a link to create a new password via email.</div>");
			$("#forgot-form").fadeIn(300);
		});
	});
	
	//////////////////////////////////////////////////////////////
	// Show login form
	//////////////////////////////////////////////////////////////
	$("#login-login").click(function(e) {
		e.preventDefault();
		$("#login-response").empty();
		$("#forgot-form").fadeOut(100, function() {
			$("#login-form").fadeIn(300);
		});
	});
	
	//////////////////////////////////////////////////////////////
	// Check login credentials
	//////////////////////////////////////////////////////////////
	$("#login-btn").click(function(e) {
		
		e.preventDefault();
		
		var email    = $('#username').val();
		var psw      = $('#password').val();
		var remember = $('#remember').is(':checked');
		
		//Adding loading data
		$('#login-form-loading').show();

		$.post("check-login.php", { email:email, psw:psw , remember:remember},
		function(check_login){
			if(check_login == 1){
				$('#login-form-loading').hide();
				window.location = "pending.php";	
			}
			else if(check_login == 2){
				$('#login-form-loading').hide();
				window.location = "index.php";	
			}
			else if(check_login == 3){
				$('#login-form-loading').hide();
				$('#login-response').empty();	
				$('#login-response').html("<div class=\"error rounded5 shadow\">Error! Please try logging in again.</div>");	
			}
			else if(check_login == 4){
				$('#login-form-loading').hide();
				$('#login-response').empty();	
				$('#login-response').html("<div class=\"error rounded5 shadow\">Error! The details your entered are not correct.</div>");	
			}
			else if(check_login == 5){
				$('#login-form-loading').hide();
				$('#login-response').empty();	
				$('#login-response').html("<div class=\"error rounded5 shadow\">Error! Email not found. Please try again.</div>");	
			}
			else if(check_login == 6){
				$('#login-form-loading').hide();
				$('#login-response').empty();	
				$('#login-response').html("<div class=\"error rounded5 shadow\">Error! Passwords must be below 72 characters.</div>");	
			}
			else if(check_login == 7){
				$('#login-form-loading').hide();
				$('#login-response').empty();	
				$('#login-response').html("<div class=\"error rounded5 shadow\">Error! Please enter your email and password.</div>");	
			}
			else{
				$('#login-form-loading').hide();
				window.location = check_login;	
			}
		});
	});
	
	//////////////////////////////////////////////////////////////
	// Check reminder credentials
	//////////////////////////////////////////////////////////////
	$("#retrieve-btn").click(function(e) {
		
		e.preventDefault();
		
		var email = $('#email').val();
		
		//Adding loading data
		$('#forgot-form-loading').show();
		
		$.post("check-email.php", { email:email },
		function(reset_result){
			if(reset_result == 1){
				$('#forgot-form-loading').hide();
				$('#login-response').empty();
				$('#login-response').html('<div class=\"success rounded5 shadow\">Your temporary password has been emailed to you.</div>');
				$('#email').val('');
			}
			else if(reset_result == 2){
				$('#forgot-form-loading').hide();
				$('#login-response').empty();
				$('#login-response').html('<div class=\"error rounded5 shadow\">Error! Your password could not be sent at this time.</div>');
			}
			else if(reset_result == 3){
				$('#forgot-form-loading').hide();
				$('#login-response').empty();
				$('#login-response').html('<div class=\"error rounded5 shadow\">Error! A temporary password could not be created, Please try again.</div>');
			}
			else if(reset_result == 4){
				$('#forgot-form-loading').hide();
				$('#login-response').empty();
				$('#login-response').html('<div class=\"msg rounded5 shadow\">Error! Please enter a valid Peppermint email address.</div>');
			}
		});
	});
});