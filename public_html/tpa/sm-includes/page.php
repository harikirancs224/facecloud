<?php
$pinfo=new _pageinfo;
define( 'PAGETEMP',$pinfo->temp(SLUG) );
	

if(!defined('LOADER'))
{
	include( SM_CONTENT_DIR .'/' .THEME .'/'. SMTHEME . '/functions.php');
	if(SLUG=='dashboard')
		include( SM_CONTENT_DIR .'/' .THEME .'/'. SM_DASHBOARD_THEME . '/loader.php');
	else
		include( SM_CONTENT_DIR .'/' .THEME .'/'. SMTHEME . '/loader.php');
}


