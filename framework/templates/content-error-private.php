<div class="text-center">
	<p class="text-6x text-primary" style="font-size:6em; line-height:1.2em;"><i class="fa fa-warning"></i></p>
	<h2 class="text-ucase text-bold">Oops. The page you requested is for member only</h2>
	<p>Please login to view the content of this page</p>

	<p>
		<a class="btn btn-lg btn-primary" href="<?php echo wp_login_url(get_permalink()); ?>">Login</a>
		<span class="btn-lg">or</span>
		<a class="btn btn-lg btn-default" href="<?php echo wp_registration_url(get_permalink()) ?>">Register</a>
	</p>
</div>