<?php
//include('active_posts.php');


$tarray=array( "_pending_users"=>"Pending Users" , "_active_users"=>"Active Users", "_rejected_users"=>"Rejected Users" );
add_admin('admincld_users', 'admincld_users','admin', 'Users', 'cloud' , $tarray,"fa-th",'');
add_admin('admincld_users', 'admincld_users','admin_two', 'Users', 'cloud' , $tarray,"fa-th",'');
/* add_admin('admin_users', 'admin_users','user','Files','cloud',$tarray,"fa-th",''); */
function admincld_users()
{
	global $smdb;
	
	$args = func_get_args();
	$tarraya=$args[0][0]["sub"];	
	include('list.php');
	include('view.php');
	
	foreach($tarraya as $key=>$value)
	{
		
		if(isset($_GET[$key]))
		{
			define("PLUGKEY",$key);
			if(file_exists(SM_PLUGIN_DIR.'/'.$_GET[$key].'.php'))
				include(SM_PLUGIN_DIR.'/'.$key.'.php');
			else
				include($key.'.php');
		}
	}
}

function update_post_status($title,$stat,$id,$ask="no"){

 
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
			<button type="submit" name="status_moks" class="label label-'.objclass($stat).'" value="'.ebase($stat).'">'.$title.'</button>
			<input type="hidden" name="id" value="'.ebase($id).'"/>
		</form>';
}
if(isset($_POST["status_moks"])){
    global $smdb;
		$stat=dbase($_POST["status_moks"]);
		$ids=dbase($_POST["id"]);
		if($stat=="delete"){ 
			$e = $smdb->get_results("delete from customers_auth where uid='".$ids."'");
			alert("Record Deleted"); 
		}
		else{
			$smdb->get_results("update customers_auth set  `status`='".$stat."' where `uid`='".$ids."'");
		
			
			
		}
	}  