<?php ob_start(); ?>
	<div class="text-center">
		[sg_spacer]
		<p class="text-6x text-primary"><i class="fa fa-warning"></i></p>
		<h2 class="text-ucase text-bold">Oops. The page you requested is for member only</h2>
		<p>Please login to view the content of this page</p>
		[sg_spacer height="30px"]

		<p>
			<a class="btn btn-lg btn-primary" href="<?php echo wp_login_url(get_permalink()); ?>">Login</a>
			<span class="btn-lg">or</span>
			<a class="btn btn-lg btn-default" href="<?php echo wp_registration_url(get_permalink()) ?>">Register</a>
		</p>

		[sg_spacer height="30px"]

	</div>
	<?php $content = ob_get_clean(); ?>

	<?php echo do_shortcode($content) ?>