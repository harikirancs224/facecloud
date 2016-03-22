<?php

$tarray=array("admin"=>"Change Password");
$tarray=array("user"=>"Change Password");

add_admin('dpassword', 'dpassword','admin','Change Password', 'cloud',array(),"fa-th",'');
add_admin('dpassword', 'dpassword','admin_two','Change Password', 'cloud',array(),"fa-th",'');


function dpassword(){
	$d=get_post(get_loginid());
	$r='login_password';
	//$d->$r=$r;
?>
<section class="col-sm-5 connectedSortable ui-sortable">                          
 <section id="form-control ">
	<div class="nav-tabs-custom box">
		<div class="tab-content" style="">
			<h4 class="page-header">Change Password</h4>							
			<?php include("change_password.php"); ?>
		</div>
	</div></section>
</section>
	<div class="view_form">	</div>
<?php } ?>
