<?php
// take request
if(!defined('AJAX'))
{
global $smdb;
//$request = trim($_SERVER['REQUEST_URI'], '/'); // would be something like your-slug
$request = strtok($_SERVER['REQUEST_URI'], '?'); // would be something like your-slug
$request = trim($request, '/'); // would be something like your-slug
$request = str_replace(SITEROOT,"",trim($request,"/"));
$request = trim($request,"/");
$thisslugs=explode("/",$request);
//print_r($thisslugs);
$slugarray=array();
foreach($thisslugs as $tslug)
	$slugarray[]=$tslug;
	
$request=$thisslugs[(count($thisslugs)-1)];
$thisslugs=explode("?",$request);
$request=$thisslugs[0];

// set up database connection and attempt to match slug


if(empty($request))
{
	if(!defined('SLUG'))
		define('SLUG','');
		
}
else
{
	$sql="SELECT * FROM _permalinks WHERE slug like '".$request."' LIMIT 1";
	$result = $smdb->get_results($sql);
	if(empty($result))
	{
		// do your page not found
		//header('HTTP/1.1 404 Not Found');
		//echo 'not founds';
		
		if(!defined('SLUG'))
			if(!in_array($request,array(ADMINER,USINER)))
			{
				define('SLUG','');$NOTFOUND='404';
			}
			else
				define('SLUG',$request);
		
	}
	foreach( $result as $row )
	{
		if(!defined('SLUG'))
			define('SLUG',$row->slug);
			
		define('TEMPLATE',$row->template);
	}
}

// if we're here, there's a matching page in the database
// display it in a template 
}
if(!defined('SLUG'))
	define('SLUG','');
?>