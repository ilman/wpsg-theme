<?php 

echo ($sg_page_add_section) ? '<div class="'.trim('page-section '.$sg_page_section_class).'">' : '';
echo ($sg_page_add_container) ? '<div class="container">' : '';

// if(is_home() || is_front_page()){
// 	include(locate_template('subheader-choices.php'));
// }
// if(basename($sg_file_path)=='front-page.php'){}
if(basename($sg_file_path)=='front-page.php' || basename($sg_file_path)=='index.php' || basename($sg_file_path)=='404.php'){
	include($sg_file_path);
}
else{
	$sg_content_base = basename($sg_file_path,'.php');
	$sg_content_layout = '';
	include(locate_template('templates/'.$sg_page_layout.'.php'));
}
echo ($sg_page_add_container) ? '</div><!-- container -->' : '';
echo ($sg_page_add_section) ? '</div><!-- section -->' : '';