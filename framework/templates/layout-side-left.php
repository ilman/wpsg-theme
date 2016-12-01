<div class="row sidebar-right content-wrapper">
	<div class="col-sm-8 content-main pull-right">
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
	<aside class="col-sm-4 content-side pull-left">
		<?php dynamic_sidebar('primary-sidebar'); ?>
	</aside>
	<!-- content side -->
</div>
<!-- row -->