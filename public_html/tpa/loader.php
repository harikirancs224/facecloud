<?php
if(isset($_GET['page']))
{
	define('SLUG',$_GET['page']);
	
}	
define('AJAX','loading');
require_once 'sm-load.php'; 
$smdb=new _smdb;

include( ABSPATH .'/'. SMINC. '/sm-load.php');
include( ABSPATH .'/'. SMINC . '/general-template.php' );
include_plugins();
/* session_start();
include( ABSPATH . SMINC . '/ini.php' );
include( ABSPATH . SMINC . '/class.themer.php' );
include( ABSPATH . SMINC . '/pagination.php' );

include( ABSPATH . SMINC . '/sm-plugin.php' );
include( ABSPATH . SMINC . '/permalink.php' );

include( ABSPATH .'/'. SMINC. '/post-template.php');
include( ABSPATH .'/'. SMINC. '/functions.php');
include( ABSPATH .'/'. SMINC. '/general-template.php'); */
if(isset($_GET['jsn']))
{
	search_engine("jsn");
}
else if(isset($_GET['validation'])){
	$mobile="";$email="";
	if(isset($_GET["email"])) $email=$_GET["email"];
	if(isset($_GET["mobile"])) $mobile=$_GET["mobile"];
	
	$v=usercheckin($email,$mobile);
	if($v==false)
		echo "exist";
	
	exit();
}
else if(isset($_GET['alerts']))
{
	echo '{"articleList":[{"title":"Wayit","id":"3","message":"Wayitsolutions pvt ltd started android apps"}]}';
}
else if(isset($_GET['pincode']))
{
	get_pincode_options($_GET['pincode'],$_GET[$_GET['pincode']]);
}
else if(isset($_GET['locator_listing'])){
	get_locator_options($_GET['cities'],$_GET['type']);
}
else if(isset($_GET['form_category']))
{
	/* get_element_options('','','[LOAD]:category','Category'); */
	$cc=c_options_list_array($_GET[$_GET['form_category']],0,'','clear');
	echo '<option value="">Select Subcategory</option>';
	foreach($cc as $key=>$val)
	{
		echo '<option value="'.$val.'">'.$key.'</option>';
	}
	//get_form_category($_GET['form_category'],$_GET[$_GET['form_category']]);
}
else if(isset($_GET['ajaxlist'])){
	$cc=c_options_list_array($_GET[$_GET['ajaxlist']],0,'','clear',"noparent","yes");
	echo '<option value="">Select</option>';
	foreach($cc as $key=>$val){
		echo '<option value="'.$val.'">'.$key.'</option>';
	}
}
else if(isset($_GET['action']))
{
	
	define('AJAXSLUG',$_GET['action']);
	//define('SLUG',$_GET['page']);
	//$posts=have_posts();
	
	
	get_template_part("content","listing");
}

function get_pincode_options($key,$val) 
{
	global $smdb;
	$selectd="";
	if(isset($_GET["selectd"])) $selectd=$_GET["selectd"];
	//echo "select * from _pincode where ".$key."='".$val."'";
	$array=array("country"=>"state","state"=>"district","district"=>"");
	$result=$smdb->get_results("select * from _pincode where ".$key."='".$val."' group by ".$array[$key]);
	$options='<option value="">select</option>';
	foreach($result as $row)
	{
		if($selectd==$row->$array[$key])
			$options.='<option selected value="'.$row->$array[$key].'">'.$row->$array[$key].'</option>';
		else
			$options.='<option value="'.$row->$array[$key].'">'.$row->$array[$key].'</option>';
	}
	echo $options;
}
function get_locator_options($wr,$typ)
{
	global $smdb;
	//echo "select * from _pincode where ".$key."='".$val."'";
	$sql="select * from _pincode where ".$typ."='".$wr."' and city!='#N/A' group by city";
	if($typ=="country") $sql.=" limit 0,20";
	$result=$smdb->get_results($sql);
	$options='';
	if(!empty($result)){
		foreach($result as $row)
		{
			$options.='<li><a onclick="putlocation(\''.$row->city.'\');" title="'.$row->city.'">'.$row->city.'</a></li>';
		}
	}
	echo $options;
}
function get_form_category($key,$val=42)
{
	global $smdb;$tag='td';
	$data="";
	$result1=$smdb->get_results("select *from _settings where `typ`='form_category' and `key`='".$val."'");
	foreach($result1 as $rw)
	{
		//echo "select *from _settings where `typ`='form_master_".$rw->id."'";
		$result=$smdb->get_results("select *from _settings where `typ`='form_master_".$rw->id."'");
		foreach($result as $row)
		{
			$data.='<tr><'.$tag.'><'.$tag.'>'.$row->key.'</'.$tag.'><'.$tag.'>'.get_element($row->val,$row->id).'</'.$tag.'></tr>';
		}
	}
	echo '<table width="100%">'.$data.'</table>';
}
?>