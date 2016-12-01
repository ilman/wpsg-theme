<div class="block post-single">
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
			the_content();				
		?>
		<div class="post-meta bottom">
			<?php echo sg_get_post_category() ?>
		</div>
	</div>
</div>