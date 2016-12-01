<div class="row sidebar-right content-wrapper">
	<div class="col-sm-9">
		<div class="row">
			<div class="col-sm-9 content-main pull-right">
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
			<aside class="col-sm-3 content-side pull-left">
				<?php dynamic_sidebar('secondary-sidebar'); ?>
			</aside>
			<!-- content side -->
		</div>
		<!-- row -->		
	</div>
	<!-- content main -->
	<aside class="col-sm-3 content-side">
		<?php dynamic_sidebar('primary-sidebar'); ?>
	</aside>
	<!-- content side -->
</div>
<!-- row -->