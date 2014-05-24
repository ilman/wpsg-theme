<?php 

function sg_get_post_date(){
	return '<span class="post-date"><i class="glyphicon glyphicon-time"></i> '.get_the_date().'</span>';
}

function sg_get_post_category($post_id=false, $count=false){		
	if(!$post_id){
		global $post;
		$post_id = $post->ID;		
	}
		
	$post_cats = get_the_category($post_id);
	
	if(!$count){
		$count= count($post_cats);
	}
		
	$output = '';
	for($i=0; $i<$count; $i++){
		$output .= '<span class="post-category"><i class="glyphicon glyphicon-tags"></i> <a href="'.get_category_link($post_cats[0]->term_id).'">'.$post_cats[0]->cat_name.'</a></span>';
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
	
	return '<span class="post-author"><i class="glyphicon glyphicon-user"></i> <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author_meta('display_name').'</a></span>';
}

function sg_get_post_comments($post_id=false){
	if(!$post_id){
		global $post;
		$post_id = $post->ID;		
	}
	
	$num_comment = get_comments_number($post_id);
	$output = $num_comment.' ';
	
	if($num_comment>1){
		$output .= sg__('Comment');
	}
	else{
		$output .= sg__('Comments');
	}
	
	return '<span class="post-comments"><i class="glyphicon glyphicon-comment"></i> '.$output.'</span>';
}

/**
 * Display navigation to next/previous pages when applicable
 */
 
function sg_get_post_thumbnail($image_size='thumbnail', $params=array()){
	if(has_post_thumbnail()) {
		the_post_thumbnail($image_size, $params);
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
 
    $nav_class = 'site-navigation paging-navigation';
    if ( is_single() )
        $nav_class = 'site-navigation post-navigation';
 
    ?>
    <nav role="navigation" class="<?php echo $nav_class; ?>"> 
    <?php if ( is_single() ) : // navigation links for single posts ?>
 
        <?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . sg_x('&larr;', 'Previous post link') . '</span> %title' ); ?>
        <?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . sg_x('&rarr;', 'Next post link') . '</span>' ); ?>
 
    <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
 
        <?php if ( get_next_posts_link() ) : ?>
        <div class="nav-previous"><?php next_posts_link( sg__('Load more') ); ?></div>
        <?php endif; ?>
  
    <?php endif; ?>
 
    </nav><!-- load more -->
    <?php
}

/**
 * Display nbreadcrumbs
 * http://www.qualitytuts.com/wordpress-custom-breadcrumbs-without-plugin/
 */
function sg_breadcrumbs() {
  
	$showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter = '&raquo;'; // delimiter between crumbs
	$home = 'Home'; // text for the 'Home' link
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$before = '<span class="current">'; // tag before the current crumb
	$after = '</span>'; // tag after the current crumb
	
	global $post;
	$homeLink = home_url();
	
	if (is_home() || is_front_page()) {
	
		if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
	
	}
	else {
	
		echo '<div class="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
		
		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
			echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
		
		} 
		elseif ( is_search() ) {
			echo $before . 'Search results for "' . get_search_query() . '"' . $after;
		
		} 
		elseif ( is_day() ) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;
		
		} 
		elseif ( is_month() ) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
		
		} 
		elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
		
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
				if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			} 
			else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
				echo $cats;
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}
		
		} 
		elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		
		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
			if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
		
		} 
		elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;
		
		} 
		elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
			}
			if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
		
		}
		elseif ( is_tag() ) {
			echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
		
		} 
		elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			echo $before . 'Articles posted by ' . $userdata->display_name . $after;
		
		} elseif ( is_404() ) {
			echo $before . 'Error 404' . $after;
		}
		
		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo sg__('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
		
		echo '</div>';
		
	}
} 