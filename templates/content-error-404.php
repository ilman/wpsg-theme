<?php ob_start(); ?>
	<div class="text-center">
		[sg_spacer]
		<p class="text-6x text-primary"><i class="fa fa-warning"></i></p>
		<h2 class="text-ucase text-bold">Oops. The page you requested couldn't be found :(</h2>
		<p>Sorry, the page you are looking for is no longer online or has been moved! Try using our search or just close this page</p>
		[sg_spacer height="30px"]

		<div class="block-search">
			<form action="<?php echo esc_url( home_url( '/' )); ?>">
				<div class="input-group">
					<input type="text" class="form-control input-lg" name="s" value="<?php echo get_search_query(); ?>">
					<span class="input-group-btn">
						<button class="btn btn-lg btn-primary" type="submit"><i class="fa fa-fw fa-search"></i> Search</button>
					</span>
				</div>
			</form>
		</div>
		[sg_spacer height="30px"]

	</div>
	<?php $content = ob_get_clean(); ?>

	<?php echo do_shortcode($content) ?>