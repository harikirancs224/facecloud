<?php
if(isset($NOTFOUND))
{
	//include(  SM_CONTENT_DIR .'/'. THEME .'/'. SMTHEME .'/404.php' );
	//exit();
}
$ll=get_userdata("smrights");
define("SMEMPLOYEE",get_userdata("smadmin"));
$ntallowd=array("register","login");
if(PAGETEMP=='')
{
	put_title("Home");
	
	if(empty($ll))
		define('THEME_PAGE','login.php');
	else
		define('THEME_PAGE','index.php');
}
else
{
	list($x,$y)=explode('.',$templates[TEMPLATE]);
	if((empty($ll))&&(!in_array($x,$ntallowd)))
		define('THEME_PAGE','login.php');
	else
		define('THEME_PAGE',$templates[TEMPLATE]);
	/* $result = $smdb->get_results("select *from _settings");
	foreach( $result as $row )
		echo $row->key.'-->'.$row->val.'<br/>';  */
}
include( SM_CONTENT_DIR .'/' .THEME .'/'. SMTHEME . '/'. THEME_PAGE);