<li <?php comment_class('comment-item'); ?>>
	<article class="comment-block" id="comment-<?php comment_ID(); ?>">
		<?php if ($comment->comment_approved == '0') : ?>
			<p class="alert alert-warning fade in"> <a class="close" data-dismiss="alert">&times;</a>
				<?php _e('Your comment is awaiting moderation.', SG_THEME_ID); ?>
			</p>
		<?php endif; ?>

		<div class="comment-header">
			<a class="comment-avatar">
				<?php echo get_avatar($comment, $size = '50'); ?>
			</a>
			<span class="comment-name"><?php printf('%s', ucfirst(get_comment_author_link())); ?></span>
			<span class="comment-date"><?php printf(__('%1$s', SG_THEME_ID), get_comment_date(),  get_comment_time()); ?></span>
			<?php if(function_exists('gtcn_comment_numbering')): ?>
				<a class="comment-num" href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
					<?php echo gtcn_comment_numbering($comment->comment_ID, $args); ?>
				</a>
			<?php endif ?>
		</div>
		<div class="comment-body">
			<?php comment_text() ?>
		</div>
		<div class="comment-footer">
			<?php edit_comment_link('('.__('Edit', SG_THEME_ID).')', '', ''); ?>
			<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
		</div>
	</article>
</li>