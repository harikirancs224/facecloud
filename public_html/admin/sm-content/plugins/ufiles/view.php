<?php
	function file_view($postid){
		$post=my_get_post($postid);
?>
<section class="col-sm-7 connectedSortable ui-sortable">                          
 <section  id="form-control">
<div class="nav-tabs-custom">
		<div class="tab-content box" style="">
			<h4 class="page-header">User Profile</h4>

	<table class="table ">

		<tr><td>Full Name</td><td>  <?php echo $post->post_title; ?></td></tr>
	
		<tr><td>Gender</td><td>  <?php echo $post->gender; ?></td></tr>
		<tr><td>Date of Birth</td><td>  <?php echo $post->dob; ?></td></tr>
		<tr><td>Registration Type</td><td>  <?php echo $post->regtype; ?></td></tr>
		<tr><td>Email Id</td><td>  <?php echo $post->email; ?></td></tr>
		<tr><td>Mobile Number</td><td>  <?php echo $post->mobile; ?></td></tr>
		<tr><td>Alternate Mobile</td><td>  <?php echo $post->mobile2; ?></td></tr>
	 
	 
	 
	  </table>

	 </div>
	 </div>
			   
</section>
</section>
<?php
}