<div class="container-fluid menubar">
	<div class="container">
		<div class="footer">
			<div class="col-md-3 col-xs-12 col-sm-12">
				<h3 >CORPORATE</h3>
				<ul>
					<!-- <li><a href="<?php bloginfo('siteurl'); ?>">HOME</a></li> -->
					<li><a href="<?php bloginfo('siteurl'); ?>/about-us">ABOUT US</a></li>
					<li><a href="<?php bloginfo('siteurl'); ?>/careers">CAREERS</a></li>
					<li><a href="<?php bloginfo('siteurl'); ?>/post-your-ad">POST MY BUSINESS</a></li>
					<li><a href="<?php bloginfo('siteurl'); ?>/contact-us">CONTACT US</a></li>
				</ul>
			</div>
			<div class="col-md-2 col-xs-12 col-sm-12">
				<h3 >TOP CITIES</h3>
				<ul>
					<!-- <li><a href="<?php bloginfo('siteurl'); ?>">HOME</a></li> -->
					<li><a href="<?php bloginfo('siteurl'); ?>/about-us">HYDERABAD</a></li>
					<li><a href="<?php bloginfo('siteurl'); ?>">BANGOLORE</a></li>
					<li><a href="<?php bloginfo('siteurl'); ?>/post-your-ad">MUMBAI</a></li>
					<li><a href="<?php bloginfo('siteurl'); ?>/contact-us">DELHI</a></li>
					<li><a href="<?php bloginfo('siteurl'); ?>/contact-us">PUNE</a></li>
					<li><a href="<?php bloginfo('siteurl'); ?>/contact-us">KOLKATTA</a></li>
				</ul>
			</div>
			<div class="col-md-4 fetcls col-xs-12 col-sm-12" style="text-align:center">
				<h3>DOWNLOAD APP</h3>
				<a href="#" target="_blank"><img src="<?php bloginfo("template_directory");?>/images/foot1.png" /></a>
				<a href="#" target="_blank"><img src="<?php bloginfo("template_directory");?>/images/foot2.png" /></a>
				<a href="#" target="_blank"><img src="<?php bloginfo("template_directory");?>/images/foot3.png" /></a>
			</div>
			
			<div class="col-md-3 fetcls col-xs-12 col-sm-12">
				<div class="row"><h3>Follow us</h3>
				<a href="#" target="_blank"><img src="<?php bloginfo("template_directory");?>/images/fb.png" /></a>
				<a href="#" target="_blank"><img src="<?php bloginfo("template_directory");?>/images/twit.png" /></a>
				<a href="#" target="_blank"><img src="<?php bloginfo("template_directory");?>/images/in.png" /></a>
				<a href="#" target="_blank"><img src="<?php bloginfo("template_directory");?>/images/wifi.png" /></a>
			</div>
			<div class="">
			<div class="cat" style="float:right;">
			<p>Copyright &copy; 2015 - <?php echo SMTITLE; ?>.All Rights Reserved.</p>
			
			</div>
			</div></div>
		</div>
	</div>
</div>

<div id="loader" class="mobile">
	<div class="cell">
		<img src="<?php echo bloginfo('mobile_template_directory'); ?>/images/ajax-loader.gif" alt="loading" /> 
	</div>
</div>
<?php echo do_shortcode('[POPUP element=a]'); ?></a>
<?php echo do_shortcode('[LIGHTBOX]'); ?>
<?php echo do_shortcode('[INTRO]'); ?>
<?php sm_foot(); ?>
<script type="text/javascript">
	$(function() {
		if($(".mobile").css("display")!="none")
		{
		//alert($(".mobile").css("display"));
			var $menu = $('nav#menu'),
				$html = $('html, body');
			
			$menu.mmenu({
				dragOpen: true
			});
			
			$('a').click(function(){
				var hr=$(this).attr("href");
				$(".subpage").css("display","none");
				if($(hr).attr("role")=="content")
					$(hr).css("display","block");
				
			});
			$('button').click(function(){
				var hr=$(this).attr("href");
				$(".subpage").css("display","none");
				if($(hr).attr("role")=="content")
					$(hr).css("display","block");
				
			});
		}
	});
</script>
<script>//pushalert('Welcome to Shankam.com. Please note your ID :: <b>SHNKM16</b><form action="" method="post"><input type="hidden" name="logname" value="SHNKM16"/> <input type="hidden" name="logpswrd" value="1234"/>Click <button type="submit" name="userlogin" value="g">Continue</button> to Dashboard</form>');</script>
<?php get_alert(); ?>
</body>
</html>