<?php
define( 'SMTINC', 'theme' );

$smdb=new _smdb;

include( ABSPATH . SMINC . '/sm-load.php' );

include( ABSPATH . SMINC . '/general-template.php' );

include_dashboards();
include_plugins();


include( ABSPATH . SMINC . '/page.php' );
function load_template( $_template_file, $require_once = true ) {
	global $pinfo, $smdb;
	if ( $require_once )
		require_once( $_template_file );
	else
		require( $_template_file );
}
