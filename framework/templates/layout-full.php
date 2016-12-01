<div class="row content-wrapper">
	<div class="col-sm-12 content-main">
		<?php do_action('sg_content_header'); ?>

		<?php 
			if(have_posts()){
				sg_get_template_part($sg_wrapper['content_base'], $sg_wrapper['content_layout']);
			}
			else{
				sg_get_template_part('framework/templates/content', 'no-result');
			}
		?>

		<?php do_action('sg_content_footer'); ?>		
	</div>
	<!-- content main -->
</div>
<!-- row -->