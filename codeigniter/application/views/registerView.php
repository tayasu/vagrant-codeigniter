<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to Twitter::Registration</title>
	
<link rel="stylesheet" type="text/css" href="<? echo base_url();?>css/mystyle.css">
	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js">
</script>
<script>
$(document).ready(function(){
	$("#registerID").click(function(){
		$("#registerFID").submit();
	});
});
</script>	
</head>
<body>

<div id="logoID">New User Registration</div>

<div id="spacerID"></div>

<div id="msgID" style="display:<?php if(validation_errors() == ""){echo("none");}else{echo("block");}?>">
<?php if(validation_errors()){echo validation_errors();}?>
</div>

<div id="spacerID"></div>

<div id="registerFormID">
<?php
echo form_open('register/verifyRegister',array('name' => 'registerForm','id'=>'registerFID')); 
echo form_label('Username', 'usernameID',  array( 'id' => 'labelUserID'));
echo form_input(array('name'=> 'username','id' => 'usernameID','value'=>set_value('username')));
echo form_label('Email', 'emailID',  array( 'id' => 'labelEmailID'));
echo form_input(array('name'=> 'email','id'=> 'emailID','value'=>set_value('email')));
echo form_label('Password', 'passwordID',  array( 'id' => 'labelPassID'));
echo form_password(array('name'=> 'password','id'=> 'passwordID','value'=>set_value('password')));
echo form_label('Confirm Password', 'confirmPasswordID',  array( 'id' => 'labelConfirmPassID'));
echo form_password(array('name'=> 'confirmPassword','id'=> 'confirmPasswordID','value'=>set_value('confirmPassword')));
echo form_close();
?>
<div id="loginbuttonID"><a href="<?php echo(base_url());?>login">Login</a></div>
<div id="registerbuttonID"><a href="#" id="registerID">Register</a></div>
<div id="forgotpassID"><a href="recover_pass.php">forgot password?</a></div>
</div>

<br/>
<div id="footerID">
</div>

</body>
</html>