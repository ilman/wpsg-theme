<?php 

echo ($sg_wrapper['theme_section']) ? '<div class="'.trim('page-section '.$sg_wrapper['theme_section_class']).'">' : '';
echo ($sg_wrapper['theme_container']) ? '<div class="container">' : '';

// if(is_home() || is_front_page()){
// 	include(locate_template('subheader.php'));
// }
// if(basename($sg_wrapper_file)=='front-page.php'){}
// 
if(basename($sg_wrapper_file)=='front-page.php' || basename($sg_wrapper_file)=='index.php' || basename($sg_wrapper_file)=='404.php'){
	include($sg_wrapper_file);
}
else{
	$sg_wrapper['content_base'] = str_replace(get_stylesheet_directory(), '', $sg_wrapper_file);
	$sg_wrapper['content_base'] = str_replace('.php', '', $sg_wrapper['content_base']);
	$sg_wrapper['content_base'] = trim($sg_wrapper['content_base'], '/');
	$sg_wrapper['content_layout'] = '';
	include(locate_template('framework/templates/'.$sg_wrapper['theme_layout'].'.php'));
}
echo ($sg_wrapper['theme_container']) ? '</div><!-- container -->' : '';
echo ($sg_wrapper['theme_section']) ? '</div><!-- section -->' : '';