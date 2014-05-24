<div class="post-single row">
<?php while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-item col-sm-12'); ?>>
	<div class="inner">
		<div class="block">
			<div class="block-thumb full">
				<?php echo sg_get_post_thumbnail('large') ?>
			</div>
			<div class="block-body">
				<?php 
					the_content(); 			
				?>
			</div>
		</div>
	</div>
</div>
<?php endwhile; ?>
</div>
<?php 
	if(is_single()){
		include(locate_template('templates/content-bottom.php'));
	}
?>