<?php 
	$blog_post_column = sg_opt('blog_post_column', 2);
	$blog_post_column = 12/$blog_post_column;
?>
<div class="blog-thumb-column">
	<ul class="post-list row">
		<?php while ( have_posts() ) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('post-item col-sm-'.$blog_post_column); ?>>
				<?php include(sg_view_path('framework/templates/block-post-thumb.php')) ?>
			</li>
		<?php endwhile; ?>
	</ul>
</div>