<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to Twitter::Registration</title>
	
<link rel="stylesheet" type="text/css" href="<? echo base_url();?>css/mystyle.css">
	
<script language="javascript">
function registerform(){
	registerForm.submit();
}
</script>
</head>
<body>

<div id="logoID">New User Registration</div>

<div id="spacerID"></div>

<div id="msgID" style="display:block">
<?php
if(isset($message)){
	echo($message);
}
?>
</div>

<div id="spacerID"></div>

<div id="registerFormID">
<?php
//load the form helper class
$this->load->helper('form');

//open the form tab and set action to validate function of the login class
echo form_open('register/verifyRegister',array('name' => 'registerForm')); 

//set the label for the usename
echo form_label('Username', 'usernameID',  array( 'id' => 'labelUserID'));

//text input type for usename
echo form_input(array('name'        => 'username','id'          => 'usernameID'));

//set the label for the usename
echo form_label('Email', 'emailID',  array( 'id' => 'labelEmailID'));

//text input type for usename
echo form_input(array('name'        => 'email','id'          => 'emailID'));

//set the label for the password
echo form_label('Password', 'passwordID',  array( 'id' => 'labelPassID'));

//text input type for usename
echo form_password(array('name'        => 'password','id'          => 'passwordID'));

//close the form
echo form_close();
?>
<div id="loginbuttonID"><a href="<?php echo(base_url());?>login">Login</a></div>
<div id="registerbuttonID"><a href="javascript:registerform()">Register</a></div>
<div id="forgotpassID"><a href="recover_pass.php">forgot password?</a></div>
</div>
<div id="instructionID">
</div>

</body>
</html>