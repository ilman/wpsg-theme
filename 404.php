<div class="row content-wrapper">
	<div class="col-sm-12 content-main">
		<?php do_action('sg_content_header'); ?>

		<?php 
			$post = $wpdb->get_row($wp_query->request);
			$post_status = sg_val($post, 'post_status');
			if($post_status == 'private') {
				include(locate_template('framework/templates/content-error-private.php'));
			}
			else{
				include(locate_template('framework/templates/content-error-404.php'));
			}
		?>
		
		<?php do_action('sg_content_footer'); ?>
	</div>
</div>
<!-- row -->