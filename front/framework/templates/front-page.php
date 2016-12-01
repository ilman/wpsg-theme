<?php if(!isset($post)){ $post = null; } ?>

<h3 class="section-title">Featured</h3>


<?php 
	$args = array( 
		'posts_per_page' => 4,
		'ignore_sticky_posts' => 1,
		'post_type'=> 'post',
		'category_name' => 'featured',
		'order' => 'DESC',
	);
	$temp_post = $post;
	$post = new WP_Query($args);
?>


<?php $i=0; while($post->have_posts()): $post->the_post(); ?>

	<?php if($i<1): ?>

		<div class="post-featured">
			<div class="post-block">
				<?php $post_thumb = sg_get_post_thumbnail('post-large'); ?>
				<div class="post-thumb">
					<?php echo $post_thumb ?>
				</div>
				<div class="post-body">
					<div class="inner">
						<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						<p>
							<?php 
								$content = get_the_excerpt();
								$content = strip_shortcodes($content);
								echo wp_trim_words($content, 50, '&hellips;');	
							?>
						</p>
						<div class="post-meta post-tags">
							<?php echo sg_get_post_category(); ?>
							<a class="btn btn-primary btn-read-more" href="<?php the_permalink() ?>">Find Out More</a>
						</div>
					</div>
				</div>
			</div>
			<!-- post-block -->
		</div>
		<!-- featured post -->

		<div class="row post-list">
	<?php else: ?>
	
		<div class="col-sm-4 post-item">
			<?php include(sg_view_path('framework/templates/block-post-thumb.php')); ?>
		</div>
		<!-- col -->
	
	<?php endif; ?>

<?php $i++; endwhile; ?>

<?php if($i>0): ?>
	</div>
	<!-- row -->
<?php endif; ?>

<?php 
	$post = $temp_post; 
	wp_reset_query();
?>






<h3 class="section-title">Most Recent</h3>

<?php 
	$args = array( 
		'posts_per_page' => 3,
		'post_type'=> 'post',
		'ignore_sticky_posts' => 1,
		'order' => 'DESC',
	);
	$temp_post = $post;
	$post = new WP_Query($args);
?>

<div class="row post-list">
	<?php while($post->have_posts()): $post->the_post(); ?>
		<div class="col-sm-4 post-item">
			<?php include(sg_view_path('framework/templates/block-post-thumb.php')); ?>
		</div>
		<!-- col -->
	<?php endwhile; ?>
</div>
<!-- row -->

<?php 
	$post = $temp_post; 
	wp_reset_query();
?>






<h3 class="section-title">Most Popular</h3>

<?php SG_PopularPosts::get_posts(3) ?>