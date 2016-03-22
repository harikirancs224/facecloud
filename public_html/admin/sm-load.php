<?php
//ini_set('memory_limit', '521M');
/* if(!defined('SMMODULE'))
	define( 'SMMODULE', 'classified' ); */
define("ADMINEMAIL","wayitsolutions.com@gmail.com");
define( 'SMTITLE', 'FaceCloud' );
define( 'ADMINER', 'myadmin' );
define( 'USINER', 'dashboard' );
//define( 'AGINER', 'agent' );
//define( 'USINERP', 'page' );

define( 'USERIDKEY', 'SM' );


define( 'LANGUAGE', 'english' );
define( 'CURRENCY', 'inr' );
define( 'DEFAULT_LOCATION', 'karimnagar' );


define( 'CURRENCYVIEW', '<i class="fa fa-'.CURRENCY.'"></i>&nbsp;' );

define( 'SMMAIN', 'shankam' );
	


if(isset($_POST['loader']))
	define('LOADER','ajax');
	
define( 'ABSPATH', dirname(__FILE__) . '/' );
define( 'SMINC', 'sm-includes' );
define( 'SM_CONTENT_DIR', ABSPATH . 'sm-content' );


define( 'SM_UPLOAD_DIR', ABSPATH . 'sm-upload' );
define( 'SM_UPLOAD', '/sm-upload/' );



define( 'SM_PLUGIN_DIR', SM_CONTENT_DIR . '/plugins' );
define( 'SM_DASHBOARD_DIR', SM_CONTENT_DIR . '/dashboards' );


define( 'SM_ADMIN_DIR', ABSPATH . 'sm-admin' );
define( 'SM_USER_DIR', ABSPATH . 'dashboard' );

define( 'THEME', 'theme' );

define( 'LIMIT', '6' );


define( 'FREEADKEY', 'SF' );define( 'PREMIUMADKEY', 'SP' );
define( 'CFREEADKEY', 'SFC' );define( 'CPREMIUMADKEY', 'SPC' );
define( 'IFREEADKEY', 'SFI' );define( 'IPREMIUMADKEY', 'SPI' );
define( 'JFREEADKEY', 'SFJ' );define( 'JPREMIUMADKEY', 'SPJ' );
define( 'RFREEADKEY', 'SFR' );define( 'RPREMIUMADKEY', 'SPR' );
define( 'MFREEADKEY', 'SFM' );define( 'MPREMIUMADKEY', 'SPM' );
define( 'EFREEADKEY', 'SFE' );define( 'EPREMIUMADKEY', 'SPE' );


/* if(!defined('SMTHEME'))
	define( 'SMTHEME', 'theme1' ); */

if(!defined('SM_DASHBOARD_THEME'))	
	define('SM_DASHBOARD_THEME', 'dashboard' );
	
if(!defined('SMDASHBOARD'))	
	define( 'SMDASHBOARD', 'classified' );

if ( file_exists( ABSPATH . 'sm-config.php') ) {

	/** The config file resides in ABSPATH */
	require_once( ABSPATH . 'sm-config.php' );

} elseif ( file_exists( dirname(ABSPATH) . '/sm-config.php' ) && ! file_exists( dirname(ABSPATH) . '/sm-settings.php' ) ) {

	/** The config file resides one level above ABSPATH but is not part of another install */
	require_once( dirname(ABSPATH) . '/sm-config.php' );

} 
else
{
	echo 'oops';
}

?>