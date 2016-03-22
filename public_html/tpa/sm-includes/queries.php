<?php
insert_post();

function dirttArray($c,$dir,$pnonde=null) {
	global $smdb;
    $contents = array();
    foreach (scandir($dir) as $node) {
        if ($node == '.' || $node == '..') continue;
        if (is_dir($dir . '/' . $node)) {
            dirttArray($c,$dir . '/' . $node,$pnonde.'/'.$node);
        } else {
			//echo $c.'=='.$node.'<br/>';
			if($c==$node){
				//echo "applied";
				$newnode='AC'.substr($node,2,strlen($node)-1);
				rename ($dir.'/'.$node, $dir.'/'.$newnode);
				//echo "Changed".$pnonde.'/'.$c;
				$smdb->query("update posts set post_expert='".$newnode."' where post_expert='".$node."'");
			}
        }
    }
	$pnonde="";
    return $contents;
}

function insert_post()
{
	global $smdb;
	
	if(isset($_POST['delete_post'])) delete_post($_POST['delete_post']);
	
	$l=get_loginid();
	
	if(isset($_POST["status_mok"])){
		$stat=dbase($_POST["status_mok"]);
		$ids=dbase($_POST["id"]);
		if($stat=="delete"){ 
			delete_profile($ids);
			alert("Record Deleted"); 
		}
		else{
			if($stat=="active"){
				$d=$smdb->get_results("select *from posts where id='".$ids."'");
				$m=$d[0];
				
				$path = "/home/yksabr8/public_html/api/storage/".$m->parent;
				$c=$m->post_expert;
				dirttArray($c,$path);
			}
			$smdb->query("update `posts` set  `post_status`='".$stat."' where `id`='".$ids."'");
			$reason="modified";if(!empty($_POST['reason'])) $reason=$_POST['reason'];
			$sql = "insert into `_taxonomy`(`key`,`val`,`other`,`typ`,`dt`) values('".$ids."','".$reason."','".$stat."','status_change',curdate())";
			$smdb->query($sql);
		}
	}  
	
	if(isset($_POST['newpassword'])&&isset($_GET["recovery"])){
		$result=$smdb->get_results("select *,a.id as rid from `account_recover` a inner join login_accounts b on a.logid=b.login_id where token='".$_GET["recovery"]."' and fin_stat='open' and status='open'");
		if(!empty($result)){
			foreach($result as $row){
				$smdb->query("update `account_recover` set fin_stat='completed',status='completed',`effect`='".$_POST['password']."' where id='".$row->rid."'");
				
				$smdb->query("update `login_accounts` set login_password='".$_POST['password']."' where login_id='".$row->logid."'");
				
				
				$me=get_post($row->shankam_id);
				$msg="Dear ".$me->post_title.".<br/> <a href=\"".get_bloginfo('siteurl')."/login\">Your Password modification has been succesfully finished. Click here to login </a> <br/> Account details:<br/> Login ID: ".$row->login_id."<br/>";
				
				$attr=array("mailid"=>$me->email,"subject"=>"Account Recovery","msg"=>$msg,"fromname"=>"Shankam Support");
				pushmail($me->email,$attr);
			
			
				alert('Congrats! Your password has been reset.<br/><form action="" method="post"><input type="hidden" name="logname" value="'.$row->logid.'"/> <input type="hidden" name="logpswrd" value="'.$_POST['password'].'"/>Click <button type="submit" name="userlogin" value="g">Continue</button> to Dashboard</form>');
			}
		}
		else{
			alert("Security code not active, Request again");
		}
	}	
}