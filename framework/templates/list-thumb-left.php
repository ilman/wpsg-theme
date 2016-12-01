<ul class="post-list row list-separate">
<?php while ( $sg_post->have_posts() ) : $sg_post->the_post(); ?>
<li id="post-<?php the_ID(); ?>" <?php post_class('post-item col-sm-12'); ?>>
	<div class="block thumb-left">
		<div class="block-thumb">
			<?php echo sg_get_post_thumbnail() ?>
		</div>
		<div class="block-body">
			<h2 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<div class="post-meta">
				<?php 
					// echo '<pre style="padding:10px; border:#ddd solid 1px; background:#eee; color:#999;">';
					// print_r($sg_post->post->ID);
					// echo '</pre>';
					// echo '<pre style="padding:10px; border:red solid 1px; background:#eee; color:#999;">';
					// print_r(get_the_ID());
					// echo '</pre>';

					echo do_shortcode('[sg_snippet id="70"]');
				?>
				<?php 
					// echo '<pre style="padding:10px; border:blue solid 1px; background:#eee; color:#999;">';
					// print_r(get_post_meta(get_the_ID(), '_sg_mb_staff_title', true ));
					// echo '</pre>';
				?>
				<?php echo sg_get_post_date() ?>
				<?php echo sg_get_post_author() ?>
				<?php echo sg_get_post_comments() ?>
			</div>
			<p><?php echo sg_get_excerpt(); ?></p>
			<div class="post-meta">
				<?php echo sg_get_post_category() ?>
			</div>
		</div>
	</div>
</li>
<?php endwhile; ?>
</ul>	