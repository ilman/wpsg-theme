<?php wp_reset_query(); ?>

<?php 
function sg_list_comments_cb($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?>>
	<article id="comment-<?php comment_ID(); ?>">
		<?php if ($comment->comment_approved == '0') : ?>
		<div class="alert alert-warning fade in"> <a class="close" data-dismiss="alert">&times;</a>
			<p>
				<?php sg_e('Your comment is awaiting moderation.'); ?>
			</p>
		</div>
		<?php endif; ?>
		<div class="block block-comment thumb-left">
			<div class="block-thumb">
				<?php echo get_avatar($comment, $size = '48'); ?>
			</div>
			<!-- block thumb -->
			<div class="block-body">
				<header class="comment-header vcard">
					<?php printf(sg__('<cite class="fn">%s</cite>'), ucfirst(get_comment_author_link())); ?>
					<time datetime="<?php echo comment_date('c'); ?>">
						<a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
							<?php printf(sg__('%1$s'), get_comment_date(),  get_comment_time()); ?>
						</a>
					</time>
					<?php edit_comment_link(sg__('(Edit)'), '', ''); ?>
				</header>
				
				<section class="comment-body">
					<?php comment_text() ?>
				</section>
				<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
			</div>
		</div>
	</article>
</li>
<?php 
} 
?>
	
<!-- start comment list -->
<?php if (have_comments()) : ?>
<section id="comments">
	<h3><?php printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'studiofolio'), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>
	<ol class="comment-list">
		<?php wp_list_comments(array('callback' => 'sg_list_comments_cb')); ?>
	</ol>
	
	
	<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
	<nav id="comments-nav" class="pager">
		<div class="previous">
			<?php previous_comments_link(__('&larr; Older comments', 'studiofolio')); ?>
		</div>
		<div class="next">
			<?php next_comments_link(__('Newer comments &rarr;', 'studiofolio')); ?>
		</div>
	</nav>
	<?php endif; // check for comment navigation ?>
	
	
	<?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
	<div class="alert alert-block fade in"> <a class="close" data-dismiss="alert">&times;</a>
		<p>
			<?php sg_e('Comments are closed.'); ?>
		</p>
	</div>
	<?php endif; ?>
</section>
<!-- /#comments -->
<?php endif; ?>



<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
<section id="comments">
	<div class="alert alert-block fade in"> <a class="close" data-dismiss="alert">&times;</a>
		<p>
			<?php _e('Comments are closed.', 'studiofolio'); ?>
		</p>
	</div>
</section>
<!-- comments -->
<?php endif; ?>



<?php if (comments_open()) : ?>
<section id="respond">
	<h3>
		<?php comment_form_title(sg__('Leave a Reply'), sg__('Leave a Reply to %s')); ?>
	</h3>
	<p class="cancel-comment-reply">
		<?php cancel_comment_reply_link(); ?>
	</p>
	
	<?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
		<p>
			<?php printf(sg__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(get_permalink())); ?>
		</p>
	<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if(is_user_logged_in()): ?>
				<p>
					<?php printf(sg__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.'), get_option('siteurl'), $user_identity); ?> 
					<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php sg__('Log out of this account'); ?>">
						<?php sg_e('Log out'); echo '&raquo;'; ?>
					</a>
				</p>
			<?php else : ?>
			
			<div class="row comment-form-row">
				<div class="col-sm-4">
					<div class="form-group">
						<label for="author">
							<?php 
								sg_e('Name');
								echo ' <small>('; sg_e('required'); echo ')</small>';
							?>
						</label>
						<input type="text" class="form-control" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="1" <?php if($req) echo "aria-required='true'"; ?>>
					</div>
				</div>
				<!-- col -->
				<div class="col-sm-4">
					<div class="form-group">
						<label for="email">
							<?php 
								sg_e('Email');
								echo ' <small>('; sg_e('will not be published'); echo ')</small>';
								echo ' <small>('; sg_e('required'); echo ')</small>';
							?>
						</label>
						<input type="email" class="form-control" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="2" <?php if($req) echo "aria-required='true'"; ?>>
					</div>
				</div>
				<!-- col -->
				<div class="col-sm-4">
					<div class="form-group">
						<label for="url">
							<?php sg_e('Website'); ?>
						</label>
						<input type="url" class="form-control" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" tabindex="3">
					</div>
				</div>
				<!-- col -->
			</div>
			<!-- row -->
			<?php endif; ?>
			<div class="row comment-form-row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="comment">
							<?php sg_e('Comment'); ?>
						</label>
						<textarea name="comment" id="comment" class="form-control" rows="6" tabindex="4"></textarea>
					</div>
				</div>
				<!-- col -->
			</div>
			<!-- row -->
			
			<div class="row comment-form-row">
				<div class="col-sm-12">
					<p class="form-btn">
						<input name="submit" class="btn btn-primary" type="submit" id="submit" tabindex="5" value="<?php sg_e('Submit Comment'); ?>">
					</p>
				</div>
				<!-- col -->
			</div>
			<!-- row -->
			
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php endif; // if registration required and not logged in ?>
</section>
<!-- respond -->
<?php endif; ?>
