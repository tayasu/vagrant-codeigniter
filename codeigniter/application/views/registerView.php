<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Twitter::Registration</title>

	<style type="text/css">
body{
	margin:0px 0px 0px 0px;
}

#logoID{
	background:#F5F5F5;
	width:100%;
	height:70px;
	position:absolute;
	left:0px;
	top:0px;
	border-bottom:1px #E5E5E5 solid;
	font-family:"Arial Black", Gadget, sans-serif;
	font-size:xx-large;
	font-weight:bold;
	padding:20px 0px 0px 20px;
}

#msgID{
	background:#FFC;
	width:95%;
	position:absolute;
	left:12px;
	top:100px;
	border:1px #69C solid;
	font-family:Arial, Helvetica, sans-serif;
	padding:0px 10px 0px 10px;
}

#formID{
	background:#F5F5F5;
	width:308px;
	height:291px;
	position:absolute;
	top:134px;
	left:68%;
	border:1px #E5E5E5 solid;
}

#usernameID{
	position:absolute;
	top: 46px;
	border:2px #B40313 solid;
	width:160px;
	left: 89px;
	padding:5px 5px 5px 5px;
}

#labelUserID{
	position:absolute;
	top: 20px;
	width:36px;
	left: 90px;
	padding:5px 5px 5px 5px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:smaller;
	color:#B40313;
	font-weight:bold;
}

#emailID{
	position:absolute;
	top: 111px;
	border:2px #B40313 solid;
	width:160px;
	left: 89px;
	padding:5px 5px 5px 5px;
}

#labelEmailID{
	position:absolute;
	top: 78px;
	width:36px;
	left: 90px;
	padding:5px 5px 5px 5px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:smaller;
	color:#B40313;
	font-weight:bold;
}

#passwordID{
	position:absolute;
	border:2px #B40313 solid;
	left: 89px;
	top: 175px;
	width: 160px;
	padding:5px 5px 5px 5px;
}

#labelPassID{
	position:absolute;
	left: 90px;
	top: 144px;
	width: 60px;
	padding:5px 5px 5px 5px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:smaller;
	color:#B40313;
	font-weight:bold;
}

#loginbuttonID a{
	position:absolute;
	left: 105px;
	top: 218px;
	width: 50px;
	height: 20px;
	text-align:center;
	font:11px arial;
	color: #FFFFFF;
	font-weight:bold;
	padding-top:8px;
	padding-bottom:2px;
	padding-left:5px;
	padding-right:5px;
	text-decoration: none;
	background-color:#B40313;
}
#loginbuttonID a:hover{
	color:#ffffff;
	background:#DE909D; 
}

#registerbuttonID a{
	position:absolute;
	left: 177px;
	top: 217px;
	width: 50px;
	height: 20px;
	text-align:center;
	font:11px arial;
	color: #FFFFFF;
	font-weight:bold;
	padding-top:8px;
	padding-bottom:2px;
	padding-left:5px;
	padding-right:5px;
	text-decoration: none;
	background-color:#B40313;
}
#registerbuttonID a:hover{
	color:#ffffff;
	background:#DE909D; 
}
#forgotpassID a{
	position:absolute;
	left: 119px;
	top: 256px;
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size:smaller;
	color:#B40313;
}
#forgotpassID a:hover{
	text-decoration:none;
}

#search_boxID{
	position:absolute;
	left:25em;
	width:25em;
	background:#ffffff;
	border:#B40313 solid 2px;
	position:relative;
	padding:5px 5px 5px 5px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:normal;
	color:#000000;
}

#navigation a {
	text-align:center;
	font:11px arial;
	color: #FFFFFF;
	font-weight:bold;
	text-decoration: none;
	padding:10px;
	background-color:#B40313;
	}
	
#navigation a:hover {
	color:#000000;
	background:#DE909D; 
	}

    </style>
	
<script language="javascript">
function registerform(){
	registerForm.submit();
}
</script>
</head>
<body>

<div id="logoID">New User Registration</div>

<div id="msgID" style="display:block">
<?php
//load the form helper class
$this->load->helper('form');

//echo any type of errors
$username_error=form_error('username');
$email_error=form_error('email');
$password_error=form_error('password');

if($username_error==true && $password_error==true){
	echo("<p>Username and Password fields are required.</p>");
}
else{
	if($username_error==true){
		echo("<p>Username field is required.</p>");	
	}
	elseif($password_error==true){
		echo("<p>Password field is required.</p>");
	}
	else{
		echo("");
	}
}

echo($email_error);
?>
</div>

<div id="formID">
<?php

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
<div id="loginbuttonID"><a href="login">Login</a></div>
<div id="registerbuttonID"><a href="javascript:registerform()">Register</a></div>
<div id="forgotpassID"><a href="recover_pass.php">forgot password?</a></div>
</div>
<div id="instructionID">
</div>

</body>
</html>