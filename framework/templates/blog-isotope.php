<?php 
	if(is_archive()){
		$blog_post_column = sg_opt('archive_post_column', 3);
	}
	elseif(is_search()){
		$blog_post_column = sg_opt('search_post_column', 3);
	}
	else{
		$blog_post_column = sg_opt('blog_post_column', 3);
	}
	$blog_post_column = 12/$blog_post_column;
?>

<div class="blog-isotope">
	<ul class="post-list list-masonry row">
		<?php while ( have_posts() ) : the_post(); ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class('post-item col-sm-'.$blog_post_column); ?>>
			<?php include(sg_view_path('framework/templates/block-post-thumb.php')) ?>
		</li>
		<?php endwhile; ?>
	</ul>
</div>