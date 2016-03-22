<?php
GLOBAL $smdb;
if((isset($_POST['log']))&&(isset($_POST['pwd'])))
{
$a1=strip_tags(mysql_real_escape_string(trim($_POST['log']))); 
$a2=strip_tags(mysql_real_escape_string(trim($_POST['pwd'])));

	$result=$smdb->get_results("select * from login_accounts where login_id='".$a1."' and login_password='".$a2."' and `pl_status`='active' and login_type!='admin' ");
	if(empty($result))
	{
		alert("Sorry No Records Found With Given Details");
	}
	else
	{
		alert("Logged In Successfully");
		$token=token();
		$ssid=getsession();
		
		
		$qu1="insert into login_history(`login_id`, `login_dt`, `login_token`, `logged_as`, `login_ip`, `login_session`, `plh_status`,token_updated_on) values('".$a1."',now(),'".$token."','".$result[0]->login_type."','".$_SERVER['REMOTE_ADDR']."','".$ssid."','in',now())";
		$re1=mysql_query($qu1) or die (mysql_error());
		
		set_userdata("smadmin",$result[0]->shankam_id);
		set_userdata("shankam",$result[0]->shankam_id);
		
		//set_userdata('logintype',$row['login_type']);
		set_userdata("token", $token);
		set_userdata("smrights", $result[0]->login_type);
		set_userdata("logintype", $result[0]->login_type);
		
		header("location:?welcome");
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title></title>
	<link rel="stylesheet" id="wp-admin-css" href="<?php bloginfo('template_directory'); ?>/login_files/wp-admin.min.css" type="text/css" media="all">
<link rel="stylesheet" id="buttons-css" href="<?php bloginfo('template_directory'); ?>/login_files/buttons.min.css" type="text/css" media="all">
<link rel="stylesheet" id="colors-fresh-css" href="<?php bloginfo('template_directory'); ?>/login_files/colors-fresh.min.css" type="text/css" media="all">

	</head>
	<body class="login login-action-login wp-core-ui">
	<div id="login">
	<center><img src="<?php bloginfo('template_directory'); ?>/login_files/wordpress-logo.png"/></center>

<form name="loginform" id="loginform" action="" method="post">
<?php
if(isset($_GET['verify']))
{
if(isset($msg))
	echo $msg;
?>
	<p>
		<label for="user_login">Enter Verification Code<br>
		<input type="text" name="verifylogin" id="verifylogin" class="input" value="" size="20">
		</label>
	</p>
	<p class="submit">
		<input type="submit" id="wp-submit" class="button button-primary button-large" value="Log In">
	</p>
<?php
}
else
{
?>
	<p>
		<label for="user_login">Username<br>
		<input type="text" name="log" id="user_login" class="input" value="" size="20"></label>
	</p>
	<p>
		<label for="user_pass">Password<br>
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20"></label>
	</p>
	<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember Me</label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In">
		<input type="hidden" name="redirect_to" value="#">
		<input type="hidden" name="testcookie" value="1">
	</p>
<?php
}
?>
</form>
	</div>

	
		<div class="clear"></div>
	
	
	</body></html>