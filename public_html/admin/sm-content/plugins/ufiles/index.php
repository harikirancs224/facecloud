<?php

$tarray=array("_aprvd_files"=>"Approved Files","_pending_files"=>"Pending Files","_rejected_files"=>"Rejected Files","_all_files"=>"All Files");

add_admin('admin_users', 'admin_users','admin','Files','cloud',$tarray,"fa-th",''); 
add_admin('admin_users', 'admin_users','admin_two','Files','cloud',$tarray,"fa-th",'');

function admin_users()
{
	global $smdb;
	
	$args = func_get_args();
	$tarraya=$args[0][0]["sub"];	
	include('list.php');
	include('view.php');
	foreach($tarraya as $key=>$value)
	{
		
		if(isset($_GET[$key]))
		{
			define("PLUGKEY",$key);
			if(file_exists(SM_PLUGIN_DIR.'/'.$_GET[$key].'.php'))
				include(SM_PLUGIN_DIR.'/'.$key.'.php');
			else
				include($key.'.php');
		}
	}			/* $handle = opendir($path);	while ($file = readdir($handle)) {		echo $file . "<br>";	}	closedir($handle); */
}

function get_pending_page(){ 
	include('list.php');	
	file_posts("pending","_pending_files");
}