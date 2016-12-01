<?php wp_reset_query(); ?>

<?php 
	if(function_exists('sg_list_comments_cb')):
		function sg_list_comments_cb($comment, $args, $depth) {
			$GLOBALS['comment'] = $comment; 
?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>">
			<?php if ($comment->comment_approved == '0') : ?>
			<div class="alert alert-warning fade in"> <a class="close" data-dismiss="alert">&times;</a>
				<p>
					<?php _e('Your comment is awaiting moderation.', SG_THEME_ID); ?>
				</p>
			</div>
			<?php endif; ?>
			<div class="block block-comment">
				<div class="block-thumb align-left">
					<?php echo get_avatar($comment, $size = '50'); ?>
				</div>
				<!-- block thumb -->
				<div class="block-body">
					<header class="comment-header vcard">
						<?php printf(__('<cite class="fn">%s</cite>', SG_THEME_ID), ucfirst(get_comment_author_link())); ?>
						<time datetime="<?php echo comment_date('c'); ?>">
							<a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
								<?php printf(__('%1$s', SG_THEME_ID), get_comment_date(),  get_comment_time()); ?>
							</a>
						</time>
						<?php edit_comment_link(__('(Edit)', SG_THEME_ID), '', ''); ?>
					</header>
					
					<section class="comment-body">
						<?php comment_text() ?>
					</section>
					<p>
						<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
					</p>
				</div>
			</div>
		</article>
	</li>
<?php 
		}
	endif;
?>
	


<div class="panel widget">

	<div class="panel-heading widget-heading">
		<h4 class="panel-title widget-title">Comments</h4>

	</div>
	<!-- panel-heading -->
	<div class="panel-body widget-body">
		<?php include(sg_view_path('framework/templates/comment-list.php')) ?>
	</div>
	<!-- panel-body -->

</div>
<!-- panel -->

<?php if(comments_open()): ?>
<div class="panel widget" id="">

	<div class="panel-heading widget-heading">
		<h4 class="panel-title widget-title"><?php comment_form_title(__('Leave a Reply', SG_THEME_ID), __('Leave a Reply to %s', SG_THEME_ID)); ?></h4>

	</div>
	<!-- panel-heading -->
	<div class="panel-body widget-body">		
		<?php 			
			if(get_option('comment_registration') && !is_user_logged_in()){
				echo '<p class="alert alert-warning">'.printf(__('You must be <a href="%s">logged in</a> to post a comment.', SG_THEME_ID), wp_login_url(get_permalink())).'</p>';
			}
			else{
				echo '<p class="cancel-comment-reply">'.cancel_comment_reply_link().'</p>';
				include(sg_view_path('framework/templates/comment-form.php'));
			}
		?>
	</div>
	<!-- panel-body -->

</div>
<!-- panel -->
<?php endif; ?>



