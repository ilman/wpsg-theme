<?php 
	global $sg_qid;

	$sg_page_hide_title = get_post_meta($sg_qid, '_sg_mb_page_hide_title', true);
	$sg_staff_title = get_post_meta($sg_qid, '_sg_mb_staff_title', true);
	$sg_staff_quote = get_post_meta($sg_qid, '_sg_mb_staff_quote', true);
	$sg_staff_linkedin_url = get_post_meta($sg_qid, '_sg_mb_staff_linkedin_url', true);
?>
<div class="post-single row">
<?php while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-item col-sm-12'); ?>>
	<?php if(!$sg_page_hide_title): ?>
		<h2 class="no-margin"><?php the_title(); ?></h2>
		<h4 class="text-primary"><?php echo $sg_staff_title ?></h4>
	<?php endif ?>
	
	<div class="row">
	
	<div class="col-sm-4">
		<p><?php echo sg_get_post_thumbnail('full') ?></p>
		<ul class="list-unstyled">
			<?php if($sg_staff_linkedin_url): ?>
				<li><a class="btn btn-primary" href="<?php echo $sg_staff_linkedin_url ?>"><i class="fa fa-linkedin-square"></i> Linkedin Profile</a></li>
			<?php endif; ?>
		</ul>
	
	</div>
		<!-- col -->
		<div class="col-sm-8">
			<?php the_content(); ?>
		</div>
		<!-- col -->
	
</div>
	<!-- row -->
</div>
<?php endwhile; ?>
</div>
<?php 
	if(is_single()){
		include(locate_template('templates/content-bottom.php'));
	}
?>