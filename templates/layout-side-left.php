<div class="row sidebar-right">
	<div class="col-sm-9 content-main pull-right">
		<?php do_action('sg_content_header'); ?>
		
		<?php get_template_part($sg_content_base, $sg_content_layout); ?>
		
		<?php do_action('sg_content_footer'); ?>		
	</div>
	<!-- content main -->
	<aside class="col-sm-3 content-side pull-left">
		<?php dynamic_sidebar('blog-sidebar'); ?>
	</aside>
	<!-- content side -->
</div>
<!-- row -->