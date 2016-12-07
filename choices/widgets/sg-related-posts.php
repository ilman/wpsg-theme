<?php 

/*
http://wp.tutsplus.com/tutorials/creative-coding/building-custom-wordpress-widgets/ 
http://www.wpbeginner.com/wp-themes/how-to-add-related-posts-with-a-thumbnail-without-using-plugins/
*/

class SG_Latest_Posts_Widget extends WP_Widget {
	
	public function __construct() {
		global $mim_theme_id;
		
		parent::__construct(
	 		'sg_latest_post', // Base ID
			'Latest Post', // Name
			array( 'description' => __('Showing related posts in list style', SG_THEME_ID) ) // Args
		);
	}
	
	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		global $mim_theme_id;
		global $post;		
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		if ( ! empty( $title ) ){
			echo $before_title . $title . $after_title;
		}
		
		sg_latest_post($instance['num_post'], $instance['exclude']);
		
		echo $after_widget;	
	}
	
	/**
	 * Back-end widget form.
	 */
 	public function form( $instance ) {
		global $mim_theme_id;
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __('Latest Posts');
		}
		
		$num_post = (isset($instance['num_post'])) ? $instance['num_post'] : 4;
		
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'num_post' ); ?>"><?php _e( 'Number of Posts:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'num_post' ); ?>" name="<?php echo $this->get_field_name( 'num_post' ); ?>" type="text" value="<?php echo esc_attr( $num_post ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'cat_slug' ); ?>"><?php _e( 'Exclude Category Slug:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" type="text" value="<?php echo esc_attr( $cat_slug ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['num_post'] = ( !empty( $new_instance['num_post'] ) ) ? strip_tags( $new_instance['num_post'] ) : '';
		$instance['cat_slug'] = ( !empty( $new_instance['cat_slug'] ) ) ? strip_tags( $new_instance['cat_slug'] ) : '';

		return $instance;
	}

}

function sg_latest_post($num_post, $exclude=''){
	global $post;		
	$orig_post = $post;
	
	$categories = get_the_category($post->ID);
	if (!$categories) { return false; }
	
	$category_ids = array();
	foreach($categories as $individual_category){
		if($individual_category->slug != $exclude){
			$category_ids[] = $individual_category->term_id;
		}
	}
	
	$args=array(
		'cat' => $category_ids[0],
		'post__not_in' => array($post->ID),
		'posts_per_page'=> $num_post
	);
	
	$latest_post = new WP_Query( $args );
			
	if( $latest_post->have_posts() ):
?>
	<div class="widget-mim-related-post">
		<ul>
			<?php while ( $latest_post->have_posts() ) : $latest_post->the_post(); ?>
			<li>
			<?php 
				$post_image = get_post_meta($post->ID,'image',true);
				$post_image_thumb = get_post_meta($post->ID,'thumb',true);
			?>
				<div class="div-thumbnail-block">
					<div class="thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php 
								if ( has_post_thumbnail() ) {
									the_post_thumbnail('post-square');
								}
								elseif($post_image || $post_image_thumb){
									$image = ($post_image_thumb) ? $post_image_thumb : $post_image;
									//$image_data = getimagesize($image);
									//$base_dimension = ($image_data[0] < $image_data[1]) ? 'base-width' : 'base-height';
									$base_dimension = 'base-width';
									echo '<div class="mim-image-wrap '.$base_dimension.'"><img src="'.$image.'" alt="'.get_the_title().'" /></div>';
								}
								else {
									echo '<img src="'.get_template_directory_uri().'/assets/img/default.gif" width="50" height="50" alt="'.get_the_title().'" />';
								}					
							?>
						</a>
					</div>
					<div class="block">
						<h5 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						<div class="post-meta">Posted in <?php echo get_the_time('F d, Y'); ?></div>
					</div>
				</div>
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php
	else:
		echo '<div class="widget-mim-related-post">No related post within the same category</div>'; 
	endif;
	
	$post = $orig_post;
	wp_reset_query();	
}

function register_sg_latest_posts_widget(){
     register_widget('SG_Latest_Posts_Widget');
}

add_action('widgets_init', 'register_sg_latest_posts_widget');