<?php 

use Scienceguard\SG_Util;

function sg_admin_theme_option(){

$prefix = ''; 

/*----options----*/

$option_body_layouts = array(
	array('label'=>'Full', 'value'=>'full'),
	array('label'=>'Boxed', 'value'=>'boxed'),
	array('label'=>'Boxed Padding', 'value'=>'boxed-padding'),
);

$option_blog_layouts = array(
	array('label'=>'Side None', 'value'=>'layout-full'),
	array('label'=>'Side Left', 'value'=>'layout-side-left'),
	array('label'=>'Side Right', 'value'=>'layout-side-right'),
	array('label'=>'Side Both', 'value'=>'layout-side-both'),
);

$option_blog_post_layouts = array(
	array('label'=>'Full', 'value'=>'full'),
	array('label'=>'Isotope', 'value'=>'isotope'),
	array('label'=>'Thumb Column', 'value'=>'thumb-column'),
	// array('label'=>'Thumb Left', 'value'=>'thumb-left'),
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
	array('label'=>'', 'value'=>''),
	array('label'=>'Normal', 'value'=>'normal'),
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
$option_font_sizes[] = array('label'=>'', 'value'=>'');
for($i=9; $i<72; $i++){
	$option_font_sizes[] = array('label'=>$i, 'value'=>$i);	
}

$option_color_sets = array();
$option_color_sets[] =array('label'=>'None', 'value'=>'');	
for($i=1; $i<=10; $i++){
	$option_color_sets[] = array('label'=>'Color Set '.$i, 'value'=>'color-set-'.$i);	
}

$option_separators = array(
	array('label'=>'None', 'value'=>''),
	array('label'=>'Bottom Line', 'value'=>'separator-line-bottom'),
	array('label'=>'Outer Triangle', 'value'=>'separator-triangle-out'),
	array('label'=>'Inner Triangle', 'value'=>'separator-triangle-in'),
	array('label'=>'Gradient', 'value'=>'separator-gradient'),
	array('label'=>'Inner Shadow', 'value'=>'separator-shadow-inner'),
	array('label'=>'Outer Shadow', 'value'=>'separator-shadow-outer')
);

$option_subheader_aligns = array(
	array('label'=>'Left', 'value'=>'align-left'),
	array('label'=>'Center', 'value'=>'align-center'),
	array('label'=>'Right', 'value'=>'align-right'),
	array('label'=>'Left &amp; Right', 'value'=>'align-left-right'),
);

$option_background_image_modes = array(
	array('label'=>'None', 'value'=>''),
	array('label'=>'Predefined', 'value'=>'predefined'),
	array('label'=>'Custom Upload', 'value'=>'custom')
);

$option_background_image_predefineds = array();
for($i=1; $i<=10; $i++){
	$option_background_image_predefineds[] = array('label'=>'Image 1'.$i, 'value'=>'image-'.$i);	
}

$option_background_image_positions = array(
	array('label'=>'', 'value'=>''),
	array('label'=>'left top', 'value'=>'left top'),
	array('label'=>'left center', 'value'=>'left center'),
	array('label'=>'left bottom', 'value'=>'left bottom'),
	array('label'=>'center top', 'value'=>'center top'),
	array('label'=>'center center', 'value'=>'center center'),
	array('label'=>'center bottom', 'value'=>'center bottom'),
	array('label'=>'right top', 'value'=>'right top'),
	array('label'=>'right center', 'value'=>'right center'),
	array('label'=>'right bottom', 'value'=>'right bottom'),
);

$option_background_image_attachments = array(
	array('label'=>'', 'value'=>''),
	array('label'=>'scroll', 'value'=>'scroll'),
	array('label'=>'fixed', 'value'=>'fixed'),
);

$option_background_image_repeats = array(
	array('label'=>'', 'value'=>''),
	array('label'=>'repeat', 'value'=>'repeat'),
	array('label'=>'repeat-x', 'value'=>'repeat-x'),
	array('label'=>'repeat-y', 'value'=>'repeat-y'),
	array('label'=>'no-repeat', 'value'=>'no-repeat'),
);

$option_background_image_sizes = array(
	array('label'=>'', 'value'=>''),
	array('label'=>'auto', 'value'=>'auto'),
	array('label'=>'cover', 'value'=>'cover'),
	array('label'=>'contain', 'value'=>'contain'),
);

$option_grid_layouts = array(
	array('label'=>'One Column (12)', 'value'=>'12'),
	array('label'=>'Two Columns (6 + 6)', 'value'=>'6-6'),
	array('label'=>'Two Columns (8 + 4)', 'value'=>'8-4'),
	array('label'=>'Two Columns (4 + 8)', 'value'=>'4-8'),
	array('label'=>'Three Columns (4 + 4 + 4)', 'value'=>'4-4-4'),
	array('label'=>'Three Columns (6 + 3 + 3)', 'value'=>'6-3-3'),
	array('label'=>'Three Columns (3 + 6 + 3)', 'value'=>'3-6-3'),
	array('label'=>'Three Columns (3 + 3 + 6)', 'value'=>'3-3-6'),
	array('label'=>'Four Columns (3 + 3 + 3 + 3)', 'value'=>'3-3-3-3'),
);

$option_select_images = array(
	array('label'=>'Image 1', 'value'=>'http://lorempixel.com/100/100/nature?1'),
	array('label'=>'Image 2', 'value'=>'http://lorempixel.com/100/100/nature?2'),
	array('label'=>'Image 3', 'value'=>'http://lorempixel.com/100/100/nature?3'),
	array('label'=>'Image 4', 'value'=>'http://lorempixel.com/100/100/nature?4'),
	array('label'=>'Image 5', 'value'=>'http://lorempixel.com/100/100/nature?5'),
);

$fields = array();















/*----general settings----*/
$fields[] = array(
	'label'		=> 'General Settings',
	'icon'		=> sg_asset_url('framework/sg_admin/assets/images/icons/setting_tools.png'),
	'type'		=> 'heading',
	'fields'	=> array(
		// array(
		// 	'label'		=> 'Logo',
		// 	'desc'		=> 'Enter/upload logo for your site themes',
		// 	'id'		=> 'logo',
		// 	'default'	=> sg_asset_url('front/assets/images/logo.png'),
		// 	'type'		=> 'upload'
		// ),
		// array(
		// 	'label'		=> 'Favicon',
		// 	'desc'		=> 'Enter/upload 16x16 favicon for your site themes',
		// 	'id'		=> 'favicon',
		// 	'default'	=> sg_asset_url('front/assets/images/favicon.png'),
		// 	'type'		=> 'upload'
		// ),
		array(  
			'label'		=> 'Add Section',
			'desc'		=> 'Add section wrapper in content',
			'id' 		=> 'theme_section',  
			'default'	=> 'true', 
			'type'		=> 'checkbox'
		),
		array(  
			'label'		=> 'Add Container',
			'desc'		=> 'Add container wrapper in content',
			'id' 		=> 'theme_container',  
			'default'	=> true, 
			'type'		=> 'checkbox'
		),
		array(  
			'label'		=> 'Show Breadrumbs',
			'desc'		=> 'Show breadcrumbs in content',
			'id' 		=> 'theme_breadcrumbs',  
			'default'	=> false, 
			'type'		=> 'checkbox'
		),
	)
);	




$fields[] = array(
	'label'		=> 'Form Settings',
	'icon'		=> sg_asset_url('framework/sg_admin/assets/images/icons/setting_tools.png'),
	'type'		=> 'heading',
	'fields'	=> array(
		array(  
			'label'		=> 'Office Form Shortcode',
			'desc'		=> 'Add content/shortcode on office post type',
			'id' 		=> 'office_form_shortcode',  
			'default'	=> '', 
			'type'		=> 'textarea',
			'sanitizer'		=> 'none',
			'attr'		=> array(
				'rows'		=> 4
			)
		),
		array(  
			'label'		=> 'EA Properties Form Shortcode',
			'desc'		=> 'Add content/shortcode on EA property details page',
			'id' 		=> 'ea_property_form_shortcode',  
			'default'	=> '', 
			'type'		=> 'textarea',
			'sanitizer'		=> 'none',
			'attr'		=> array(
				'rows'		=> 4
			)
		),
	)
);	


/*----expert agent settings----*/
$fields[] = array(
	'label'		=> 'Expert Agent Settings',
	'icon'		=> sg_asset_url('framework/sg_admin/assets/images/icons/house.png'),
	'type'		=> 'heading',
	'fields'	=> array(
		array(
			'label'		=> 'EA Search Result Page',
			'id'		=> 'ea_search_result_page',
			'type'		=> 'select',
			'options'	=> sg_get_post_list('page')
		),
		array(
			'label'		=> 'EA Search Investment Result Page',
			'id'		=> 'ea_search_investment_result_page',
			'type'		=> 'select',
			'options'	=> sg_get_post_list('page')
		),
		array(
			'label'		=> 'EA Property Details Page',
			'id'		=> 'ea_property_details_page',
			'type'		=> 'select',
			'options'	=> sg_get_post_list('page')
		),
		array(
			'label'		=> 'EA Investment Property Details Page',
			'id'		=> 'ea_investment_property_details_page',
			'type'		=> 'select',
			'options'	=> sg_get_post_list('page')
		),
	)
);	


/*----resales online settings----*/
$fields[] = array(
	'label'		=> 'Resales Online Settings',
	'icon'		=> sg_asset_url('framework/sg_admin/assets/images/icons/house.png'),
	'type'		=> 'heading',
	'fields'	=> array(
		array(
			'label'		=> 'Resales Online Search Result Page',
			'id'		=> 'resales_search_result_page',
			'type'		=> 'select',
			'options'	=> sg_get_post_list('page')
		),
		array(
			'label'		=> 'Resales Property Details Page',
			'id'		=> 'resales_property_details_page',
			'type'		=> 'select',
			'options'	=> sg_get_post_list('page')
		),
	)
);	






$option_footer_template = array_merge(array(array('label'=>'Default', 'value'=>'')), SG_WP::getPostList($type='sg_cpt_block'));	


/*----theme settings----*/
$fields[] = array(
	'label'		=> 'Template Settings',
	'icon'		=> sg_asset_url('framework/sg_admin/assets/images/icons/palette.png'),
	'type'		=> 'heading',
	'fields'	=> array(
		array(
			'label'		=> 'Footer Template',
			'desc'		=> 'Select either to use default footer template or your custom footer template',
			'id'		=> 'footer_template',
			'default'	=> '',
			'type'		=> 'select',
			'options'	=> $option_footer_template,
		),

		array(
			'label'		=> 'Footer Email Template',
			'desc'		=> 'Enter footer email template. Ex: Company VAT details',
			'id'		=> 'footer_email_template',
			'default'	=> '',
			'type'		=> 'textarea',
			'sanitizer'		=> 'none',
			'attr'		=> array(
				'rows'		=> 5
			)
		),
	)
);	









/*----pages settings----*/
$fields[] = array(
	'label'		=> 'Pages Settings',
	'icon'		=> sg_asset_url('framework/sg_admin/assets/images/icons/page.png'),
	'type'		=> 'heading',
	'fields'	=> array(
		/*----blog settings----*/
		array(
			'label'		=> 'Blog',
			'type'		=> 'heading',
			'fields'	=> array(
				array(
					'label'		=> 'Content',
					'type'		=> 'fieldset_open'
				),
				array (  
					'label'		=> 'Blog Layout',  
					'desc'		=> 'Select blog layout',  
					'id' 		=> 'blog_layout',  
					'default'	=> 'layout-side-right', 
					'type'		=> 'radio',  
					'options'	=> $option_blog_layouts
				),
				array(
					'label'		=> 'Blog Post Layout',
					'desc'		=> 'Select blog post layout',  
					'id' 		=> 'blog_post_layout',  
					'default'	=> 'isotope', 
					'type'		=> 'radio',  
					'options'	=> $option_blog_post_layouts
				),
				array(
					'label'		=> 'Blog Post Column',
					'desc'		=> 'Select blog post column',  
					'id' 		=> 'blog_post_column',  
					'default'	=> 3, 
					'type'		=> 'radio',  
					'options'	=> $option_columns
				),
				array(
					'type'		=> 'fieldset_close'
				),	
				array(
					'label'		=> 'Content Cut',
					'desc'		=> 'Cut content if exceed certains number of words',  
					'id' 		=> 'content_cut',  
					'default'	=> true, 
					'type'		=> 'checkbox'
				),
				array(
					'label'		=> 'Content Cut Limit',
					'desc'		=> 'Limit number of word before content get cut',  
					'id' 		=> 'content_cut_limit',  
					'default'	=> 12, 
					'type'		=> 'text'
				),
				array(
					'label'		=> 'Read More Text',
					'desc'		=> 'Text to add as suffix when the content get cut',  
					'id' 		=> 'read_more_text',  
					'default'	=> '&hellip; Read More', 
					'type'		=> 'text'
				),
				array(
					'label'		=> 'Pagination',
					'desc'		=> 'Select pagination type',  
					'id' 		=> 'pagination',  
					'default'	=> 'numbers', 
					'type'		=> 'radio',
					'options'	=> $option_paginations
				)
			)
		),
		/*----archive settings----*/
		array(
			'label'		=> 'Archive',
			'type'		=> 'heading',
			'fields'	=> array(
				array(
					'label'		=> 'Content',
					'type'		=> 'fieldset_open'
				),
				array (  
					'label'		=> 'Archive Layout',  
					'desc'		=> 'Select archive layout',  
					'id' 		=> 'archive_layout',  
					'default'	=> 'layout-full', 
					'type'		=> 'radio',  
					'options'	=> $option_blog_layouts
				),
				array(
					'label'		=> 'Archive Post Layout',
					'desc'		=> 'Select archive post layout',  
					'id' 		=> 'archive_post_layout',  
					'default'	=> 'isotope', 
					'type'		=> 'radio',  
					'options'	=> $option_blog_post_layouts
				),
				array(
					'label'		=> 'Archive Post Column',
					'desc'		=> 'Select archive post column',  
					'id' 		=> 'archive_post_column',  
					'default'	=> 3, 
					'type'		=> 'radio',  
					'options'	=> $option_columns
				),
				array(
					'type'		=> 'fieldset_close'
				),	
				array(
					'label'		=> 'Content Cut',
					'desc'		=> 'Cut content if exceed certains number of words',  
					'id' 		=> 'archive_content_cut',  
					'default'	=> true, 
					'type'		=> 'checkbox'
				),
				array(
					'label'		=> 'Content Cut Limit',
					'desc'		=> 'Limit number of word before content get cut',  
					'id' 		=> 'archive_content_cut_limit',  
					'default'	=> 12, 
					'type'		=> 'text'
				),
				array(
					'label'		=> 'Read More Text',
					'desc'		=> 'Text to add as suffix when the content get cut',  
					'id' 		=> 'archive_read_more_text',  
					'default'	=> '&hellip; Read More', 
					'type'		=> 'text'
				),
				array(
					'label'		=> 'Pagination',
					'desc'		=> 'Select pagination type',  
					'id' 		=> 'archive_pagination',  
					'default'	=> 'numbers', 
					'type'		=> 'radio',
					'options'	=> $option_paginations
				)
			)
		),
		/*----single post settings----*/
		array(
			'label'		=> 'Single Post',
			'type'		=> 'heading',
			'fields'	=> array(
				array(
					'label'		=> 'Content',
					'type'		=> 'fieldset_open'
				),
				array (  
					'label'		=> 'Page Layout',  
					'desc'		=> 'Select page layout',  
					'id' 		=> 'single_layout',  
					'default'	=> 'layout-full', 
					'type'		=> 'radio',  
					'options'	=> $option_blog_layouts
				),
				array(
					'type'		=> 'fieldset_close'
				),
			)
		),	
		/*----page settings----*/
		array(
			'label'		=> 'Page',
			'type'		=> 'heading',
			'fields'	=> array(
				array(
					'label'		=> 'Content',
					'type'		=> 'fieldset_open'
				),
				array (  
					'label'		=> 'Page Layout',  
					'desc'		=> 'Select blog layout',  
					'id' 		=> 'page_layout',  
					'default'	=> 'layout-full', 
					'type'		=> 'radio',  
					'options'	=> $option_blog_layouts
				),
				array(
					'type'		=> 'fieldset_close'
				),
			)
		),	
		/*----search result settings----*/
		array(
			'label'		=> 'Search Result',
			'type'		=> 'heading',
			'fields'	=> array(
				array (  
					'label'		=> 'Search Result Layout',  
					'desc'		=> 'Select layout',  
					'id' 		=> 'search_result_layout',  
					'default'	=> 'layout-full', 
					'type'		=> 'radio',  
					'options'	=> $option_blog_layouts
				),
				array(
					'label'		=> 'Pagination',
					'desc'		=> 'Select pagination type',  
					'id' 		=> 'search_result_pagination',  
					'default'	=> 'numbers', 
					'type'		=> 'radio',
					'options'	=> $option_paginations
				)
			)
		),	
	)
);

/*----social options----*/
$fields[] = array(
	'label'		=> 'Social Options',
	'icon'		=> sg_asset_url('framework/sg_admin/assets/images/icons/group.png'),
	'type'		=> 'heading'
);
	
$social_medias = array('Facebook','Twitter','Google Plus','Youtube','Instagram','LinkedIn');
$social_medias_url = array(
	'https://www.facebook.com/',
	'https://twitter.com/',
	'https://plus.google.com/',
	'http://www.youtube.com/',
	'http://www.instagram.com/',
	'http://www.linkedin.com/',
);
foreach($social_medias as $idx=>$social){
	$fields[] = array(
		'label'		=> $social,
		'desc'		=> 'Enter your '.$social.' url',
		'id'		=> SG_Util::slug($social.'_url','_'),
		'default'   => $social_medias_url[$idx],
		'type'		=> 'text'
	);
}

/*----custom script options----*/
$fields[] = array(
	'label'		=> 'Custom Scripts',
	'icon'		=> sg_asset_url('framework/sg_admin/assets/images/icons/script.png'),
	'type'		=> 'heading',
	'fields'	=> array(
		array(
			'label'		=> 'Scripts',
			'type'		=> 'fieldset',
			'fields'	=> array(
				array(
					'label'		=> 'Head Script',
					'desc'		=> 'Custom script to be added on inside head tag',  
					'id' 		=> 'script_head',
					'type'		=> 'textarea',
					'sanitizer'		=> 'none',
					'attr'		=> array(
						'rows'		=> 10
					)
				),
				array(
					'label'		=> 'Foot Script',
					'desc'		=> 'Custom script to be added on footer before body closing tag',  
					'id' 		=> 'script_foot',
					'type'		=> 'textarea',
					'sanitizer'		=> 'none',
					'attr'		=> array(
						'rows'		=> 10
					)
				),
			)
		),
		array(
			'label'		=> 'Styles',
			'type'		=> 'fieldset',
			'fields'	=> array(
				array(
					'label'		=> 'Style',
					'desc'		=> 'Custom script to be added on inside head tag',  
					'id' 		=> 'style_head',
					'type'		=> 'textarea',
					'sanitizer'		=> 'data',
					'attr'		=> array(
						'rows'		=> 10
					)
				),
			)
		)

		
	)
);

/*----custom script options----*/
$fields[] = array(
	'label'		=> 'Backup & Restore',
	'icon'		=> sg_asset_url('framework/sg_admin/assets/images/icons/database.png'),
	'type'		=> 'heading'
);

return $fields;

}

new sg_metaoption(array(
	'id'		=> SG_THEME_ID,
	'title'		=> 'Theme',
	'fields'	=> 'sg_admin_theme_option'
));


function sg_default_theme_option($old_theme_name, $old_theme='false'){
	 if(!get_option(SG_THEME_ID)){
	 	$theme_option = new sg_metaoption(array(
			'id'		=> SG_THEME_ID,
			'title'		=> '',
			'fields'	=> 'sg_admin_theme_option'
		));

	 	update_option(SG_THEME_ID, $theme_option->defaults());
	 }
}

add_action('after_switch_theme', 'sg_default_theme_option');