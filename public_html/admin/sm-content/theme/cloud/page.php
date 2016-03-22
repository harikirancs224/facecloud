<?php get_header("script"); ?>
<div class="container wh" style="min-height:500px;">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php //have_posts()){} ?>
			<h3><?php data('post_title'); ?></h3>
			 <p><?php data('post_content'); ?></p>
		</div><!-- #content -->
	</div><!-- #primary -->
</div>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>