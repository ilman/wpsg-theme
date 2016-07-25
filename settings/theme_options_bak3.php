<?php 

require_once locate_template('/settings/helpers/admin_helper.php');

function sg_admin_theme_option(){

$prefix = ''; 

/*----options----*/

$option_body_layouts = array(
	array('label'=>'full', 'value'=>'full'),
	array('label'=>'boxed', 'value'=>'boxed'),
	array('label'=>'boxed padding', 'value'=>'boxed-padding'),
);

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

$fields = array();
/*----general settings----*/
$fields[] = array(
	'label'		=> 'General Settings',
	'icon'		=> SG_THEME_URL.'/includes/sg_framework/assets/images/icons/setting_tools.png',
	'type'		=> 'heading',
	'fields'	=> array(
		array(
			'label'		=> 'Logo',
			'desc'		=> 'Enter/upload logo for your site themes',
			'id'		=> 'logo',
			'default'	=> get_template_directory_uri().'/assets/images/choices-logo.png',
			'type'		=> 'upload'
		),
		array(
			'label'		=> 'Favicon',
			'desc'		=> 'Enter/upload 16x16 favicon for your site themes',
			'id'		=> 'favicon',
			'default'	=> get_template_directory_uri().'/assets/images/favicon.ico',
			'type'		=> 'upload'
		),
		array(  
			'label'		=> 'Add Section',
			'desc'		=> 'Add section wrapper in content',
			'id' 		=> 'add_section',  
			'default'	=> 'true', 
			'type'		=> 'checkbox'
		),
		array(  
			'label'		=> 'Add Container',
			'desc'		=> 'Add container wrapper in content',
			'id' 		=> 'add_container',  
			'default'	=> 'true', 
			'type'		=> 'checkbox'
		),
	)
);	


/*----general settings----*/
$fields[] = array(
	'label'		=> 'Expert Agent Settings',
	'icon'		=> SG_THEME_URL.'/includes/sg_framework/assets/images/icons/house.png',
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


/*----general settings----*/
$fields[] = array(
	'label'		=> 'Resales Online Settings',
	'icon'		=> SG_THEME_URL.'/includes/sg_framework/assets/images/icons/house.png',
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

/*----font settings----*/
$fields[] = array(
	'label'		=> 'Font Settings',
	'icon'		=> SG_THEME_URL.'/includes/sg_framework/assets/images/icons/font.png',
	'type'		=> 'heading'
);
$font_set_params = array('','h1','h2','h3','h4','h5','h6');
$font_vars = array('Font Family','Font Style','Font Weight','Font Size','Line Height','Text Transform','Color');
$font_var_sets = array(
	'body' => array('Helvetica','normal','normal','13','21','normal','#333'),
	'heading_1' => array('Helvetica','normal','normal','26','34','none','#333'),
	'heading_2' => array('Helvetica','normal','normal','22','30','none','#333'),
	'heading_3' => array('Helvetica','normal','normal','18','26','none','#333'),
	'heading_4' => array('Helvetica','normal','normal','16','24','none','#333'),
	'heading_5' => array('Helvetica','normal','normal','14','22','none','#333'),
	'heading_6' => array('Helvetica','normal','normal','13','21','none','#333'),
);
$i=0;
foreach($font_var_sets as $set=>$set_val){
	$this_prefix = sg_util::slug($set,'_');
	$this_font_set = sg_util::val($font_set_params,$i);
	$preview_id = 'preview_'.sg_util::slug($set,'_');
	$preview_cb = "preview_font_set('".sg_util::slug($preview_id)."','".$this_font_set."')";
	
	$fields[] = array(
		'label'		=> ucwords(sg_util::slug($set,' ')),
		'type'		=> 'fieldset_open'
	);
	$fields[] = array(
		'id'		=> $preview_id,
		'type'		=> 'html_preview',
		'content'	=> array(
			'file'	=> 'font.php&param='.$this_font_set
		),
		'attr'		=> array(
			'onload'=> $preview_cb,
		)
	);
	$fields[] = array(
		'label'		=> 'Font Family',
		'id'		=> $this_prefix.'_font_family',
		'type'		=> 'select_font',
		'attr'		=> array(
			'onchange'=> $preview_cb,
		)
	);
	$fields[] = array(
		'label'		=> 'Font Style',
		'id'		=> $this_prefix.'_font_style',
		'type'		=> 'radio',
		'options'	=> $option_font_styles,
		'attr'		=> array(
			'onclick'=> $preview_cb,
		)
	);
	$fields[] = array(
		'label'		=> 'Font Weight',
		'id'		=> $this_prefix.'_font_weight',
		'type'		=> 'radio',
		'options'	=> $option_font_weights,
		'attr'		=> array(
			'onclick'=> $preview_cb,
		)
	);
	$fields[] = array(
		'label'		=> 'Font Size',
		'id'		=> $this_prefix.'_font_size',
		'type'		=> 'select',
		'options'	=> $option_font_sizes,
		'desc'		=> 'Font size in px',
		'attr'		=> array(
			'onchange'=> $preview_cb,
		)
	);
	$fields[] = array(
		'label'		=> 'Line Height',
		'id'		=> $this_prefix.'_line_height',
		'type'		=> 'select',
		'options'	=> $option_font_sizes,
		'desc'		=> 'Line height in px, normally the size is font_size + 8px',
		'attr'		=> array(
			'onchange'=> $preview_cb,
		)
	);
	$fields[] = array(
		'label'		=> 'Text Transform',
		'id'		=> $this_prefix.'_text_transform',
		'type'		=> 'select',
		'options'	=> $option_text_transforms,
		'attr'		=> array(
			'onchange'=> $preview_cb,
		)
	);
	$fields[] = array(
		'label'		=> 'Color',
		'id'		=> $this_prefix.'_color',
		'type'		=> 'color',
		'attr'		=> array(
			'onchange'=> $preview_cb,
		)
	);
	$fields[] = array(
		'type'		=> 'fieldset_close'
	);
$i++;
}

/*----layout settings----*/
$fields[] = array(
	'label'		=> 'Layout Settings',
	'icon'		=> SG_THEME_URL.'/includes/sg_framework/assets/images/icons/layout.png',
	'type'		=> 'heading',
	'fields'	=> array(
		array(
			'label'		=> 'Body',
			'type'		=> 'heading',
			'fields'	=> array(
				array (  
					'label'		=> 'Body Layout',
					'id' 		=> 'body_layout',  
					'default'	=> 'full', 
					'type'		=> 'radio',  
					'options'	=> $option_body_layouts
				),
				array (  
					'label'		=> 'Background Color',
					'id' 		=> 'body_background_color',
					'type'		=> 'color',
				),
				array (  
					'label'		=> 'Background Image',
					'id' 		=> 'body_background_image',
					'default'	=> '',  
					'type'		=> 'radio',
					'trigger'	=> true,
					'options'	=> $option_background_image_modes
				),
				array(
					'label'		=> 'Predefined Background',
					'type'		=> 'fieldset',
					'binding'	=> array(
						'trigger'	=> 'body_background_image',
						'value'		=> 'predefined'
					),
					'fields'	=> array(
						array (  
							'label'		=> 'Background Image',
							'id' 		=> 'body_background_image_predefined',  
							'type'		=> 'select_image',
							'options'	=> $option_background_image_predefineds
						),
					)
				),
				array(
					'label'		=> 'Custom Background',
					'type'		=> 'fieldset',
					'binding'	=> array(
						'trigger'	=> 'body_background_image',
						'value'		=> 'custom'
					),
					'fields'	=> array(
						array (  
							'label'		=> 'Background Image',
							'id' 		=> 'body_background_image_url',  
							'type'		=> 'upload'
						),
						array (  
							'label'		=> 'Background Position',
							'id' 		=> 'body_background_image_position',  
							'type'		=> 'select',
							'options'	=> $option_background_image_positions
						),
						array (  
							'label'		=> 'Background Attachment',
							'id' 		=> 'body_background_image_attachment',  
							'type'		=> 'select',
							'options'	=> $option_background_image_attachments
						),
						array (  
							'label'		=> 'Background Repeat',
							'id' 		=> 'body_background_image_repeat',  
							'type'		=> 'select',
							'options'	=> $option_background_image_repeats
						),
						array (  
							'label'		=> 'Background Size',
							'id' 		=> 'body_background_image_size',  
							'type'		=> 'select',
							'options'	=> $option_background_image_sizes
						),
					)
				)

			)
		),
		array(
			'label'		=> 'Header',
			'type'		=> 'heading',
			'fields'	=> array(
				array (  
					'label'		=> 'Fixed Position',
					'id' 		=> 'header_position_fixed',  
					'default'	=> true, 
					'type'		=> 'checkbox',
				),
				array (  
					'label'		=> 'Color Set',
					'id' 		=> 'header_color_set',
					'type'		=> 'select',  
					'options'	=> $option_color_sets
				),
				array (  
					'label'		=> 'Separator',
					'id' 		=> 'header_separator', 
					'type'		=> 'select',  
					'options'	=> $option_separators
				),
				array (  
					'label'		=> 'Extra Class',
					'id' 		=> 'header_extra_class', 
					'type'		=> 'text'
				),
				array (  
					'label'		=> 'Header Height',
					'id' 		=> 'header_height', 
					'type'		=> 'text'
				),
				array (  
					'label'		=> 'Header Padding Top',
					'id' 		=> 'header_padding_top', 
					'type'		=> 'text',
				),
				array (  
					'label'		=> 'Header Padding Bottom',
					'id' 		=> 'Header_padding_bottom', 
					'type'		=> 'text',
				),
				array (  
					'label'		=> 'Header Align',
					'id' 		=> 'header_align',  
					'default'	=> 'center', 
					'type'		=> 'radio',
					'options'	=> $option_subheader_aligns
				),
			)
		),
		array(
			'label'		=> 'Content',
			'type'		=> 'heading',
			'fields'	=> array(
				array (  
					'label'		=> 'Separator',
					'id' 		=> 'content_separator', 
					'type'		=> 'select',  
					'options'	=> $option_separators
				),
				array (  
					'label'		=> 'Extra Class',
					'id' 		=> 'content_extra_class', 
					'type'		=> 'text'
				),
				array (  
					'label'		=> 'Background Image',
					'id' 		=> 'content_background_image',
					'default'	=> '',  
					'type'		=> 'radio',
					'trigger'	=> true,
					'options'	=> $option_background_image_modes
				),
				array(
					'label'		=> 'Predefined Background',
					'type'		=> 'fieldset',
					'binding'	=> array(
						'trigger'	=> 'content_background_image',
						'value'		=> 'predefined'
					),
					'fields'	=> array(
						array (  
							'label'		=> 'Background Image',
							'id' 		=> 'content_background_image_predefined',  
							'type'		=> 'select_image',
							'options'	=> $option_background_image_predefineds
						),
					)
				),
				array(
					'label'		=> 'Custom Background',
					'type'		=> 'fieldset',
					'binding'	=> array(
						'trigger'	=> 'content_background_image',
						'value'		=> 'custom'
					),
					'fields'	=> array(
						array (  
							'label'		=> 'Background Image',
							'id' 		=> 'content_background_image_url',  
							'type'		=> 'upload'
						),
						array (  
							'label'		=> 'Background Position',
							'id' 		=> 'content_background_image_position',  
							'type'		=> 'select',
							'options'	=> $option_background_image_positions
						),
						array (  
							'label'		=> 'Background Attachment',
							'id' 		=> 'content_background_image_attachment',  
							'type'		=> 'select',
							'options'	=> $option_background_image_attachments
						),
						array (  
							'label'		=> 'Background Repeat',
							'id' 		=> 'content_background_image_repeat',  
							'type'		=> 'select',
							'options'	=> $option_background_image_repeats
						),
						array (  
							'label'		=> 'Background Size',
							'id' 		=> 'content_background_image_size',  
							'type'		=> 'select',
							'options'	=> $option_background_image_sizes
						),
					)
				)
			)
		),
		array(
			'label'		=> 'Footer',
			'type'		=> 'heading',
			'fields'	=> array(
				array (  
					'label'		=> 'Color Set',
					'id' 		=> 'footer_color_set', 
					'type'		=> 'select',  
					'options'	=> $option_color_sets
				),
				array (  
					'label'		=> 'Separator',
					'id' 		=> 'footer_separator', 
					'type'		=> 'select',  
					'options'	=> $option_separators
				),
				array (  
					'label'		=> 'Extra Class',
					'id' 		=> 'footer_extra_class', 
					'type'		=> 'text'
				),
				array (  
					'label'		=> 'Footer Padding Top',
					'id' 		=> 'footer_padding_top', 
					'type'		=> 'text',
				),
				array (  
					'label'		=> 'Footer Padding Bottom',
					'id' 		=> 'footer_padding_bottom', 
					'type'		=> 'text',
				),
				array (  
					'label'		=> 'Background Image',
					'id' 		=> 'footer_background_image',
					'default'	=> '',  
					'type'		=> 'radio',
					'trigger'	=> true,
					'options'	=> $option_background_image_modes
				),
				array(
					'label'		=> 'Predefined Background',
					'type'		=> 'fieldset',
					'binding'	=> array(
						'trigger'	=> 'footer_background_image',
						'value'		=> 'predefined'
					),
					'fields'	=> array(
						array (  
							'label'		=> 'Background Image',
							'id' 		=> 'footer_background_image_predefined',  
							'type'		=> 'select_image',
							'options'	=> $option_background_image_predefineds
						),
					)
				),
				array(
					'label'		=> 'Custom Background',
					'type'		=> 'fieldset',
					'binding'	=> array(
						'trigger'	=> 'footer_background_image',
						'value'		=> 'custom'
					),
					'fields'	=> array(
						array (  
							'label'		=> 'Background Image',
							'id' 		=> 'footer_background_image_url',  
							'type'		=> 'upload'
						),
						array (  
							'label'		=> 'Background Position',
							'id' 		=> 'footer_background_image_position',  
							'type'		=> 'select',
							'options'	=> $option_background_image_positions
						),
						array (  
							'label'		=> 'Background Attachment',
							'id' 		=> 'footer_background_image_attachment',  
							'type'		=> 'select',
							'options'	=> $option_background_image_attachments
						),
						array (  
							'label'		=> 'Background Repeat',
							'id' 		=> 'footer_background_image_repeat',  
							'type'		=> 'select',
							'options'	=> $option_background_image_repeats
						),
						array (  
							'label'		=> 'Background Size',
							'id' 		=> 'footer_background_image_size',  
							'type'		=> 'select',
							'options'	=> $option_background_image_sizes
						),
					)
				)
			)
		),
	)		
);

/*----pages settings----*/
$fields[] = array(
	'label'		=> 'Pages Settings',
	'icon'		=> SG_THEME_URL.'/includes/sg_framework/assets/images/icons/page.png',
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
					'default'	=> 'thumb-column', 
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
					'default'	=> 80, 
					'type'		=> 'text'
				),
				array(
					'label'		=> 'Read More Text',
					'desc'		=> 'Text to add as suffix when the content get cut',  
					'id' 		=> 'read_more_text',  
					'default'	=> '&hellip;Read More', 
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
					'default'	=> 'layout-side-none', 
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
					'default'	=> 'layout-side-none', 
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
	'icon'		=> SG_THEME_URL.'/includes/sg_framework/assets/images/icons/group.png',
	'type'		=> 'heading'
);
	
$social_medias = array('Facebook','Twitter','Google+','Youtube','Vimeo','Pinterest','LinkedIn');
foreach($social_medias as $social){
	$fields[] = array(
		'label'		=> $social,
		'desc'		=> 'Enter your '.$social.' url',
		'id'		=> sg_util::slug($social.'_url','_'),
		'type'		=> 'text'
	);
}

/*----custom script options----*/
$fields[] = array(
	'label'		=> 'Custom Scripts',
	'icon'		=> SG_THEME_URL.'/includes/sg_framework/assets/images/icons/script.png',
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
	'icon'		=> SG_THEME_URL.'/includes/sg_framework/assets/images/icons/database.png',
	'type'		=> 'heading'
);

return $fields;

}

new sg_metaoption(array(
	'id'		=> 'wpsg_choices',
	'title'		=> 'Choices Theme',
	'fields'	=> 'sg_admin_theme_option'
));