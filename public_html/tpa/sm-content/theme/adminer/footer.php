<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>-->

<script src="<?php bloginfo('template_directory'); ?>/local/jquery.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/local/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/local/jquery-ui.min.js" type="text/javascript"></script>
        
        <!-- Sparkline -->
        <!--<script src="<?php bloginfo('template_directory'); ?>/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>-->
        <!-- jvectormap -->
        <script src="<?php bloginfo('template_directory'); ?>/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php bloginfo('template_directory'); ?>/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="<?php bloginfo('template_directory'); ?>/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="<?php bloginfo('template_directory'); ?>/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php bloginfo('template_directory'); ?>/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php bloginfo('template_directory'); ?>/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?php bloginfo('template_directory'); ?>/js/AdminLTE/app.js" type="text/javascript"></script>

		<!-- AdminLTE App -->
        <script src="<?php bloginfo('root_template_directory'); ?>/js/app.js" type="text/javascript"></script>

     

        <!-- AdminLTE for demo purposes -->
        <!--<script src="<?php bloginfo('template_directory'); ?>/js/AdminLTE/demo.js" type="text/javascript"></script>-->
<script>
$(function(){
	$("#rechargeplan").change(function(){
		$("#txtdet").val($("#rc"+$(this).val()+"details").html());
		$("#txtamount").val($("#rc"+$(this).val()+"details").attr("data-price"));
	});
});
</script>
    </body>
</html>
<?php get_alert(); ?>