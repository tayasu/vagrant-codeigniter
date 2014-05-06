<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to Twitter::Login</title>
	
<link rel="stylesheet" type="text/css" href="<? echo base_url();?>/css/mystyle.css">

	
<script language="javascript">
function loginform(){
	loginForm.submit();
}
</script>

</head>
<body>

<div id="logoID">Mini Twitter</div>

<div id="spacerID"></div>

<div id="msgID" style="display:<?php if($message==" "){echo("none");}else{echo("block");}?>">
<?php if(isset($message)){echo($message);}?>
</div>

<div id="spacerID"></div>

<div id="loginFormID">
<?php
echo form_open('login/verifyLogin',array('name' => 'loginForm'));
echo form_label('Email', 'loginemailID',  array( 'id' => 'loginlabelEmailID'));
echo form_input(array('name'=> 'email','id'=> 'loginemailID'));
echo form_label('Password', 'loginpasswordID',  array( 'id' => 'loginlabelPassID'));
echo form_password(array('name'=> 'password','id'=> 'loginpasswordID'));
echo form_close();
?>
<div id="loginloginbuttonID"><a href="javascript:loginform()">Login</a></div>
<br/>
<div id="loginregisterbuttonID"><a href="<?php echo(base_url());?>register">Register</a></div>
<div id="loginforgotpassID"><a href="recover_pass.php">forgot password?</a></div>
</div>

<br/>
<div id="footerID">
</div>

</body>
</html>