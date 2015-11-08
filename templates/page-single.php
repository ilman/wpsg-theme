<?php
	global $sg_qid;

	$sg_page_hide_title = get_post_meta($sg_qid, '_sg_mb_page_hide_title', true);
?>
<div class="post-single row">
<?php while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-item col-sm-12'); ?>>
	<?php if(!$sg_page_hide_title): ?>
		<h2 class="page-title-accent"><?php the_title(); ?></h2>
	<?php endif ?>
	<?php 
		the_content(); 			
	?>
</div>
<?php endwhile; ?>
</div>
<?php 
	if(is_single()){
		include(locate_template('templates/content-bottom.php'));
	}
?>