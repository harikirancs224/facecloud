<?php
global $smdb;
$me="";$msg="";
if(isset($_POST['change']))
{
	if(SMRIGHTS != 'admin'){ 
		$result=$smdb->get_results("select * from login_accounts where shankam_id='".get_loginid()."' and login_password='".secure($_POST['currentpwd'])."'");
		 /* echo "am not admin";  */
	}
	else{
		$result=$smdb->get_results("select * from login_accounts where login_id='admin' and login_type='admin' and shankam_id='".get_userdata("smadmin")."' and login_password='".secure($_POST['currentpwd'])."'");
		/*  echo "am admin";  */
	}
	if(!empty($result))
	{
		$row=$result[0];
		$me=get_post($row->shankam_id);
		
		$smdb->query("update login_accounts set `login_password`='".secure($_POST['pswrd'])."' where `shankam_id`='".$row->shankam_id."'");
		
		if(isset($me->email)) $mailid=$me->email; else $mailid=ADMINEMAIL;
		
		$attr=array("mailid"=>$mailid,"subject"=>"Password change alert","msg"=>"Hi <br/> Some one change Your Account Password in Way Granites (password is:<b>".$_POST['pswrd']."</b> for login id '".$row->login_id."')","fromname"=>"Way Granites");
		//pushmail($mailid,$attr);
		$msg="Your password has been Changed";
		alert($msg);
		
	}
	else
	{
		$msg='Current Password Not Matched';
	}
	
}	
else{
	
}
?>
		<div class="change-pwd ">
			<?php echo '<font color="red">'.$msg.'</font>'; ?>
			<form action="" method="post">
				<table align="" class="" style="width:100%;">
					<tr>
						<td class="hdngpswrds">Current Password</td>
						<td><input required="required" class="iptxt" type="password" name="currentpwd" placeholder="Enter current password" value=""/></td>
					</tr>
					<tr>
						<td class="hdngpswrds">New Password</td>
						<td><input required="required" class="iptxt" placeholder="Enter new password" type="password" name="pswrd" id="password" value=""/></td>
					</tr>
					<tr>
						<td class="hdngpswrds">Confirm Password</td>
						<td class=""><input required="required" placeholder="Confirm password" class="iptxt" type="password" name="cnewpwd" value="" ajax="match"/></td>
					</tr>
					
				</table>
				<div class="">
				
					<center><button name="change" type="submit" name="next"  style="width:80px;" class="signup-button">Change</center></button>
				</div>	
			</form>
		</div>
<style>
.signup-button {
width: 100%;
background: #ad0908;
border-bottom: 3px solid #8f0101;
font-weight: bold;
color: white;
border-radius:4px;
border-top: 0;
border-right: 0;
border-left: 0;
border-radius: 1px;
cursor: pointer;
padding: 7px 10px;
margin:10px;
}
.hdngpswrds{
font-size:14px;
}
.iptxt{
margin:10px !important;
width:100%;
}
</style>