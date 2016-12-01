<?php 
	$block_thumb_class = (isset($block_thumb_class)) ? $block_thumb_class : 'full';
?>
<div class="block block-post">
	<div class="block-thumb <?php echo $block_thumb_class ?>">
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
		<div class="post-meta bottom">
			<?php echo sg_get_post_category() ?>
		</div>
	</div>
	<?php echo sg_action_post_link() ?>
</div>