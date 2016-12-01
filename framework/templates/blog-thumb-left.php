<div class="blog-thumb-left">
	<ul class="post-list">
		<?php while ( have_posts() ) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
				<div class="block block-post">
					<div class="block-thumb align-left">
						<?php echo sg_get_post_thumbnail('post-thumb') ?>
					</div>
					<div class="block-body">
						<h2 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						<div class="post-meta">
							<?php echo sg_get_post_date() ?>
							<?php echo sg_get_post_author() ?>
							<?php echo sg_get_post_comments() ?>
						</div>
						<p><?php echo sg_get_excerpt(); ?></p>
						<div class="post-meta">
							<?php echo sg_get_post_category() ?>
						</div>
					</div>
				</div>
			</li>
		<?php endwhile; ?>
	</ul>
</div>	