<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Support | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php bloginfo('template_directory'); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php bloginfo('template_directory'); ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php bloginfo('template_directory'); ?>/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php bloginfo('template_directory'); ?>/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="<?php bloginfo('template_directory'); ?>/css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php bloginfo('template_directory'); ?>/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php bloginfo('template_directory'); ?>/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php bloginfo('template_directory'); ?>/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
		
		<script>function bloginfo(val) { 
		return '<?php bloginfo('siteurl'); ?>';
	}
	function qries(){
		return '<?php echo getqueryadvance("featurelist"); ?>';
	}
	</script>
    </head>
	<?php
		
		$client=get_post(SMEMPLOYEE);
	
	?>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <!--<a href="index.html" class="logo">
                - <?php echo SMTITLE; ?>
            </a>-->
			<!-- Add the class icon to your logo image or logo icon to add the margining -->
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <!--<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>-->
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
						<?php 
							$alerts=get_posts(array("parent"=>SMEMPLOYEE, "type"=>"alert","orderby"=>"id","order"=>"desc")); 
							$unread=get_posts(array("parent"=>SMEMPLOYEE, "type"=>"alert","orderby"=>"id","order"=>"desc","where"=>"post_status='pending'")); 
							
						?>
                        <?php /*<li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success"><?php echo count($unread); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have <?php echo count($unread); ?> messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        
										<?php
										foreach($alerts as $alert)
										{
										?>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="img/avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                   <?php echo $alert->post_title; ?>
												   
                                                    <small><i class="fa fa-clock-o"></i> <?php echo $alert->post_date; ?></small>
                                                </h4>
                                                <p><?php echo $alert->post_content; ?></p>
                                            </a>
                                        </li>
										<?php
										}
										?>
                                        
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li> */ ?>
                       
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span> <?php //echo $client->fullname; ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php bloginfo('template_directory'); ?>/img/avatar3.png" class="" alt="User Image" />
                                    <p>
                                        <?php bloginfo("sitetitle"); ?> - <?php echo SMMODULE; ?>
                                        <small><?php echo date("m/d/Y"); ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                            <!--    <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Facebook</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Twitter</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Shankam</a>
                                    </div>
                                </li>  
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <!--<div class="pull-left">
                                        <a href="<?php echo get_bloginfo("siteurl").'/'.SUPPORT; ?>?page=profile" class="btn btn-default btn-flat">Profile</a>
                                    </div>-->
                                    <div class="pull-right">
                                        <a href="<?php echo get_bloginfo("siteurl").'/'.SUPPORT; ?>?logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>