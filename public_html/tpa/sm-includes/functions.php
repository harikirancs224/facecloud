<?php
//ini_set('memory_limit', '521M'); 
$templates=array(""=>"index.php",
"sidebar"=>"page.php",
"page"=>"page.php",
"category"=>"category.php",
"testimonials"=>"testimonials.php",
"post"=>"post.php",
"settings"=>"settings.php",
"job"=>"post.php",
"register"=>"register.php",
"user-auth"=>"user-auth.php",
"employer-zone"=>"register-employer.php",
"login"=>"login.php",
"search"=>"search.php",
"user"=>"user.php",
"project"=>"project.php",
"film"=>"film.php",
"profile"=>"profile.php",
"postad"=>"post-new.php",
"blogspot"=>"blogspot.php"
);

function get_options($parent,$type,$selected,$isactive="no"){
	global $smdb;
	$html="";
	if($parent=="dept")
		$parent="315";
	$parendesc="";
	
	if(!in_array($parent,array("all","0"))){
		$parendesc=" and parent='".$parent."'";
	}
	$active="";
	if($isactive=="active"){
		$active=" and post_status='publish'";
	}
	
	$result=$smdb->get_results("select *from _posts where post_type='".$type."' ".$parendesc.$active."  order by post_title asc");
	foreach($result as $row)
	{
		$hyp="";
		if($selected==$row->id)
			$html.='<option selected value="'.$row->id.'">'.$hyp.$row->post_title.'</option>';
		else
			$html.='<option value="'.$row->id.'">'.$hyp.$row->post_title.'</option>';
	}
	return $html;
}

$menulist=nav_menu();
function nav_menu()
{
	global $smdb;$menulist=array();
	$menulist["home"]="/";
	$result=$smdb->get_results("select * from _posts a inner join _permalinks b on a.id=b.pageid where page_typ='page' and slug in (select val from _taxonomy where typ='m_menu') order by a.id asc");
	foreach($result as $row)
		$menulist[$row->post_title]=$row->slug;
		
	return $menulist;
}

function menu_links($tag)
{
	global $smdb,$menulist;
	
	foreach($menulist as $key=>$val)
		echo '<a href="'.get_bloginfo('siteurl').'/'.$val.'"><'.$tag.'>'.$key.'</'.$tag.'></a>';
	
}


function get_moduleinfo()
{
	foreach(unserialize(SMMODULELIST) as $key=>$val)
	{
		if($val==SMMODULE)
			return $key;
	}
}
function include_dashboards()
{
	/* foreach(get_dashboards() as $duri)
	{
		require_once $duri;
	} */
}
function include_plugins()
{
	foreach(get_plugins() as $puri)
	{
		require_once $puri;
	}	
}

function do_shortcode($code)
{
	echo get_do_shortcode($code);
}
function get_do_shortcode($code)
{
	$code=trim($code,'[]');
	$atts=explode(' ',$code);
	$myarray=array();
	if(count($atts)>1)
	{
		for($i=1;$i<count($atts);$i++)
		{
			$p=explode('=',$atts[$i]);
				
			$myarray[$p[0]]=$p[1];
		}
	}
	$marray=$myarray;
		return plugin_hook($atts[0],$myarray);
}
function set_userdata($key,$val)
{
	$_SESSION[$key]=$val;
}
function unset_userdata($key,$val=null)
{
	unset($_SESSION[$key]);
}
function get_userdata($key)
{
	if(isset($_SESSION[$key]))
		return $_SESSION[$key];
	else
		return '';
}

function get_logout()
{
	if(isset($_GET['logout']))
	{
		foreach ($_SESSION as $key=>$val)
		{
			unset_userdata($key,$val);
			
		}
		
	}
}
function get_loginid()
{
	if(isset($_SESSION['shankam']))
		return $_SESSION['shankam'];
}
function get_profileid()
{
	if(in_array(SMMODULE,array("classifieds","info","realestate")))
		get_loginid();
	
	if(isset($_SESSION[SMMODULE]))
		return $_SESSION[SMMODULE];
}
$userdata = (object) array(
		'fname'=>"",
		'lname'=>"",
		'password'=>"",
		'loginid'=>"",
		'email'=>"",
		'mobile'=>"",
		'token'=>"",
		'ssid'=>""
		);
function make_my_login($email,$pass){
	$logdata = (object) array(
			'loginid'=>secure($email),
			'password'=>secure($email)
			);
			
	$status=login_user_check($logdata);
		 if($status!='fail')
			header("location:?welcome");
		else
			alert('Login Failed');
}
function get_login(){
	if(isset($_POST['userlogin']))
	{
		$logdata = (object) array(
			'loginid'=>secure($_POST['logname']),
			'password'=>secure($_POST['logpswrd'])
			);
		
		$status=login_user_check($logdata);
		if($status!='fail')
		{
			if(!isset($_POST['ajax'])){
				$url="dashboard/?welcome";
				if(isset($_GET["redirect"])) $url=$_GET["redirect"];
				header("location:".$url);
			}
		}
		else
			alert('Login Failed');
	}
}
function login_user_check($login)
{
	$qu="select * from login_accounts where login_id='".$login->loginid."' and login_password='".$login->password."'";
	$re=mysql_query($qu) or die(mysql_error());
	if($row=mysql_fetch_array($re))
	{
		if(session_id() == '') {
			session_start(); }
		$token=token();
		set_userdata('shankam',$row['shankam_id']);
		set_userdata('token',$token);
		set_userdata('logintype',$row['login_type']);
		set_userdata('loginname',$row['login_id']);
		
		set_userdata('matrimony',$row['sm_id']);
		set_userdata('jobs',$row['sj_id']);
		
		set_userdata('entertainment',$row['se_id']);
		
		$ssid=getsession();
		
		return "success";
	}
	else
	{
		return "fail";
	}
	
}
function token() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789-";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 40; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function getsession()
{
	$ses_id = session_id(); 
	if (empty($ses_id))
	{ 
		 //This is a reentry and the session already exists 
		 // create a new session ID and start a new 
		session_regenerate_id();         
		$ses_id = session_id();
	}
    return $ses_id; //turn the array into a string
}
function get_ip_address() 

                {
                    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
}
function get_cookie($val)
{
	if(isset($_COOKIE[$val]))
		return $_COOKIE[$val];
	else
		return "";
}
function set_cookie($key,$val)
{
	setcookie($key, $val, time()+86400, '/', '.wayits.com');
}
function get_qstring($val)
{
	if(isset($_GET[$val]))
		return $_GET[$val];
	else
		return "";
}
function getquery()
{
	$q_str="";
	$qr= explode("&", $_SERVER['QUERY_STRING']);
	foreach($qr as $key => $val) 
	{
		if(!empty($val))
		{
			$q_str.=$val."&";
		}
	}
	return $q_str;
}
function getqueryadvance($remove=null,$add=null)
{
	$q_str="";
	
	$qr= $_GET;
	
	foreach($qr as $key => $val) 
	{
		if(!empty($val))
		{
			if($val==$remove)
			{
			
			}
			else
				$q_str.=$val."&";
		}
	}
	return $q_str;
}

function fcheck($filename)
{
	if (file_exists($filename)) {
	    return $filename;
	}
	else
	{
		$filename='../'.$filename;
		if (file_exists($filename))
		{
			return $filename;
		}
		else
		{
			$filename='../'.$filename;
			if (file_exists($filename))
			{
				return $filename;
			}
			else
			{
				$filename='../'.$filename;
				if (file_exists($filename))
				{
					return $filename;
				}
				else
				{
					$filename='../'.$filename;
					if (file_exists($filename))
					{
						return $filename;
					}
					else
					{
						return '';
					}
				}
			}
		}
	}
}

function pathcheck($filename)
{
	if (file_exists($filename)) {
	    return 'exist';
	}
	else
	{
		return 'no';	   
	}
}

function secure($data)
{
	return strip_tags(mysql_real_escape_string(trim($data)));
}

function encryptcode($paswd)
{
  $mykey=getEncryptKey();
  $encryptedPassword=encryptPaswd($paswd,$mykey);
  return $encryptedPassword;
}
 
function decryptcode($paswd)
{
  $mykey=getEncryptKey();
  $decryptedPassword=decryptPaswd($paswd,$mykey);
  return $decryptedPassword;
}
 
function getEncryptKey()
{
  return base64_encode('priyankarahul');
}
function encryptPaswd($string, $key)
{
  $result = '';
  for($i=0; $i<strlen ($string); $i++)
  {
	$char = substr($string, $i, 1);
	$keychar = substr($key, ($i % strlen($key))-1, 1);
	$char = chr(ord($char)+ord($keychar));
	$result.=$char;
  }
	return base64_encode($result);
}
 
function decryptPaswd($string, $key)
{
  $result = '';
  $string = base64_decode($string);
  for($i=0; $i<strlen($string); $i++)
  {
	$char = substr($string, $i, 1);
	$keychar = substr($key, ($i % strlen($key))-1, 1);
	$char = chr(ord($char)-ord($keychar));
	$result.=$char;
  }
 
	return $result;
}
class _snkm
{
	public $output;
	function dd()
	{
		return 'gg';
	}
	function get_results($query = null	)
	{
		$new_array = array();
		$re=mysql_query($query) or die(mysql_error());

		return $re;
	}
}

class _div 
{
	public $close='</div>';
	function col($val)
	{
		echo '<div class="col-md-'.$val.'">';
	}
}
class _html
{
	function data($element,$class,$data)
	{
		return '<'.$element.' class="'.$class.'">'.$data.'</'.$element.'>';
	}
}
function spacer()
{
	echo '<div class="clr"></div>';
}
class _pageinfo
{

	function temp($page)
	{
		global $smdb;
		$result = $smdb->get_results("select *from _permalinks where slug='".$page."'");
		foreach( $result as $row )
			return $row->template; 
	}
}
$PHP_SELF;
function server_vars()
{
	global $PHP_SELF;
	$default_server_values = array(
		'SERVER_SOFTWARE' => '',
		'REQUEST_URI' => '',
	);

	$_SERVER = array_merge( $default_server_values, $_SERVER );

	// Fix for IIS when running with PHP ISAPI
	if ( empty( $_SERVER['REQUEST_URI'] ) || ( php_sapi_name() != 'cgi-fcgi' && preg_match( '/^Microsoft-IIS\//', $_SERVER['SERVER_SOFTWARE'] ) ) ) {

		// IIS Mod-Rewrite
		if ( isset( $_SERVER['HTTP_X_ORIGINAL_URL'] ) ) {
			$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
		}
		// IIS Isapi_Rewrite
		else if ( isset( $_SERVER['HTTP_X_REWRITE_URL'] ) ) {
			$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
		} else {
			// Use ORIG_PATH_INFO if there is no PATH_INFO
			if ( !isset( $_SERVER['PATH_INFO'] ) && isset( $_SERVER['ORIG_PATH_INFO'] ) )
				$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];

			// Some IIS + PHP configurations puts the script-name in the path-info (No need to append it twice)
			if ( isset( $_SERVER['PATH_INFO'] ) ) {
				if ( $_SERVER['PATH_INFO'] == $_SERVER['SCRIPT_NAME'] )
					$_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
				else
					$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
			}

			// Append the query string if it exists and isn't null
			if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
				$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
			}
		}
	}

	// Fix for PHP as CGI hosts that set SCRIPT_FILENAME to something ending in php.cgi for all requests
	if ( isset( $_SERVER['SCRIPT_FILENAME'] ) && ( strpos( $_SERVER['SCRIPT_FILENAME'], 'php.cgi' ) == strlen( $_SERVER['SCRIPT_FILENAME'] ) - 7 ) )
		$_SERVER['SCRIPT_FILENAME'] = $_SERVER['PATH_TRANSLATED'];

	// Fix for Dreamhost and other PHP as CGI hosts
	if ( strpos( $_SERVER['SCRIPT_NAME'], 'php.cgi' ) !== false )
		unset( $_SERVER['PATH_INFO'] );

	// Fix empty PHP_SELF
	$PHP_SELF = $_SERVER['PHP_SELF'];
	if ( empty( $PHP_SELF ) )
		$_SERVER['PHP_SELF'] = $PHP_SELF = preg_replace( '/(\?.*)?$/', '', $_SERVER["REQUEST_URI"] );
}
server_vars();

function get_option($val)
{
	$object = (object) array(
		'admin_email'=>"",
		'blog_charset'=>"",
		'html_type'=>"",
		'language'=>"",
		'title'=>"",
		'siteuserurl'=>MODULEURL."/dashboard",
		'siteadminurl'=>MODULEURL."sm-admin",
		'plugin_url'=>MODULEURL."/sm-content/plugins",
		'sitetitle'=>SMTITLE,
		'moduletitle'=>get_moduleinfo(),
		'blogname'=>"",
		'template_directory'=>MODULEURL."/sm-content/theme/".SMTHEME,
		'mobile_template_directory'=>MODULEURL."/sm-content/theme/_mobile",
		'root_template_directory'=>MODULEURL."/sm-content/theme/_root",
		'siteurl_path'=>MODULEURL,
		'routeurl'=>ROUTEURL,
		'siteurl'=>MODULEURL
		);
		
		return $object->$val;
}


$alisteners = array();
$amenu = array();

function admin_hook(){
  global $alisteners;

  $num_args = func_num_args();
  $args = func_get_args();

  if($num_args < 2)
    trigger_error("Insufficient arguments", E_USER_ERROR);

  // Hook name should always be first argument
  $hook_name = array_shift($args);
  if(!isset($alisteners[$hook_name]))
    return; // No plugins have registered this hook

  foreach($alisteners[$hook_name] as $func){
    $args = $func($args); 
  }

  return $args;
}


function add_admin($hook, $function_name,$rights="admin", $menu=null,$under="shankam",$submenu=array(),$class=null,$alert=array()){
if(!defined('SMRIGHTS'))
	define('SMRIGHTS','user');
	
$job=get_userdata("jobs_type");
if(!empty($job)){
	if(!defined('SMRIGHTSJOBS')){
		define("SMRIGHTSJOBS", $job);
		//echo 'defined'.SMRIGHTSJOBS.'-'.SMRIGHTS;
	}
}
//(defined("SMRIGHTSJOBS") && $rights==SMRIGHTSJOBS ) ||
global $alisteners,$amenu;
if( (($rights==SMRIGHTS ||(SMRIGHTS!="admin"&&$rights=="all")) && ($under==SMMODULE || $under==SMMAIN || $under=="all")))
	{
		
		$alisteners[$hook][] = $function_name;
		if(!empty($menu)){
			$amenu[$hook]=array("key"=>$hook,"name"=>$menu,"sub"=>$submenu,"class"=>$class,"alert"=>$alert);
		}
		else{}
	}
	else{}
}

/** Plugin system **/

$dlisteners = array();
$dmenu = array();

/* Create an entry point for plugins */
function d_hook(){
  global $dlisteners;

  $num_args = func_num_args();
  $args = func_get_args();

  if($num_args < 2)
    trigger_error("Insufficient arguments", E_USER_ERROR);

  // Hook name should always be first argument
  $hook_name = array_shift($args);

  if(!isset($dlisteners[$hook_name]))
    return; // No plugins have registered this hook

  foreach($dlisteners[$hook_name] as $func){
    $args = $func($args); 
  }

  return $args;
}

/* Attach a function to a hook */
function add_d_menu($hook, $function_name,$menu=null,$under=null){
  global $dlisteners,$dmenu;
	if($under==SMMODULE||$under=='')
	{
	  $dlisteners[$hook][] = $function_name;
	  if(!empty($menu))
		$dmenu[$hook]=$menu;
	}
}

function bloginfo( $show ) {
	echo get_bloginfo( $show );
}

 function get_templateinfo( $show = '' )
 {
	switch( $show ) {
		case 'templateurl' : // DEPRECATED
			$output = get_option('template_directory');
			break;
		case 'dashboardurl' : // DEPRECATED
			$output = get_option('siteuserurl');
			break;
		case 'template_directory':
			$output =get_option('template_directory');
			break;
		case 'mobile_template_directory':
			$output =get_option('mobile_template_directory');
			break;
		case 'root_template_directory':
			$output =get_option('root_template_directory');
			break;
		case 'name':
		default:
			$output = 'ff';
			break;
	}
	return $output;
 }
function get_bloginfo( $show = '') {

	switch( $show ) {
		case 'home' : // DEPRECATED
		case 'sitetitle' : // DEPRECATED
			$output = get_option("sitetitle");
			break;
		case 'moduletitle' : // DEPRECATED
			$output = get_option("moduletitle");
			break;
		case 'dashboardurl' : // DEPRECATED
			$output = get_option('siteuserurl');
			break;
		case 'routeurl' : // DEPRECATED
			$output = get_option('routeurl');
			break;
		case 'siteurl' : // DEPRECATED
			$output = get_option("siteurl");
			break;
		case 'url' :
			$output = get_option("siteurl");
			break;
		case 'smurl' :
			$output = get_option("siteurl");
			break;
		case 'siteurl_path' :
			$output = get_option("siteurl_path");
			break;
		case 'siteadminurl' :
			$output = get_option("siteadminurl");
			break;
		case 'description':
			$output = get_option('blogdescription');
			break;
		case 'stylesheet_url':
			$output = get_templateinfo('stylesheet_url');
			break;
		case 'stylesheet_directory':
			$output = get_templateinfo('stylesheet_url');
			break;
		case 'template_directory':
			$output = get_templateinfo('template_directory');
			break;
		case 'mobile_template_directory':
			$output = get_templateinfo('mobile_template_directory');
			break;
		case 'root_template_directory':
			$output = get_templateinfo('root_template_directory');
			break;
		case 'plugin_url':
			$output = get_option('plugin_url');
			break;
		case 'admin_email':
			$output = get_option('admin_email');
			break;
		case 'charset':
			$output = get_option('blog_charset');
			if ('' == $output) $output = 'UTF-8';
			break;
		case 'html_type' :
			$output = get_option('html_type');
			break;
		case 'version':
			global $wp_version;
			$output = $wp_version;
			break;
		case 'language':
			$output = get_option('language');
			$output = str_replace('_', '-', $output);
			break;
		case 'text_direction':
			//_deprecated_argument( __FUNCTION__, '2.2', sprintf( __('The <code>%s</code> option is deprecated for the family of <code>bloginfo()</code> functions.' ), $show ) . ' ' . sprintf( __( 'Use the <code>%s</code> function instead.' ), 'is_rtl()'  ) );
			if ( function_exists( 'is_rtl' ) ) {
				$output = is_rtl() ? 'rtl' : 'ltr';
			} else {
				$output = 'ltr';
			}
			break;
		case 'name':
		default:
			$output = get_option('blogname');
			break;
	}

	$url = true;
	if (strpos($show, 'url') === false &&
		strpos($show, 'directory') === false &&
		strpos($show, 'home') === false)
		$url = false;

	

	return $output;
}

$alerts=array();
function alert($val)
{
	global $alerts;
	$alerts[]=$val;
}

function get_alert()
{
	global $alerts;
	foreach($alerts as $alert)
	{
		echo "<script>pushalert('".$alert."');</script>";
	}
}
function get_userid($val,$in)//get postid by using custid
{
	global $smdb;
	if($in=='postid')
	{
		$in='val';
		$ret='key';
	}
	else
	{
		
		$in='key';
		$ret='val';
	}
	$result=$smdb->get_results("select * from _taxonomy where `".$in."`='".$val."' and typ like 'craftregno_%'");  
	foreach($result as $row)
	{
		return $row->$ret;
	}
}



function dot_string($string)
{
	$data="";
	for($i=1;$i<=strlen($string);$i++)
		$data.='*';

	return substr($data,0,11);
}

function isimage($path)
{
	if(empty($path))
		return '/sm-content/uploads/media/pic.jpg';
	else
	{
		if(pathcheck(ABSPATH.trim($path,'/'))!='no')
			return $path;
		else
			return '/sm-content/uploads/media/pic.jpg';
	}
}
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
		return;
        //die('CURL is not installed!');
    }
	
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
function formtag($action="")
{
	echo '<form action="'.$action.'" method="post" enctype="multipart/form-data">';
}


function slugmaker($sarray)
{
	$l=implode('-', $sarray);
	$rt=str_replace(" ","-",$l);
	$rt=str_replace("/","",$rt);
	return strtolower($rt);
}
$jscript="";
function script($v=null){
	GLOBAL $jscript;
	if(!empty($v))
		$jscript.=$v;
	else
		return $jscript;
}

function locator($url){
	ob_start();
	header("location:".$url);
	ob_flush();
	exit();
	
}


function usercheckin($email,$mobile=null){
	GLOBAL $smdb;
	$sql="select *from login_accounts a left outer join _posts_det b on a.shankam_id=b.postid where login_id in ('".$email."','".$mobile."') or (`key` in ('email','mobile') and `val` in ('".$email."','".$mobile."'))";
	$c=$smdb->get_results($sql);
	if(count($c)>0)
		return "exists";
	else
		return "new";
}
function redirecturl($t){
	$current_url = "http://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}";
    
	if($t=="register"){
		return get_bloginfo("siteurl").'/register?redirect='.$current_url;
	}
	else{
		return get_bloginfo("siteurl").'/login?redirect='.$current_url;
	}
}

function objclass($k){
	
	$inr=array("approved"=>"primary","pending"=>"warning","active"=>"success","Assigned to Executive"=>"danger","close"=>"success","updated"=>"warning","publish"=>"success","reject"=>"danger","delete"=>"danger","all"=>"primary","suspend"=>"warning");
	return $inr[$k];
}
function ebase($v){
	return base64_encode($v);
}
function dbase($v){
	return base64_decode($v); 
}
function update_post_stat($title,$stat,$id,$ask="no"){
 
    static $i = 1;
	if($i==1){
	  echo '<script> 
				function prompt_status(v){
					var a = prompt("Reason for rejecting"); 
					document.getElementById(v).value=a;
				}
			</script>';
	}
	$i++;
	$d='';
	
	if($ask!= "no")
		$d='prompt_status(\'reason'.$i.'\');';
	echo '<form action="" method="post" onsubmit=" '.$d.' return confirm(\'Confirm to continue\'); ">
	       <input type="hidden" name="reason" id="reason'.$i.'" value=""/>
			<button type="submit" name="status_mok" class="label label-'.objclass($stat).'" value="'.ebase($stat).'">'.$title.'</button>
			<input type="hidden" name="id" value="'.ebase($id).'"/>
		</form>';
}
function get_id($by,$v){
	GLOBAL $smdb;
	if($by=="special_id")
		$result=$smdb->get_results("select * from _posts where special_id='".$v."'");
	else
		$result=$smdb->get_results("select * from _posts where special_id='".$v."'");
	return $result[0]->id;
}
function snicon($n){
	return $n;
	if(strtolower($n)=="no")
		return '<i class="fa fa-close danger"></i>';
	else
		return '<i class="fa fa-check-square-o success"></i>';
}

function delete_file($path){
	unlink(ABSPATH.$path);
}

function add_shortcode($tag, $func) {
global $shortcode_tags;

if ( is_callable($func) )
$shortcode_tags[$tag] = $func;
}

function mok($k){
	$inr=array("approve"=>"approved","reject"=>"Rejected","active"=>"Activated","publish"=>"Activated","all"=>"approved","pending"=>"pending","suspend"=>"suspended");
	return $inr[$k];
}

function mycounter(){ 
	GLOBAL $smdb;
	$sql="(select count(*) from posts where post_type='folder' and post_status='active') as active_files";
	$sql.=",(select count(*) from posts where post_type='folder' and post_status='reject') as reject_files";
	$sql.=",(select count(*) from posts where post_type='folder' and post_status='pending') as pending_files";
	
	$result=$smdb->get_results("select ".$sql);
	return $result;
}
/*
function getserverstatus($srvr,$prt){
	$status = array("online","offline");
	$fp = @fsockopen($srvr, $prt);
	if(!$fp) return $status[1];  
	else return $status[0];
}*/