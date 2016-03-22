<?php
if(isset($NOTFOUND))
{
	include(  SM_CONTENT_DIR .'/'. THEME .'/'. SMTHEME .'/404.php' );
	exit();
}
if(PAGETEMP=='')
{
	define('THEME_PAGE','index.php');
}
else
{
	
	define('THEME_PAGE',$templates[TEMPLATE]);
	/* $result = $smdb->get_results("select *from _settings");
	foreach( $result as $row )
		echo $row->key.'-->'.$row->val.'<br/>';  */
}

 include( SM_CONTENT_DIR .'/' .THEME .'/'. SMTHEME . '/'. THEME_PAGE); 



