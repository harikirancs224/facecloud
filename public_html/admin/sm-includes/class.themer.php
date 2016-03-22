<?php
// take request
if($_SERVER['HTTP_HOST']=="192.168.0.143")
{
	if(!defined('SITEROOT'))
		define( 'SITEROOT', 'applications/cld' );
	define( 'SITE', 'http://192.168.0.143' );
}
else
{
	if(!defined('SITEROOT'))
		define( 'SITEROOT', '' );	
		
	define( 'SITE', 'admin.facecloud.us' );
	
}
define( 'TERMS_CONDITIONS', 'I read and accept the Terms & Conditions of Cloud' );
global $smdb;

$subdomain=array_shift((explode(".",$_SERVER['HTTP_HOST'])));


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

define("CHECKLOCATION",$slugarray[0]);

$themer="default";
//$themer=$module="classified";
		
if($_SERVER['HTTP_HOST']=="192.168.0.143")
{		
	$module="shankam";
	
	$routeurl='http://192.168.0.143/'.SITEROOT;
	$moduleurl='http://192.168.0.143/'.SITEROOT;


		$module="cloud";
		$themer="cloud";
	
}
else
{

	
	/* $moduleurl='http://'.'.SITE;
	$module="classified";
	$themer=$subdomain; */
		
	
		$moduleurl='http://'.SITE;
		$themer="cloud";
		
		$module="cloud";
		//$themer=$module="classified";
	
}

$modulelist=array("Classifieds"=>"classifieds");

define('SMMODULELIST', serialize($modulelist));

if(in_array($thisslugs[0],array(ADMINER)))
	$themer="adminer";

	$themer="adminer";
if(in_array($thisslugs[0],array(USINER)))
	$themer="dashboard";

	if(!defined('SMMODULE'))
		define( 'SMMODULE', $module );
		
	if(!defined('SMTHEME'))
		define( 'SMTHEME', $themer );
		
	if(!defined('MODULEURL'))
		define( 'MODULEURL', $moduleurl );
	
		define( 'ROUTEURL', "http://".SITE );
		
$catids=array("cloud"=>"1993","shankam"=>"59");

define('CATID',$catids[SMMODULE]);
		
	