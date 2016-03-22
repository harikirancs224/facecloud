<?php
ob_start();
define('SUPPORT',SLUG);
get_header();
?>
<div class="wrapper row-offcanvas row-offcanvas-left">
<?php get_sidebar("menu"); ?>
<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
					<?php 
					
						if(isset($_GET['page']))
						{
							define('PLUGPAGE',$_GET['page']);
							admin_hook($_GET['page'], $amenu[$_GET['page']]);
						}
						else
							get_pag("home");			
					?>
					</div>
				</section>
			</aside>
</div>
<?php
get_footer();
?>