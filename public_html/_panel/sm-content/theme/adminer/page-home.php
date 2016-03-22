<?php 
	$counter=mycounter();
	$counter=$counter[0];
	//print_r($counter);

		global $smdb;
		$sql = "select * from `session_history` a inner join customers_auth b on a.uid=b.uid order by `lasttime` desc";
		$track = $smdb->get_results($sql);	
		//print_r($track);
?>
<section class="col-md-4">
	<div class="row">
		<div class="col-lg-6 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>
						<?php echo $counter->active_files; ?>
					</h3>
					<p>
						Active Files
					</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<a href="<?php echo get_bloginfo("siteurl").'/'.SUPPORT.'/?page=admin_users&_aprvd_files'; ?>"
					class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<div class="col-lg-6 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>
						<?php echo $counter->pending_files; ?>
					</h3>
					<p>
					   Pending Files
					</p>
				</div>
			   
				<a href="<?php echo get_bloginfo("siteurl").'/'.SUPPORT.'/?page=admin_users&_pending_files'; ?>" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<div class="col-lg-6 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>
						<sup style="font-size: 20px"><?php echo $counter->reject_files; ?></sup>
					</h3>
					<p>Rejected Files</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="<?php echo get_bloginfo("siteurl").'/'.SUPPORT.'/?page=admin_users&_rejected_files'; ?>" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<div class="col-lg-6 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>
						<sup style="font-size: 20px">
							<?php echo $counter->active_files+$counter->pending_files+$counter->reject_files; ?>
						</sup>
					</h3>
					<p>
						All Posts
					</p>
				</div>
				
				<a href="<?php echo get_bloginfo("siteurl").'/'.SUPPORT.'/?page=admin_users&_all_files'; ?>" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
	</div>
</section>
<section class="col-md-5"><?php get_pending_page();	?></section>
<section class="col-md-3">
	<section class="connectedSortable ui-sortable">                          
		<section id="form-control">
			<div class="nav-tabs-custom">
				<div class="tab-content box" style="">
					<h4 class="page-header">
						User History
					</h4>							
					<table class="table-hover table">
						<?php	
						foreach($track as $row){ ?>
							<tr>
								<td class="pull-left">
									<div class="crcl" id="ofl">
										<?php/*
											$port = 80; 
											$ab = $row->extra;
											$val = getserverstatus($ab,$port); 
											if($val == "online"){
												echo '<script>
													ofl.style.backgroundColor = "green";
												</script>';
											}
											*/
										?>
									</div>
									<?php echo $row->extra; ?>
								</td>
								<td class="pull-right">
									<div class="fsze"><?php echo $row->name; ?></div>
									<small> <?php echo $row->lasttime; ?></small>
								</td>    
							</tr>
					<?php	}	?>
					</table>
				</div>
			</div>
		</section>
	</section>
</section>

<style>
	.fsze{
		font-size:18px;
		color:#3c8dbc;
		margin:0;
		padding:0;
	}
	.crcl{
		border-radius:50%;
		width:5px;
		height:5px;
	}
	#ofl{
		border-radius:50%;
		width:5px;
		height:5px;
	}
</style>  