<?php
	function third($stat){
		global $smdb;	
		
		//$result = $smdb->get_results("select * from login_accounts where `login_type`='admin_two' and `pl_status`='".$stat."' ");
		$result = $smdb->get_results("select * from login_accounts where `login_type`='admin_two' and `pl_status` in ('active','suspend') ");
				
?>
	
<section class="col-sm-8  connectedSortable ui-sortable">                          
	<section  id="form-control">
		<div class="nav-tabs-custom">
			<div class="tab-content box" style="">
				<h4 class="page-header">
					<?php 
						if($stat == "active") echo "Active";
						else if($stat == "suspend") echo "Suspended"; 
					?> 
					Third Party Page
				</h4>							
				<table class="table table-hover " width="100%">
					<th>id</th>
					<th>user Id</th>
					<th>Password</th>
					<th>Current Status</th>
					<th>Change Status</th>        
				<?php		
				foreach($result as $post){	
				?>
				<tr>
					<td>#<?php echo $post->id; ?></td>
					<td colspan="">
						<!--<a href="<?php //echo get_bloginfo("siteurl").'/'.SUPPORT.'/?page='.PLUGPAGE.'&'.$parent.'='.$post->uid;?>">-->
						<a href="#">
							<?php echo $post->login_id; ?>
						</a><br/>
						
					</td>
					<td>
						<?php echo (":) sorry not be displayed")/*echo $post->login_password;*/ ?>
					</td>
					<td>
						<span class="label label-<?php echo objclass($post->pl_status); ?>"><?php echo mok($post->pl_status); ?>
					</td>
						<?php $ab = $post->pl_status;
							if($ab =="suspend") $statto=array("Approve","active");
							if($ab =="active") $statto=array("Suspend","suspend");
						?>	
					<td>
						<?php 
							t_update_post_status($statto[0],$statto[1],$post->id); 
						?>
					</td>
					<?php
					/*	if($stat=="suspend"){
							echo '<td>';
								t_update_post_status("Delete",'delete',$post->id,"no");
							echo '</td>';
						} */
					?>
				</tr>
				<?php
				}
				?>
				</table>
			</div>
		</div>
	</section>
</section>

<?php
	/* if(isset($_GET[$parent])&&!empty($_GET[$parent])){
		t_user_view($_GET[$parent]);
	} */	
}
?>
 