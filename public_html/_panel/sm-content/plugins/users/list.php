<?php

function cloud_users($stat,$parent){
global $smdb;	
 $result = $smdb->get_results("select * from customers_auth where status='".$stat."'");

if($stat=="pending") $statto=array("Approve","publish");
if($stat=="reject") $statto=array("Approve","publish");
if($stat=="publish") $statto=array("Reject","reject");
if($stat=="expire") $statto=array("Approve","publish");
if($stat=="reject"){
	?>
<div class="col-sm-12">
<div class="alert alert-danger alert-dismissable">
	<i class="fa fa-danger"></i>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<b> Warning!</b> &nbsp; Make sure while deleting users because all the posts related to the user will be deleted.  
	<b class="pull-right"> You can't undo once deleted!</b>
</div>
</div>
<?php
}
?>

<section class="col-sm-6  connectedSortable ui-sortable">                          
	<section  id="form-control">
		<div class="nav-tabs-custom">
			<div class="tab-content box" style="">
				<h4 class="page-header">
					<?php 
						if($stat == "publish") echo "Active";
						else if($stat == "reject") echo "Rejected";
						else if($stat == "pending") echo "Pending";
					?> 
					Users
				</h4>							
				<table class="table table-hover " width="100%">
					<th>id</th>
					<th>Name</th>
					<th>Current Status</th>
					<th>Change Status</th>
				<?php		
				foreach($result as $post){
					
				?>
				<tr>
					<td>#<?php echo $post->uid; ?></td>
					<td colspan="">
						<a href="<?php echo get_bloginfo("siteurl").'/'.SUPPORT.'/?page='.PLUGPAGE.'&'.$parent.'='.$post->uid;?>"><?php echo $post->name; ?></a><br/>
					
						<?php echo do_shortcode("[WPTRAFFIC]"); ?>
						<?php echo $post->created; ?>
					</td>
					<td>
						<span class="label label-<?php echo objclass($post->status); ?>"><?php echo mok($post->status); ?>
					</td>
					<td>
						<?php 
						update_post_status($statto[0],$statto[1],$post->uid);
						if($stat=="pending")
							update_post_status("Reject",'reject',$post->uid);
						?>
					</td>
					<?php
						if($stat=="reject"){
							echo '<td>';
							update_post_status("Delete",'delete',$post->uid,"no");
							echo '</td>';
						}
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
	if(isset($_GET[$parent])&&!empty($_GET[$parent])){
		user_view($_GET[$parent]);
	}	
	
}
?>
 