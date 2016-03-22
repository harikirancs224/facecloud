<?php
function get_plugins()
{
	$sm_plugins = array ();
	$plugin_root = SM_PLUGIN_DIR;
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
						/* if ( substr($subfile, -4) == '.php' )
							$plugin_files[] = "$plugin_root/$file/$subfile"; */
						if ( $subfile == 'index.php' )
							$plugin_files[] = "$plugin_root/$file/$subfile";
					}
					closedir( $plugins_subdir );
				}
			} else {
				if ( substr($file, -4) == '.php' )
					$plugin_files[] = $file;
			}
		}
		closedir( $plugins_dir );
	}
	return $plugin_files;
}
function plugins_url($file=null,$path=null)
{
	global $currentplugin;
	return get_bloginfo('plugin_url').'/'.$path.'/'.$file;
}

/** Plugin system **/

$listeners = array();

/* Create an entry point for plugins */
function plugin_hook(){
  global $listeners;

  $num_args = func_num_args();
  $args = func_get_args();

  if($num_args < 2)
    trigger_error("Insufficient arguments", E_USER_ERROR);

  // Hook name should always be first argument
  $hook_name = array_shift($args);

  if(!isset($listeners[$hook_name]))
    return; // No plugins have registered this hook

  foreach($listeners[$hook_name] as $func){
    $args = $func($args); 
  }

  return $args;
}

/* Attach a function to a hook */
function add_listener($hook, $function_name){
  global $listeners;

  $listeners[$hook][] = $function_name;
}