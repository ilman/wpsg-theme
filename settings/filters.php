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


/*change widget title style*/
function sg_widget_title_filter($params){
	return '<div class="sg-title title-fill">'.$params.'</div>';
}
add_filter('widget_title', 'sg_widget_title_filter');


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
add_filter('wp_title', 'sg_wp_title', 10, 2 );



function shortcode_empty_paragraph_fix( $content ) {
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']',
		'<br />[' => '[',
		'<p></p>' => '',
		//'<p>&nbsp;</p>' => '',
	);
	$content = strtr( $content, $array );
	return $content;
}
add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );
add_filter( 'sg_get_content', array( $wp_embed, 'autoembed' ), 8 );


function sg_remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

add_filter('post_thumbnail_html', 'sg_remove_width_attribute');
add_filter('image_send_to_editor', 'sg_remove_width_attribute');


//Page Slug Body Class
function sg_slug_body_class( $classes ) {
	global $post;
	if(isset($post)){
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter('body_class', 'sg_slug_body_class');


function my_form_tag($form_tag){
	$match = array();
	preg_match( "/action='([^']*)'/i", $form_tag, $match);
	$match = (isset($match[1])) ? $match[1] : '';
	$site_url = site_url();
	$parsed_url = parse_url($site_url);
	$url_path = (isset($parsed_url['path'])) ? $parsed_url['path'] : '';
	
	if($match==''){
		$action = '';
	}
	elseif(strpos($match, 'http://')===false && strpos($match, 'http://')===false){
		$action = $match;
		$action = str_replace($url_path, '', $action);
		$action = site_url($action);
	}
	else{
		$action = $match;
	}

	return str_replace($match, $action, $form_tag);
}
add_filter("gform_form_tag", "my_form_tag");

// function sg_redirect_post_location($location) {

// 	if(isset($_POST['save']) || isset($_POST['publish'])){

		

// 		$location = 'edit.php';

// 		if(isset($_POST['post_type'])){

// 			$location .= '?post_type='.$_POST['post_type'];

// 		}



// 		return admin_url($location);

// 	}

// 	return $location;

// }

// add_filter('redirect_post_location', 'sg_redirect_post_location');