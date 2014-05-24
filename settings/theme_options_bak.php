<?php 

include(SG_THEME_PATH.'/includes/libraries/sg_theme_options.php');

$prefix = ''; 

/*----options----*/

$option_blog_layouts = array(
	array('label'=>'side none', 'value'=>'layout-side-none'),
	array('label'=>'side left', 'value'=>'layout-side-left'),
	array('label'=>'side right', 'value'=>'layout-side-right'),
	array('label'=>'side both', 'value'=>'layout-side-both'),
);

$option_blog_post_layouts = array(
	array('label'=>'full', 'value'=>'full'),
	array('label'=>'isotope', 'value'=>'isotope'),
	array('label'=>'thumb-column', 'value'=>'thumb-column'),
	array('label'=>'thumb-left', 'value'=>'thumb-left'),
);

$option_paginations = array(
	array('label'=>'Prev / Next', 'value'=>'prev_next'),
	array('label'=>'Numbers Pagination', 'value'=>'numbers'),
	array('label'=>'Load More', 'value'=>'load_more'),
);

$option_columns = array(
	array('label'=>'2 Columns', 'value'=>2),
	array('label'=>'3 Columns', 'value'=>3),
	array('label'=>'4 Columns', 'value'=>4),
);

$option_text_transforms = array(
	array('label'=>'Normal', 'value'=>'none'),
	array('label'=>'Capitalize', 'value'=>'capitalize'),
	array('label'=>'Uppercase', 'value'=>'uppercase'),
	array('label'=>'Lowercase', 'value'=>'lowercase'),
);

$option_font_weights = array(
	array('label'=>'Normal', 'value'=>'normal'),
	array('label'=>'Bold', 'value'=>'bold'),
);

$option_font_styles = array(
	array('label'=>'Normal', 'value'=>'normal'),
	array('label'=>'Italic', 'value'=>'italic'),
);

$option_font_sizes = array();
for($i=9; $i<72; $i++){
	$option_font_sizes[] = array('label'=>$i, 'value'=>$i);	
}


/*----social options----*/
$social_medias = array('Facebook','Twitter','Google+','Youtube');
$social_media_field = array();
foreach($social_medias as $social){
	$social_media_field[] = array(
		'label'		=> $social,
		'desc'		=> 'Enter your '.$social.' url',
		'id'		=> sg_form::slug($social.'_url','_'),
		'type'		=> 'text'
	);
}



$fields = array();
/*----general settings----*/
$fields[] = array(
	'label'		=> 'Site',
	'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
	'type'		=> 'heading',
);


/*----layout settings----*/
$fields[] = array(
	'label'		=> 'Layout',
	'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
	'type'		=> 'heading',
	'fields'	=> array(
		array(
			'label'		=> 'Body',
			'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
			'type'		=> 'heading',
			'fields'	=> array(
				array (  
					'label'		=> 'Blog Layout',  
					'desc'		=> 'Select blog layout',  
					'id' 		=> 'test_chosen',  
					'default'	=> 'layout-side-right', 
					'type'		=> 'select_font',  
					'options'	=> $option_font_sizes
				)
			)
		),
		array(
			'label'		=> 'Promo Bar',
			'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
			'type'		=> 'heading',
			'fields'	=> array(
				array(
					'label'		=> 'Test Section',
					'type'		=> 'section',
					'fields'	=> $social_media_field
				),
			)
		),		
		array(
			'label'		=> 'Top Header',
			'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
			'type'		=> 'heading',
			'fields'	=> $social_media_field
		),
		array(
			'label'		=> 'Header',
			'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
			'type'		=> 'heading',
			'fields'	=> $social_media_field
		),
		array(
			'label'		=> 'Sub Header',
			'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
			'type'		=> 'heading',
			'fields'	=> $social_media_field
		),
		array(
			'label'		=> 'Content',
			'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
			'type'		=> 'heading',
			'fields'	=> $social_media_field
		),
		array(
			'label'		=> 'Footer',
			'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
			'type'		=> 'heading',
			'fields'	=> $social_media_field
		),
		array(
			'label'		=> 'Bottom Footer',
			'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/setting_tools.png',
			'type'		=> 'heading',
			'fields'	=> $social_media_field
		),
	)		
);


/*----blog settings----*/
$fields[] = array(
	'label'		=> 'Blog Settings',
	'icon'		=> SG_THEME_URL.'/includes/assets/images/icons/layout.png',
	'type'		=> 'heading'
);
$fields[] = array (  
	'label'		=> 'Blog Layout',  
	'desc'		=> 'Select blog layout',  
	'id' 		=> 'blog_layout',  
	'default'	=> 'layout-side-right', 
	'type'		=> 'radio',  
	'options'	=> $option_blog_layouts
);


$sample_box = new sg_theme_options( 'sample_box', 'Sample Box', $fields, 'post', true );