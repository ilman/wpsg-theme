<?php wp_reset_query(); ?>

<?php 
	if(!function_exists('sg_list_comments_cb')):
		function sg_list_comments_cb($comment, $args, $depth) {
			$GLOBALS['comment'] = $comment;

			include(sg_view_path('framework/templates/comment-item.php'));
		}
	endif;
?>
	


<div class="panel widget" id="discussion">
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
<div class="panel widget" id="respond">

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



