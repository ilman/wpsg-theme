<div class="blog-full">
	<ul class="post-list">
		<?php while ( have_posts() ) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
				<?php include(sg_view_path('framework/templates/block-post-single.php')); ?>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php 
		if(is_single()){
			include(sg_view_path('framework/templates/content-bottom.php'));
		}
	?>
</div>