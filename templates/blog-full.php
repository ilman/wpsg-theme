<div class="blog-full">
	<ul class="post-list row list-separate">
	<?php while ( have_posts() ) : the_post(); ?>
	<li id="post-<?php the_ID(); ?>" <?php post_class('post-item col-sm-12'); ?>>
		<div class="block">
			<div class="block-thumb full">
				<?php echo sg_get_post_thumbnail('large') ?>
			</div>
			<div class="block-body">
				<h2 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<div class="post-meta">
					<?php echo sg_get_post_date() ?>
					<?php echo sg_get_post_author() ?>
					<?php echo sg_get_post_comments() ?>
				</div>
				<?php 
					if(is_single()){
						the_content(); 	
					}
					else{
						echo '<p>'.sg_get_excerpt().'</p>';
					}					
				?>
				<div class="post-meta bottom">
					<?php echo sg_get_post_category() ?>
				</div>
			</div>
		</div>
	</li>
	<?php endwhile; ?>
	</ul>
	<?php 
		if(is_single()){
			include(locate_template('templates/content-bottom.php'));
		}
	?>
</div>