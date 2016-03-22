<?php
function dashboard_menu()
{

}
function d_get_header()
{
	include('header.php');
}
function d_menu_list()
{
	include('menu.php');
}
function d_top()
{
	include('top.php');
}

function get_dashboards($plugin_folder = '') {
	$sm_plugins = array ();
	$plugin_root = SM_DASHBOARD_DIR.'/'.SMDASHBOARD;
	// Files in sm-content/plugins directory
	$plugins_dir = @ opendir( $plugin_root);
	$plugin_files = array();
	if ( $plugins_dir ) {
		while (($file = readdir( $plugins_dir ) ) !== false ) {
			if ( substr($file, 0, 1) == '.' )
				continue;
			if ( is_dir( $plugin_root.'/'.$file ) ) {
				$plugins_subdir = @ opendir( $plugin_root.'/'.$file );
				if ( $plugins_subdir ) {
					while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
						if ( substr($subfile, 0, 1) == '.' )
							continue;
						if ( substr($subfile, -4) == '.php' )
							$plugin_files[] = "$plugin_root/$file/$subfile";
					}
					closedir( $plugins_subdir );
				}
			} else {
				if ( substr($file, -4) == '.php' )
					$plugin_files[] = "$plugin_root/$file";
			}
		}
		closedir( $plugins_dir );
	}
	return $plugin_files;
}
?>