<?php

/*control wordpress jpeg quality*/
function sg_jpeg_quality($arg) {
	return (int)60;
}
add_filter('jpeg_quality', 'sg_jpeg_quality');

/*enable show homepage in admin set menu*/
function sg_show_home_menu( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter('wp_page_menu_args', 'sg_show_home_menu');

/*control page template*/
function sg_custom_page_template($page_template){
	if( is_page('search-result')){
		$page_template = SG_THEME_PATH.'/templates/page-search-result.php';
	}
	elseif( is_page('detail')){
		$page_template = SG_THEME_PATH.'/templates/page-deal-detail.php';
	}	
	return $page_template;
}
add_filter('page_template', 'sg_custom_page_template');

/*change before widget class*/
function sg_widget_filter($params){
	$params[0]['before_widget'] = str_replace('_','-',$params[0]['before_widget']);
	return $params;
}
add_filter('dynamic_sidebar_params', 'sg_widget_filter'); 

/*change template using filter*/
function test_asd(){
	return 'thumb';
}
//add_filter('content_layout', 'test_asd'); 

/*wp title*/
function sg_wp_title($title, $sep) {
	global $paged, $page;

	if(is_feed()){
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo('description', 'display');
	if($site_description && (is_home() || is_front_page())){
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if($paged >= 2 || $page >= 2){
		$title = "$title $sep " . sprintf(sg__('Page %s'), max($paged, $page));
	}

	return $title;
}
add_filter( 'wp_title', 'sg_wp_title', 10, 2 );

function shortcode_empty_paragraph_fix( $content ) {
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']',
		'<p></p>' => '',
		//'<p>&nbsp;</p>' => '',
	);
	$content = strtr( $content, $array );
	return $content;
}
add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );


add_filter( 'sg_get_content', array( $wp_embed, 'autoembed' ), 8 );

