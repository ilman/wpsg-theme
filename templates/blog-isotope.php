<?php 
	$blog_post_column = 12/sg_opt('blog_post_column');
?>
<ul class="post-list row post-isotope">
	<?php while ( have_posts() ) : the_post(); ?>
	<li id="post-<?php the_ID(); ?>" <?php post_class('post-item col-sm-'.$blog_post_column); ?>>
		<div class="inner">
			<div class="block">
				<div class="block-thumb full">
					<?php echo sg_get_post_thumbnail() ?>
				</div>
				<div class="block-body">
					<h2 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
					<div class="post-meta">
						<?php echo sg_get_post_date() ?>
						<?php echo sg_get_post_author() ?>
						<?php echo sg_get_post_comments() ?>
					</div>
					<p><?php echo sg_get_excerpt(); ?></p>
					<div class="post-meta bottom">
						<?php echo sg_get_post_category() ?>
					</div>
				</div>
			</div>
		</div>
	</li>
	<?php endwhile; ?>
</ul>	