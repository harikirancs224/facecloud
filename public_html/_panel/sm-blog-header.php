<?php
/**
 * Loads the WordPress environment and template.
 *
 * @package WordPress
 */

if ( !isset($sm_did_header) ) {

	$wp_did_header = true;

	require_once( dirname(__FILE__) . '/sm-load.php' );

	require_once( ABSPATH . SMINC . '/template-loader.php' );

}
