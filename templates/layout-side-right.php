<div class="row sidebar-right content-wrapper">
	<div class="col-sm-9 content-main">
		<?php do_action('sg_content_header'); ?>
		
		<?php get_template_part($sg_content_base, $sg_content_layout); ?>
		
		<?php do_action('sg_content_footer'); ?>
	</div>
	<!-- content main -->
	<aside class="col-sm-3 content-side">
		<?php 
			if(get_post_type()=='sg_cpt_office' && has_term( 'Branches', 'sg_cpt_office_group' )){
				get_sidebar('office');
			}
			else{
				dynamic_sidebar('primary-sidebar');
			}
		?>
	</aside>
	<!-- content side -->
</div>
<!-- row -->