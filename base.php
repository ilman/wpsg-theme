<?php 

$sg_file_path = sg_wrapper_template_path();
$sg_page_layout = sg_opt('blog_layout');
$sg_content_layout = (is_single()) ? 'full' : sg_opt('blog_post_layout');
$sg_content_container = false;

if(is_page()){
	$sg_content_base = apply_filters('sg_content_base', 'templates/page');
	$sg_content_layout = apply_filters('sg_content_layout', 'single');
}
else{
	$sg_content_base = apply_filters('sg_content_base', 'templates/blog');
	$sg_content_layout = apply_filters('sg_content_layout', $sg_content_layout);
}

$test = array(
	'sg_file_path' => $sg_file_path,
	'sg_content_base' => $sg_content_base,
	'sg_content_baselayout' => $sg_content_layout,
);


// check if we should load blank preview template or normal html template
if(sg_val($_GET,'preview')=='true'){
	wp_dequeue_script('jquery');
	wp_deregister_script('jquery');
	add_filter('show_admin_bar', '__return_false');
	include('base-preview.php');
}
else{
	get_header();
	echo ($sg_content_container) ? '<div class="container">' : '';
	if(basename($sg_file_path)=='front-page.php'){
		get_template_part('/templates/page/header-home');
		include($sg_file_path);
	}
	else{
		include($sg_file_path);
	}
	echo ($sg_content_container) ? '</div><!-- container -->' : '';
	get_footer();
}