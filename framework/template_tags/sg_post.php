<?php 

function sg_get_post_date(){
	return '<span class="post-date"><i class="fa fa-cal"></i> '.get_the_date().'</span>';
}

function sg_get_post_category($post_id=null, $count=null){		
	if(!$post_id){
		global $post;
		$post_id = $post->ID;		
	}
		
	$post_cats = get_the_category($post_id);
	$count_post = count($post_cats);
	
	if(!$count){
		$count = $count_post;
	}	
	elseif($count > $count_post){
		$count = $count_post;
	}
		
	$output = '';
	for($i=0; $i<$count; $i++){
		$output .= '<span class="post-category"><i class="fa fa-tags"></i> <a href="'.get_category_link($post_cats[$i]->term_id).'">'.$post_cats[$i]->cat_name.'</a></span>';
	}
	
	return $output;
}

function sg_get_post_author($user_id=false){
	if(!$user_id){
		global $authordata;
		$user_id = isset($authordata->ID) ? $authordata->ID : 0;
	} 
	else{
		$authordata = get_userdata($user_id);
	}
	
	return '<span class="post-author"><i class="fa fa-user"></i> <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author_meta('display_name').'</a></span>';
}

function sg_get_post_comments($post_id=false){
	if(!$post_id){
		global $post;
		$post_id = $post->ID;		
	}
	
	$num_comment = get_comments_number($post_id);
	$output = $num_comment.' ';
	
	if($num_comment>1){
		$output .= __('Comment', SG_THEME_ID);
	}
	else{
		$output .= __('Comments', SG_THEME_ID);
	}
	
	return '<span class="post-comments"><i class="fa fa-comment"></i> '.$output.'</span>';
}

/**
 * Display navigation to next/previous pages when applicable
 */
 
function sg_get_post_thumbnail($image_size='thumbnail', $params=array()){
	ob_start();
	if(has_post_thumbnail()) {
		the_post_thumbnail($image_size, $params);
	}
	$output = ob_get_clean();

	if(!$output && sg_opt('use_default_image', true)){	
		ob_start();		
			sg_get_post_first_image();
		$output = ob_get_clean();
	}

	return $output;
}

function sg_get_post_first_image(){
	global $post, $posts;
	$first_image = '';
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

	if(isset($matches[1]) && isset($matches[1][0])){
		$first_image = $matches[1][0];
	}

	if($first_image){
		echo '<img src="'.$first_image.'" alt="image" />';
	}
}


/**
 * Display navigation to load more, best used for infinite scrolling
 */
function sg_load_more() {
    global $wp_query, $post, $mim_theme_id;
 
    // Don't print empty markup on single pages if there's nowhere to navigate.
    if ( is_single() ) {
        $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
        $next = get_adjacent_post( false, '', false );
 
        if ( ! $next && ! $previous )
            return;
    }
 
    // Don't print empty markup in archives if there's only one page.
    if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
        return;
 
    $nav_class = 'site-navigation paging-navigation pager';
    if ( is_single() )
        $nav_class = 'site-navigation post-navigation pager';
 
    ?>
    <nav role="navigation" class="<?php echo $nav_class; ?>"> 
    <?php if ( is_single() ) : // navigation links for single posts ?>
 
        <?php previous_post_link( '<div class="nav-link nav-previous">%link</div>', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', SG_THEME_ID) . '</span> %title' ); ?>
        <?php next_post_link( '<div class="nav-link nav-next">%link</div>', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', SG_THEME_ID) . '</span>' ); ?>
 
    <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
 
        <?php if ( get_next_posts_link() ) : ?>
        <div class="nav-link nav-previous"><?php next_posts_link( __('Load More', SG_THEME_ID) ); ?></div>
        <?php endif; ?>
  
    <?php endif; ?>
 
    </nav><!-- load more -->
    <?php
}

