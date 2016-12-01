<div class="text-center">
	
	<p class="text-primary" style="font-size:6em; line-height:1.2em;"><i class="fa fa-warning"></i></p>
	<h2 class="text-ucase text-bold">Oops. No result matched with your criteria :(</h2>
	<p>Sorry, no result matched with your criteria. Please try using another text to search</p>
	

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

</div>