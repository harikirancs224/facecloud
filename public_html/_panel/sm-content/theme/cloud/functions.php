<?php
function sm_head()
{
	GLOBAL $theme_header_scripts;
	echo '
	<link href="'.get_bloginfo('root_template_directory').'/css/font-awesome.css" rel="stylesheet" type="text/css" media="all">
	<link href="'.get_bloginfo('template_directory').'/css/style.css" rel="stylesheet" type="text/css" media="all">
	<link href="'.get_bloginfo('root_template_directory').'/style.css" rel="stylesheet" type="text/css" media="all">
	<link href="'.get_bloginfo('root_template_directory').'/css/style.css" rel="stylesheet" type="text/css" media="all">
	<link href="'.get_bloginfo('root_template_directory').'/style-desk.css" rel="stylesheet" type="text/css" media="all">
	<link href="'.get_bloginfo('root_template_directory').'/css/bootstrap.min.css" rel="stylesheet">
	<link href="'.get_bloginfo('root_template_directory').'/style-ask.css" rel="stylesheet">
	<link rel="stylesheet" href="'.get_bloginfo('root_template_directory').'/css/selectize.default.css">
	
	<link type="text/css" rel="stylesheet" href="'.get_bloginfo('mobile_template_directory').'/css/demo.css" />
	<link type="text/css" rel="stylesheet" href="'.get_bloginfo('mobile_template_directory').'/css/jquery.mmenu.css" />
	<link type="text/css" rel="stylesheet" href="'.get_bloginfo('mobile_template_directory').'/css/addons/jquery.mmenu.dragopen.css" />
	
	<script type="text/javascript" src="'.get_bloginfo('mobile_template_directory').'/js/jquery.min.js"></script>
	'.$theme_header_scripts;
	
	
}
function sm_foot()
{
	GLOBAL $theme_header_scripts;$f="";
	//$f.='<script type="text/javascript" src="'.get_bloginfo('mobile_template_directory').'/js/jquery.mmenu.min.js"></script>';
	//$f.='<script type="text/javascript" src="'.get_bloginfo('mobile_template_directory').'/js/addons/jquery.mmenu.dragopen.min.js"></script>';
	
	//$f.='<script type="text/javascript" src="'.get_bloginfo('mobile_template_directory').'/js/addons/jquery.mmenu.fixedelements.min.js"></script>';
	
	

	$f.='<script type="text/javascript" src="'.get_bloginfo('root_template_directory').'/js/app.js"></script>';
	$f.='<script type="text/javascript" src="'.get_bloginfo('root_template_directory').'/js/intro.js"></script>';
	//$f.='<script type="text/javascript" src="'.get_bloginfo('root_template_directory').'/js/jquery.easing.min.js"></script>';
	//$f.='<script type="text/javascript" src="'.get_bloginfo('root_template_directory').'/js/selectize.js"></script>';
	
	$f.='<!-- Bootstrap core JavaScript  ================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="'.get_bloginfo('template_directory').'/js/bootstrap.min.js"></script>';
		
	$f.=theme_footer_scripts();

	$f.='<script>'.script().'</script>';
	echo $f;
}