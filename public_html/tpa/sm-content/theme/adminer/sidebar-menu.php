<?php
	
	global $amenu;$tmenu="";
	$client=get_post(SMEMPLOYEE,'postid');
	
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
			<a href="<?php echo get_bloginfo('siteurl'); ?>">
				<img src="<?php bloginfo('template_directory'); ?>/img/avatar3.png" class="" alt="User Image" />
				</a>
			</div>
			<div class="pull-left info">
				

				<!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
			</div>
		</div>
		
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="active">
				<a href="<?php echo get_bloginfo('siteurl').'/'.SUPPORT; ?>">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<?php
			 
			foreach($amenu as $menu=>$val)
			{	
				if(!isset($val["class"]))
					$val["class"]="fa-chevron-circle-right";
				$active="";
				if(isset($_GET["page"])&&($val["key"]==$_GET["page"]))
					$active="active";
					
				if(empty($val["sub"]))
				{
					echo '<li class="'.$active.'">
					<a href="?page='.$val["key"].'">
							<i class="fa  '.$val["class"].'"></i>
							<span>'.$val["name"].'</span>
							'.$val["alert"].'
							<i class="fa">
							</i>
						</a>
						</li>
					';
				}
				else
				{
					echo '<li class="treeview '.$active.'">';
				?>
					<a href="#">
						<i class="fa <?php echo $val["class"]; ?>"></i>
						<span><?php echo $val["name"]; ?></span>
						<?php 
							if(isset($val["alert"][$val["name"]]))
							{
								echo '<small class="badge pull-right bg-yellow">'.$val["alert"][$val["name"]].'</small>';
							}
						?>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<?php
					if(!empty($val["sub"]))
					{
					
						echo '<ul class="treeview-menu">';
						foreach($val["sub"] as $smenu=>$sval)
						{	
							echo '<li><a href="?page='.$val["key"].'&'.$smenu.'"><i class="fa fa-angle-double-right"></i> '.$sval;
							
							if(isset($val["alert"][$smenu]))
							{
								echo '<small class="badge pull-right bg-yellow">'.$val["alert"][$smenu].'</small>';
							}
							echo '</a></li>';
						}
						echo '</ul>';
					}
					?>
				</li>
				<?php
				}
			}
			?>
			
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>
