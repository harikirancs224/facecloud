<?php
function get_header( $name = null ) {

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates["header"] = "header-{$name}.php";
	else
		$templates["header"] = 'header.php';

	// Backward compat code will be removed in a future release
	load_template(  SM_CONTENT_DIR .'/'. THEME .'/' .SMTHEME. '/'.$templates["header"]);
}
function get_index( $name = null ) {

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates["index"] = "index-{$name}.php";
	else
		$templates["index"] = 'index.php';

	// Backward compat code will be removed in a future release
	load_template(  SM_CONTENT_DIR .'/'. THEME .'/' .SMTHEME. '/'.$templates["index"]);
}

function get_footer( $name = null ) {

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates["footer"] = "footer-{$name}.php";
	else
		$templates["footer"] = 'footer.php';

	// Backward compat code will be removed in a future release
	load_template(  SM_CONTENT_DIR .'/'. THEME .'/' .SMTHEME. '/'.$templates["footer"]);
}

function get_pag( $name = null ) {

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates["page"] = "page-{$name}.php";
	else
		$templates["page"] = 'page.php';

	// Backward compat code will be removed in a future release
	load_template(  SM_CONTENT_DIR .'/'. THEME .'/' .SMTHEME. '/'.$templates["page"]);
}

function get_sidebar( $name = null ) {

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates["sidebar"] = "sidebar-{$name}.php";
	else
		$templates["sidebar"] = 'sidebar.php';

	// Backward compat code will be removed in a future release
	load_template(  SM_CONTENT_DIR .'/'. THEME .'/' .SMTHEME. '/'.$templates["sidebar"]);
}


function get_template_part( $slug, $name = null ) {
GLOBAL $post;
	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates["gtp"] = "{$slug}-{$name}.php";
	else
		$templates["gtp"] = "{$slug}.php";
	
	require_once SM_CONTENT_DIR.'/'.THEME.'/'.SMTHEME.'/'.$templates["gtp"];
}
function get_root_template_part( $slug, $name = null ) {
GLOBAL $post;
	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates["gtp"] = "{$slug}-{$name}.php";
	else
		$templates["gtp"] = "{$slug}.php";

	require_once SM_CONTENT_DIR.'/'.THEME.'/_root/'.$templates["gtp"];
}

