<div class="post-full">

	<?php 
		if(method_exists('SG_PopularPosts','set_post_views')){
			SG_PopularPosts::set_post_views(get_the_ID());
		}

		$permalink = urlencode(get_the_permalink());

		$share_buttons = '<a class="btn js-window-open btn-facebook" target="_blank" title="Share to facebook" href="https://www.facebook.com/sharer/sharer.php?u='.$permalink.'"><i class="fa fa-facebook"></i></a>
		<a class="btn js-window-open btn-twitter" target="_blank" title="Share to twitter" href="https://twitter.com/home?status='.$permalink.'"><i class="fa fa-twitter"></i></a>
		<a class="btn js-window-open btn-google-plus" target="_blank" title="Share to google plus" href="https://plus.google.com/share?url='.$permalink.'"><i class="fa fa-google-plus"></i></a>
		<a class="btn js-window-open btn-pinterest" target="_blank" title="share to pinterest" href="https://pinterest.com/pin/create/button/?url='.$permalink.'"><i class="fa fa-pinterest"></i></a>
		<span>Share this article</span>';
	?>

	<h1 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>

	<div class="post-shares">
		<?php echo $share_buttons; ?>
	</div>
	<!-- post-shares -->

	<div class="row">
		<div class="col-sm-9">

			<?php $post_thumb = sg_get_post_thumbnail('post-large'); ?>

			<?php if($post_thumb): ?>
				<div class="post-thumb">
					<?php echo $post_thumb ?>
					<div class="post-meta post-tags">
						<?php echo sg_get_post_category(); ?>
					</div>
				</div>
				<!-- post-thumb -->
			<?php else: ?>
				<div class="post-meta post-tags"><?php echo sg_get_post_category(); ?></div>
			<?php endif; ?>

			<div class="post-body">
				<?php 
					the_content();
				?>
			</div>
			<!-- post-body -->

			<div class="post-shares small">
				<?php echo $share_buttons; ?>
			</div>
			<!-- post-shares -->

			
		</div>
		<!-- col -->
		<div class="col-sm-3">
			<div class="profile-block">
				<div class="profile-thumb">
					<?php echo get_avatar(get_the_author_meta('ID'), 150 ); ?>
				</div>
				<div class="profile-body">
					<h4 class="profile-name"><?php echo sg_get_post_author() ?></h4>
					<div class="profile-bio">
						<?php echo the_author_meta('description') ?>
					</div>
					<div class="post-date">
						Article published on:
						<strong><?php echo sg_get_post_date() ?></strong>
					</div>
				</div>
			</div>
			<!-- profile-block -->
		</div>
		<!-- col -->
	</div>
	<!-- row -->


	<div class="widget panel">
		<div class="widget-heading panel-heading">
			<h4 class="widget-title panel-title">Our related holiday destinations</h4>
		</div>
		<!-- panel-title -->
		<div class="widget-body panel-body">
			<?php 
				$terms = get_the_terms(get_the_ID(), 'continent');
				if(!empty($terms)){
				    $term = array_shift($terms); // get the first term
				    SG_RelatedDestinations::get_posts(4, '', '', $term->slug);
				}
				else{
					SG_RelatedDestinations::get_posts(4, '', '');
				}
			?>
		</div>
		<!-- panel-body -->
	</div>
	<!-- panel -->

</div>
<!-- post-full -->