<?php 
	$block_thumb_class = (isset($block_thumb_class)) ? $block_thumb_class : 'full';
	$block_thumb = sg_get_post_thumbnail('post-thumb');
	$block_class = ($block_thumb) ? 'post-block' : 'post-block text-only'
?>

<div class="<?php echo $block_class ?>">
	<?php if($block_thumb): ?>
		<div class="post-thumb <?php echo $block_thumb_class ?>">
			<?php echo $block_thumb; ?>
		</div>
	<?php endif; ?>
	<div class="post-body">
		<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		<p><?php echo sg_get_excerpt(); ?></p>
		<div class="post-meta post-tags">
			<?php echo sg_get_post_category(); ?>
		</div>
	</div>
	<?php 
		$post_format = get_post_format();		

		switch ($post_format) {
			case 'video': $fa_class = 'fa-play'; break;
			case 'audio': $fa_class = 'fa-music'; break;
			case 'link': $fa_class = 'fa-link'; break;
			case 'chat': $fa_class = 'fa-comments'; break;
			case 'quote': case 'status': $fa_class = 'fa-quote-right'; break;
			case 'image': case 'gallery': $fa_class = 'fa-image'; break;
			default: $fa_class = 'fa-asterisk'; break;
		}

		if($post_format){
			echo '<div class="post-format"><span><i class="fa '.$fa_class.'"></i></span></div>';
		}

	?>
	<?php echo sg_action_post_link() ?>
</div>