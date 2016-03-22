<?php
function user_view($postid){
global $smdb;
$e = $smdb->get_results("select * from customers_auth where uid='".$postid."'");
$post=$e[0];


?>
<section class="col-sm-6 connectedSortable ui-sortable">                          
 <section  id="form-control">
<div class="nav-tabs-custom">
		<div class="tab-content box" style="">
			<h4 class="page-header">User Profile</h4>

	<table class="table ">

	<tr><td>Full Name</td><td>  <?php echo $post->name; ?></td></tr>
	
		<tr><td>Email Id</td><td>  <?php echo $post->email; ?></td></tr>
		<tr><td>Mobile Number</td><td>  <?php echo $post->phone; ?></td></tr>
		<tr><td>Password</td><td>  <?php echo "*******************"; //echo $post->password; ?></td></tr>
		<tr><td>Address</td><td>  <?php echo $post->address; ?></td></tr>
	 
	 
	 
	  </table>

	 </div>
	 </div>
			   
</section>
</section>
<?php
}