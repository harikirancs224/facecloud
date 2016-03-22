<?php
function the_ID() {
	echo get_the_ID();
}
function get_the_ID() {
	return get_post()->ID;
}
function the_title($before = '', $after = '', $echo = true) {
	$title = get_the_title();

	if ( strlen($title) == 0 )
		return;

	$title = $before . $title . $after;

	if ( $echo )
		echo $title;
	else
		return $title;
}
function sm_title()
{
	global $pagetitle;
	if(!empty($pagetitle))
		echo $pagetitle; 
	else
		permalink_info('post_title');
	echo ' | '.get_bloginfo("sitetitle");
}
function put_title($val)
{
	global $pagetitle;
	$pagetitle=$val;
}

function notfound()
{
	echo '<center><img src="'.get_bloginfo('root_template_directory').'/images/norecordsfound.jpg"/></center>';
}

function get_the_permalink($val=null)
{
	global $post,$smdb,$parentslug;
	if(empty($val))
	{
		if(isset($post->id))
			$id=$post->id;
		else
			$id=get_data("pageid");
	}
	else
		$id=$val;
		
		$parentslug="";
	$result=$smdb->get_results("select *from _permalinks a inner join _posts b on a.pageid=b.id where pageid='".$id."' and b.post_under in ('".SMMAIN."','".SMMODULE."')");		
	foreach($result as $row)
	{
		$loc=get_cookie("location");
		if(empty($loc)) $loc=DEFAULT_LOCATION;
		
		$loc="slb-".$loc;
		if($row->post_type=='category')
		{
			$pslug=get_parent_slug($row->slug);
			return get_bloginfo('siteurl').'/'.$loc.'/'.$pslug.$row->slug;
		}
		else
		{
			return get_bloginfo('siteurl').'/'.$loc.'/'.$row->slug;
		}
	}
}


function get_slug($pageid)
{
	global $smdb;
	$result=$smdb->get_results("select *from _permalinks where pageid='".$pageid."'");
	foreach($result as $row)
	{
		return $row->slug;
	}
}

function the_permalink()
{
	global $post,$posts,$smdb;
	
	//print_r($post);
	//echo "select *from _permalinks where pageid='".$post->id."'";
	$result=$smdb->get_results("select *from _permalinks where pageid='".$post->id."'");
	if(empty($result))
		return false;
		
	foreach($result as $row)
	{
		echo bloginfo('siteurl').'/'.$row->slug;
	}
}

function get_posts($val)
{
	global $smdb,$paginat;
	
	$html="";
	$query="";
	$sub="";
	if($val["parent"]!="all")
		 $query.="and parent='".$val["parent"]."'";
	 
	 if(isset($val["author"])&&$val["author"]!="all")
		 $query.="and post_author='".$val["author"]."'";
	
	if((isset($val["where"]))&&(!empty($val["where"])))
		 $query.="and ".$val["where"];
	 
	 if((isset($val["sub"]))&&(!empty($val["sub"])))
		 $sub.=",(".$val["sub"].") as sub";
	
	//$l="and a.id in (select postid from _posts_det where  `key` in ('city','district','state','country','location') and val like '%".LOCATION."%')";
	$sql="select a.*,b.slug".$sub." from _posts a left outer join _permalinks b on a.id=b.pageid where post_type='".$val["type"]."' and a.post_under in ('".SMMODULE."','".SMMAIN."') ".$query." order by ".$val["orderby"]." ".$val["order"];
	
	if(isset($val["LIMIT"]))
		$display=157878787;
	else
		$display=LIMIT;
	
	$query=$sql;
	
	$pagd=pagination($sql,$display);
	extract($pagd);
	$paginat->setinfo("li",$pagination);
	$result=$smdb->get_results($sql);
	//echo $sql;
	//$result=$smdb->get_results($sql);
	//echo "select *from _posts where post_type='".$val["type"]."' ".$query." order by ".$val["orderby"]." ".$val["order"];
	return $result;
}

function get_post($postid)
{
	global $smdb;
	$result=$smdb->get_results("select a.*,b.slug,b.template from _posts a left outer join _permalinks b on a.id=b.pageid where a.id='".$postid."'");
	foreach($result as $row)
	{
		$r=the_det($postid);
		if(!empty($r))
			foreach($r as $k=>$v)
				$row->$k=$v;
			
		return $row;
	}
	return $result;
}


function slug_type($val)
{
	global $smdb;
	$result=$smdb->get_results("select *from _permalinks where slug='".$val."'");
	if(empty($result))
		return false;
	foreach($result as $row)
		return $row->page_typ;
}

class _slug
{
	public $navigator;
    public $slug = 'My Website'; 

    public function __construct() 
    { 
		global $slugarray;$data="";
		foreach($slugarray as $dslug)
			$data.=' &gt;&gt; <a href="'.sluglink($dslug).'">'.$dslug.'</a>';
			
		$this->navigator=$data;
	
        //$this->navigator = (object) array('current' =>$current, 'credit' => $credit, 'debit' => $debit); 
    } 
}
function sluglink($slug)
{
	global $smdb;
	$result = $smdb->get_results("SELECT * FROM _permalinks WHERE slug='".$slug."' LIMIT 1");
	foreach( $result as $row )
	{
		return get_the_permalink($row->pageid);
	}
}

function delete_profile($val)
{
	global $smdb;
	//echo "hai";
	$smdb->query("delete from _posts where id='".$val."'");   
	//delete_profilefiles($val);
	
	$smdb->query("delete from _posts_det where postid='".$val."'");
	$smdb->query("delete from _permalinks where pageid='".$val."'");
	$smdb->query("delete from _posts where id='".$val."'"); 
}



function sm_meta()
{
	GLOBAL $smdb;$bunch="";$bunch1="";$sitemetatitle="";
	global $smdb;$output="";$val="post_title";
	$result=$smdb->get_results("select *from _posts a inner join _permalinks b on a.id=b.pageid where slug='".SLUG."' and a.post_under in ('".SMMODULE."','".SMMAIN."')");
	if(!empty($result))
	{
		foreach($result as $row){
			$bunch=$row;
			$output=$row->$val;
		}
	}
	/* else
	{ */
		$result=$smdb->get_results("select *from _posts where post_type='module' and post_under='".SMMODULE."'");
		foreach($result as $row)
		{
			$output=$row->post_title; 
			$bunch1=$row;
		}
			
		
	/* } */
	$loc=get_cookie("location");
	//if(empty($bunch->post_title)) $bunch->post_title=SMMODULE;
	//$smdb->get_results("select *from ");
	if(!empty($bunch->post_title)) $sitemetatitle.= $bunch->post_title;
	
	if(defined("TEMPLATE")&&(TEMPLATE=='category')){ if(!empty($loc)) $sitemetatitle.=' in '.$loc; }
	if(defined("TEMPLATE")&&(TEMPLATE=='search')){ if(!empty($loc)) $sitemetatitle.=' Search Results '.get_qstring("q").' in '.$loc; }
	
	$sitemetadescription=array();$sitemetakeywords=array();
	if(isset($bunch1->post_title))
		$sitemetatitle.= '  '.$bunch1->post_title;
	
	if(isset($bunch->post_content))
		$sitemetadescription[]=$bunch->post_content;
	if(isset($bunch1->post_content))
		$sitemetadescription[]=$bunch1->post_content;
	
	if(isset($bunch->post_expert))
		$sitemetakeywords[]=$bunch->post_expert;
	
	if(isset($bunch1->post_expert))
		$sitemetakeywords[]=$bunch1->post_expert;
	
	$loc=get_cookie("location");
	if(empty($loc)) $loc="India";
	$metatitle=$sitemetatitle;
	$metadescription=implode(' | ',$sitemetadescription);
	$metakeywords=implode(' | ',$sitemetakeywords);
	if(slug_type(SLUG)=="category")
	{
		$title=get_data("post_title");
		$metatitle=$title." in ".$loc.", India | ";
		$metadescription=$title." in ".$loc." Phone Numbers, Addresses, Best Deals in ".$title.", India | ";;
		$metakeywords=$title." in ".$loc.", ".$loc." ".$title.", India | ";
	}
	
	
	echo '
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta charset="'.get_bloginfo( 'charset' ).'">
	<title>'.$metatitle.'</title>
	
	<meta name="Title" content="'.$metatitle.'" />
	<meta name="description" content="'.$metadescription.'"/>
	<meta name="keywords" content="'.$sitemetakeywords.'" />
	
	<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no" />

	
		';
}


function get_title($c)
{
	global $smdb;
	$sql="select * from _posts where id='".$c."' order by id desc";
	$result=$smdb->get_results($sql);
	if(isset($result[0]->post_title))
		return $result[0]->post_title;
	else
		return "N/A";
}


$theme_header_scripts="";
function theme_header_scripts($d=null)
{
	GLOBAL $theme_header_scripts;
	if(empty($d))
		return $theme_header_scripts;
	
	$theme_header_scripts.=$d;
	
	
}
$theme_footer_scripts="";
function theme_footer_scripts($d=null)
{
	GLOBAL $theme_footer_scripts;
	if(empty($d))
		return $theme_footer_scripts;
	
	$theme_footer_scripts.=$d;
	
	
}

function reasons($v){
	GLOBAL $smdb;
	$re=$smdb->get_results("select *from _taxonomy where `key`='".$v."' and typ='status_change' order by id desc");
	return $re;
}


function my_get_post($postid)
{
	global $smdb;
	$result=$smdb->get_results("select a.*,b.slug,b.template from posts a left outer join _permalinks b on a.id=b.pageid where a.id='".$postid."'");
	foreach($result as $row)
	{
		$r=the_det($postid);
		if(!empty($r))
			foreach($r as $k=>$v)
				$row->$k=$v;
			
		return $row;
	}
	return $result;
}

function my_get_posts($val)
{
	global $smdb,$paginat;
	
	$html="";
	$query="";
	$sub="";
	
	if($val["parent"]!="all")
		 $query.="and parent='".$val["parent"]."'";
	 
	 if(isset($val["author"])&&$val["author"]!="all")
		 $query.="and post_author='".$val["author"]."' and a.post_status='".$val[post_status]."'";
	
	if((isset($val["where"]))&&(!empty($val["where"])))
		 $query.="and ".$val["where"];
	 
	 if((isset($val["sub"]))&&(!empty($val["sub"])))
		 $sub.=",(".$val["sub"].") as sub";
	
	
	$sql="select a.*,b.slug".$sub." from posts a left outer join _permalinks b on a.id=b.pageid where a.post_type='".$val["type"]."' and a.post_under='smb' ".$query." order by ".$val["orderby"]." ".$val["order"];
	
	if(isset($val["LIMIT"]))
		$display=157878787;
	else
		$display=LIMIT;
	
	$query=$sql;
	
	$pagd=pagination($sql,$display);
	extract($pagd);
	$paginat->setinfo("li",$pagination);
	$result=$smdb->get_results($sql);
	
	return $result;
}