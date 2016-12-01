<!-- start comment list -->

<section id="comments">
	<?php if (have_comments()) : ?>
		<p><em><?php printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), SG_THEME_ID), number_format_i18n(get_comments_number()), get_the_title()); ?></em></p>

		<ol class="comment-list list-unstyled">
			<?php wp_list_comments(array('callback' => 'sg_list_comments_cb')); ?>
		</ol>		
		
		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
			<nav id="comments-nav" class="pager">
				<div class="previous">
					<?php previous_comments_link('&larr; '.__('Older comments', SG_THEME_ID)); ?>
				</div>
				<div class="next">
					<?php next_comments_link(__('Newer comments', SG_THEME_ID).' &rarr;'); ?>
				</div>
			</nav>
		<?php endif; ?>
	<?php else: ?>
		<p><em>No comment yet. Be the first to comment!</em></p>
	<?php endif; ?>
	
	
	<?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')): ?>
		<div class="alert alert-info fade in"> <a class="close" data-dismiss="alert">&times;</a>
			<?php _e('Comments are closed.', SG_THEME_ID); ?>
		</div>
	<?php endif; ?>
</section>
<!-- /#comments -->