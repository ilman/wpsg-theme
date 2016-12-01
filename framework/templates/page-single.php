<?php
	global $sg_qid;
	
	$sg_show_theme_title = sg_get_post_meta($sg_qid, '_sg_theme_title', true, true);
?>


<?php while ( have_posts() ) : the_post(); ?>
<div id="page-<?php the_ID(); ?>" <?php post_class('post-single'); ?>>
	<?php if($sg_show_theme_title): ?>
		<div class="post-header">
			<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		</div>
		<!-- post-header -->
	<?php endif ?>

	<div class="post-content">
		<?php 
			the_content(); 			
		?>
	</div>
</div>
<?php endwhile; ?>

<?php 
	if(is_single()){
		include(locate_template('framework/templates/content-bottom.php'));
	}
?>