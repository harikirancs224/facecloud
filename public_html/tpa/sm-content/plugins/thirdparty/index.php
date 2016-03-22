<?php
  
	$tarray=array("thirdparty_page"=>"Third Party");
	add_admin('third_user', 'third_user','admin','Third Party Control','cloud',array(),"fa-th",'');
	//add_admin('third_user', 'third_user','user','Third Party','cloud',$tarray,"fa-th",'');
	
	function third_user()
	{
		global $smdb;
		
		$args = func_get_args();
		$tarraya=$args[0][0]["sub"];
		
		include('list.php');
		include('view.php');
		
		third("all");
		//third("suspend");
	}

	function t_update_post_status($title,$stat,$id,$ask="no"){
		static $i = 1;
		if($i==1){
		  echo '<script> 
					function prompt_status(v){
						var a = prompt("Reason for suspending"); 
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
				$e = $smdb->get_results("delete from login_accounts where id='".$ids."'");
				alert("Record Deleted"); 
			}
			else{
				$smdb->get_results("update login_accounts set  `pl_status`='".$stat."' where `id`='".$ids."'");	
			}
		} 