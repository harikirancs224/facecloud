<?php
$c=get_profileid();
if(empty($c))
	$c=get_loginid();

$a=get_userdata("smrights");
$usersin=get_post($c);
//$mnr=SMMODULE.'_profile_type';
//if(!empty($a)&&(SLUG==ADMINER)){
if(!empty($a)){
	//define('SMRIGHTS','admin');
	define('SMRIGHTS',$a);
}
else if(!empty($c)&&(SLUG==USINER))
{
	if(in_array(SMMODULE,array("jobs")))
		define('SMRIGHTS',$usersin->post_expert);
	else
		define('SMRIGHTS','user');
}