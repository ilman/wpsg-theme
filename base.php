<?php 

$sg_qid = get_queried_object_id();
$sg_page_layout = get_post_meta($sg_qid, '_sg_mb_page_layout', true);
if(!$sg_page_layout){
	$sg_page_layout = sg_opt('blog_layout');
}

$sg_page_add_section = get_post_meta($sg_qid, '_sg_mb_page_add_section', true);
$sg_page_section_class = get_post_meta($sg_qid, '_sg_mb_page_section_class', true);
if(!$sg_page_add_section){
	$sg_page_add_section = sg_opt('add_section');
}

$sg_page_add_container = get_post_meta($sg_qid, '_sg_mb_page_add_container', true);
if(!$sg_page_add_container){
	$sg_page_add_container = sg_opt('add_container');
}

$sg_file_path = sg_wrapper_template_path();
$sg_content_layout = (is_single()) ? 'full' : sg_opt('blog_post_layout');
$sg_content_container = true;

if(is_page() || get_post_type()!='post'){
	$sg_content_base = apply_filters('sg_content_base', 'templates/page');
	$sg_content_layout = apply_filters('sg_content_layout', 'single');
}
else{
	$sg_content_base = apply_filters('sg_content_base', 'templates/blog');
	$sg_content_layout = apply_filters('sg_content_layout', $sg_content_layout);
}

//test only
$test = array(
	'sg_file_path' => $sg_file_path,
	'sg_content_base' => $sg_content_base,
	'sg_content_layout' => $sg_content_layout,
	'sg_page_layout' => $sg_page_layout,
);

// check if we should load blank preview template or normal html template
if(sg_val($_GET,'preview')=='true'){
	wp_dequeue_script('jquery');
	wp_deregister_script('jquery');
	add_filter('show_admin_bar', '__return_false');
	include('base-preview.php');
}
elseif(get_page_template_slug($sg_qid)){
	include($sg_file_path);
}
else{
	get_header();
	include('base-content.php');
	get_footer();
}