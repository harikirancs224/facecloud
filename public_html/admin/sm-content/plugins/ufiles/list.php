<?php
function file_posts($stat,$parent){
	
	if($stat == "all") 
		$posts=my_get_posts(array("parent"=>"all","type"=>"folder","orderby"=>"id","order"=>"desc","where"=>"post_status in ('active','reject','pending')" ,"LIMIT"=>"-1"));
	else
		$posts=my_get_posts(array("parent"=>"all","type"=>"folder","orderby"=>"id","order"=>"desc","where"=>"post_status='".$stat."'","LIMIT"=>"-1"));

	if($stat=="pending") $statto=array("Approve","active"); 
	if($stat=="reject") $statto=array("Approve","active");
	if($stat=="active") $statto=array("Reject","reject");
	if($stat=="expire") $statto=array("Approve","active");
	//if($stat=="all") $statto=array("Approve"=>"active","Reject"=>"reject");

	if($stat=="reject"){
	?>
	<div class="col-sm-9">
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

<section class="connectedSortable ui-sortable">                          
	<section  id="form-control">
		<div class="nav-tabs-custom">
			<div class="tab-content box" style="">
				<h4 class="page-header">
					<?php 
						if($stat == "active") echo "Active";
						else if($stat == "reject") echo "Rejected";
						else if($stat == "pending") echo "Pending";
						else if($stat == "all") echo "All";
					?> 
					Files
				</h4>							
				<table class="table table-hover " width="100%">
				<?php if(!empty($posts)){?>
				<tr>	<th>id</th>
					<th>Name</th>
					<th>Current Status</th>
				<th>Change Status</th></tr><?php
				}
					
					foreach($posts as $post){	
					?>
					<tr>
						<td>#<?php echo $post->id; ?></td>
						<td colspan="">
							<!--<a href="<?php //echo get_bloginfo("siteurl").'/'.SUPPORT.'/?page='.PLUGPAGE.'&'.$parent.'='.$post->id;?>"><?php //echo $post->post_title; ?></a><br/>-->
							<a target="_blank" href="http://facecloud.us/download/Auth?q=&qid=<?php echo ebase($post->post_content); ?>"><?php echo $post->post_title; ?></a><br/>
							<?php echo $post->post_date; ?>
						</td>
						<td>
							<span class="label label-<?php echo objclass($post->post_status); ?>"  >
							<?php echo mok($post->post_status); ?></span>
						</td>
						<td>
							<?php 
							update_post_stat($statto[0],$statto[1],$post->id);
							if($stat=="pending")
								update_post_stat("Reject",'reject',$post->id);
							?>
						</td>
						
						<?php
							if($stat=="reject"){
								echo '<td>';
								update_post_stat("Delete",'delete',$post->id,"no");
								echo '</td>';
							}
						?>
						<?php
							
							if($stat=="all"){ 
								$a = mok($post->post_status);
								
								if($a == "Activated"){
									echo '<td>';
										update_post_stat("Reject",'reject',$post->id,"no");
									echo '</td>';
								}
								else if($a == "Rejected"){
									echo '<td>';
										update_post_stat("Active",'active',$post->id,"no");
									echo '</td>';
								}
								else if($a == "pending"){
									echo '<td>';
										update_post_stat("Active",'active',$post->id,"no");
										update_post_stat("Reject",'reject',$post->id,"no");
									echo '</td>';
								}								
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
<?php  } ?>
 