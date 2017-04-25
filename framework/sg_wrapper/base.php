<?php 

use Scienceguard\SG_Util;

$sg_qid = get_queried_object_id();
$sg_wrapper_file = SG_Wrap::$main_template;
$sg_wrapper = array(
	'theme_layout' => sg_get_post_meta($sg_qid, '_sg_theme_layout', true),
	'theme_section' => sg_get_post_meta($sg_qid, '_sg_theme_section', true),
	'theme_section_class' => sg_get_post_meta($sg_qid, '_sg_theme_section_class', true),
	'theme_container' => sg_get_post_meta($sg_qid, '_sg_theme_container', true),
	'content_base' => null,
	'content_layout' => null,
	'file' => $sg_wrapper_file,
);


/*--- validate theme_layout ---*/
if($sg_wrapper['theme_layout'] === null){
	$value = null;

	if(is_page()){
		$value = sg_opt('page_layout');
	}
	elseif(is_single()){
		$value = sg_opt('single_layout');
	}
	elseif(is_archive()){
		$value = sg_opt('archive_layout');
	}
	elseif(is_search()){
		$value = sg_opt('search_result_layout');
	}
	else{
		$value = sg_opt('blog_layout');
	}

	$sg_wrapper['theme_layout'] = ($value) ? $value : 'layout-side-right';
}


/*--- validate theme_section ---*/
if($sg_wrapper['theme_section'] === null){
	$sg_wrapper['theme_section'] = sg_opt('theme_section', true);
}


/*--- validate theme_container ---*/
if($sg_wrapper['theme_container'] === null){
	$sg_wrapper['theme_container'] = sg_opt('theme_container', true);
}


/*--- validate content_layout ---*/
if($sg_wrapper['content_layout'] === null){
	$value = null;

	if(is_single()){
		$value = 'full';
	}
	elseif(is_author()){
		$value = sg_opt('author_post_layout');
	}
	elseif(is_archive()){
		$value = sg_opt('archive_post_layout');
	}
	elseif(is_search()){
		$value = sg_opt('search_post_layout');
	}

	$sg_wrapper['content_layout'] = ($value) ? $value : sg_opt('blog_post_layout', 'full');
}




/*--- dunno ---*/

if(is_page() || get_post_type()!='post'){
	$sg_wrapper['content_base'] = apply_filters('sg_content_base', 'framework/templates/page');
	$sg_wrapper['content_layout'] = apply_filters('sg_content_layout', 'single');
}
else{
	$sg_wrapper['content_base'] = apply_filters('sg_content_base', 'framework/templates/blog');
	$sg_wrapper['content_layout'] = apply_filters('sg_content_layout', $sg_wrapper['content_layout']);
}


$sg_wrapper['theme_layout'] = apply_filters('sg_theme_layout', $sg_wrapper['theme_layout']);
$sg_wrapper['content_layout'] = apply_filters('sg_content_layout', $sg_wrapper['content_layout']);

do_action('add_debug_info', $sg_wrapper, '$sg_wrapper');




/*--- add body class ---*/
function sg_wrap_body_class($classes) {
	global $sg_wrapper;
	$temp = $sg_wrapper;

	if(!is_array($temp)){
		return $classes;
	}

	unset($temp['theme_section_class']);
	unset($temp['content_base']);

	foreach ($temp as $key => $value) {
		$class = SG_Util::slug($key, '-');

		if($value && is_string($value) && strlen($value) <= 20){
			$class .= '-'.SG_Util::slug($value, '-');
		}
		else{
			$class .= '-false';
		}

		$classes[] = $class;
	}

	return $classes;     
}

add_filter('body_class', 'sg_wrap_body_class');




/*
	check if we should load blank preview template or normal html template
*/

if(sg_val($_GET,'sg_preview')=='true'){
	do_action('add_debug_info', 'base-preview', 'base_template');

	// if loaded using url contain preview
	wp_dequeue_script('jquery');
	wp_deregister_script('jquery');
	add_filter('show_admin_bar', '__return_false');
	include('base-preview.php');
}
elseif(get_page_template_slug($sg_qid)){
	do_action('add_debug_info', 'base-template-slug', 'base_template');

	// if use select page template from wordpress
	include($sg_wrapper_file);
}
elseif(strpos($sg_wrapper['file'], get_stylesheet_directory()) === false){
	do_action('add_debug_info', 'base-plugin-file', 'base_template');

	// if have plugins controlled page
	include($sg_wrapper_file);
}
else{
	do_action('add_debug_info', 'base-content', 'base_template');

	get_header();
	include('base-content.php');
	get_footer();
}