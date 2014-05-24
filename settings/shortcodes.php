<?php 

function sg_admin_shortcode_asd(){


/*----options----*/
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

$option_col_widths = array();
for($i=1; $i<=12; $i++){
	$option_col_widths[] = array('label'=>$i, 'value'=>$i);	
}

$option_block_layouts = array(
	array('label'=>'Thumb Top', 'value'=>'thumb-top'),
	array('label'=>'Thumb Left', 'value'=>'thumb-left'),
	array('label'=>'Thumb Right', 'value'=>'thumb-right'),
);

$option_align_horizontals = array(
	array('label'=>'Left', 'value'=>'left'),
	array('label'=>'Center', 'value'=>'center'),
	array('label'=>'Right', 'value'=>'right'),
);

$option_color_classes = array(
	array('label'=>'Default', 'value'=>'default'),
	array('label'=>'Primary', 'value'=>'primary'),
	array('label'=>'Success', 'value'=>'success'),
	array('label'=>'Danger', 'value'=>'danger'),
	array('label'=>'Warning', 'value'=>'warning'),
	array('label'=>'Info', 'value'=>'info'),
);

$nl = '<br />';
$dummy_content_inline = 'Put content here...';
$dummy_content_block = $nl.$dummy_content_inline.$nl;

/*----fields-----*/
$fields = array();

$fields = array(
	/*----layout shortcode----*/
	array(
		'label'		=> 'Layouts',
		'type'		=> 'heading',
		'fields'	=> array(
			array(
				'label'		=> 'Section',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_section {param}]'.$dummy_content_block.'[/sg_section]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Color Set',
						'id'		=> 'color_set',
						'type'		=> 'select',
						'options'	=> $option_color_sets
					),
					array(
						'label'		=> 'Separator',
						'id'		=> 'separator',
						'type'		=> 'select',
						'options'	=> $option_separators
					),
					array(
						'label'		=> 'Use Wrapper',
						'id'		=> 'wrapper',
						'default'	=> false,
						'type'		=> 'checkbox',
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Row',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_row {param}]'.$nl.'[sg_col width="12"]'.$dummy_content_block.'[/sg_col]'.$nl.'[/sg_row]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Columns',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_column {param}]'.$dummy_content_block.'[/sg_column]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Width',
						'id'		=> 'color_set',
						'type'		=> 'select',
						'options'	=> $option_col_widths
					),
					array(
						'label'		=> 'Offset',
						'id'		=> 'separator',
						'type'		=> 'select',
						'options'	=> $option_col_widths
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Spacer',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> $nl.'[sg_spacer {param}]'.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Padding Top',
						'id'		=> 'padding_top',
						'type'		=> 'text',
					),
					array(
						'label'		=> 'Padding Bottom',
						'id'		=> 'padding_bottom',
						'type'		=> 'text',
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),		

		)
	),

	/*----divider shortcode----*/
	array(
		'label'		=> 'Dividers',
		'type'		=> 'heading',
		'fields'	=> array(
			array(
				'label'		=> 'Divider',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> $nl.'[sg_divider {param}]'.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Style',
						'id'		=> 'style',
						'type'		=> 'select',
						'options'	=> $option_color_sets
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Divider Icon',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> $nl.'[sg_divider_icon {param}]'.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Style',
						'id'		=> 'style',
						'type'		=> 'select',
						'options'	=> $option_color_sets
					),
					array(
						'label'		=> 'Icon',
						'id'		=> 'icon',
						'type'		=> 'select',
						'options'	=> $option_color_sets
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),	
			array(
				'label'		=> 'Divider Text',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> $nl.'[sg_divider_text {param}]'.$dummy_content_inline.'[/sg_divider_text]'.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Style',
						'id'		=> 'style',
						'type'		=> 'select',
						'options'	=> $option_color_sets
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
		)
	),

	/*----block shortcode----*/
	array(
		'label'		=> 'Blocks',
		'type'		=> 'heading',
		'fields'	=> array(
			
			array(
				'label'		=> 'Block',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_block {param}]'.$nl.'[sg_block_thumb]'.$dummy_content_block.'[/sg_block_thumb]'.$nl.'[sg_block_content]'.$dummy_content_block.'[/sg_block_content][/sg_block]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Layout',
						'id'		=> 'layout',
						'type'		=> 'select',
						'options'	=> $option_block_layouts
					),
					array(
						'label'		=> 'Align',
						'id'		=> 'align',
						'type'		=> 'select',
						'options'	=> $option_align_horizontals
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Block Icon',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_block_icon {param}]'.$dummy_content_block.'[/sg_block_image]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Layout',
						'id'		=> 'layout',
						'type'		=> 'select',
						'options'	=> $option_block_layouts
					),
					array(
						'label'		=> 'Align',
						'id'		=> 'align',
						'type'		=> 'select',
						'options'	=> $option_align_horizontals
					),
					array(
						'label'		=> 'Icon',
						'id'		=> 'icon',
						'type'		=> 'select2',
						'options'	=> $option_align_horizontals
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Block Image',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_block_image {param}]'.$dummy_content_block.'[/sg_block_image]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Layout',
						'id'		=> 'layout',
						'type'		=> 'select',
						'options'	=> $option_block_layouts
					),
					array(
						'label'		=> 'Align',
						'id'		=> 'align',
						'type'		=> 'select',
						'options'	=> $option_align_horizontals
					),
					array(
						'label'		=> 'Image',
						'id'		=> 'image',
						'type'		=> 'upload'
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Block Testimonial',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_block_testi {param}]'.$dummy_content_block.'[/sg_block_testi]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Layout',
						'id'		=> 'layout',
						'type'		=> 'select',
						'options'	=> $option_block_layouts
					),
					array(
						'label'		=> 'Align',
						'id'		=> 'align',
						'type'		=> 'select',
						'options'	=> $option_align_horizontals
					),
					array(
						'label'		=> 'Image',
						'id'		=> 'image',
						'type'		=> 'upload'
					),
					array(
						'label'		=> 'Name',
						'id'		=> 'name',
						'default'	=> 'author_name',
						'type'		=> 'text'
					),
					array(
						'label'		=> 'Title',
						'id'		=> 'title',
						'default'	=> 'author_title',
						'type'		=> 'text'
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),

		)
	),
	
	/*----component shortcode----*/
	array(
		'label'		=> 'Components',
		'type'		=> 'heading',
		'fields'	=> array(
			array(
				'label'		=> 'Tabs',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_tabs {param}]'.$nl.'[sg_tab_content title="Tab Content Title" active="true"]'.$dummy_content_block.'[/sg_tab_content]'.$nl.'[/sg_tabs]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Tab Content',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_tab_content {param}]'.$dummy_content_block.'[/sg_tab_content]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Title',
						'id'		=> 'title',
						'default'	=> 'Tab Content Title',
						'type'		=> 'text',
					),
					array(
						'label'		=> 'Active Tab',
						'id'		=> 'active',
						'type'		=> 'checkbox',
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Collapse/Accordion',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_collapse {param}]'.$nl.'[sg_collapse_content title="Tab Content Title" active="true"]'.$dummy_content_block.'[/sg_collapse_content]'.$nl.'[/sg_collapse]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Collapse/Accordion Content',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_collapse_content {param}]'.$dummy_content_block.'[/sg_collapse_content]'.$nl.$nl,
				),
				'fields'	=> array(
					array(
						'label'		=> 'Title',
						'id'		=> 'title',
						'default'	=> 'Accordion Content Title',
						'type'		=> 'text',
					),
					array(
						'label'		=> 'Active Tab',
						'id'		=> 'active',
						'type'		=> 'checkbox',
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),

		)
	),
	
	/*----style shortcode----*/
	array(
		'label'		=> 'Misc',
		'type'		=> 'heading',
		'fields'	=> array(
			
			array(
				'label'		=> 'Button',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_button {param}]Button Text[/sg_button]',
				),
				'fields'	=> array(
					array(
						'label'		=> 'Color Class',
						'id'		=> 'color',
						'type'		=> 'select',
						'options'	=> $option_color_classes
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Dropcap',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_dropcap {param}]Button Text[/sg_dropcap]',	
				),
				'fields'	=> array(
					array(
						'label'		=> 'Style',
						'id'		=> 'style',
						'type'		=> 'select',
						'options'	=> $option_color_classes
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'List Icon',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_list_icon {param}]'.$nl.'[sg_list_item {param_item}]'.$dummy_content_inline.'[/sg_list_item]'.$nl.'[/sg_list_icon]'.$nl.$nl,	
				),
				'fields'	=> array(
					array(
						'label'		=> 'icon',
						'id'		=> 'icon',
						'type'		=> 'select',
						'attr'		=> array(
							'data-param'	=> '{param_item}',
						),
						'options'	=> $option_color_classes
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'List Icon Item',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_list_item {param}]'.$dummy_content_inline.'[/sg_list_item]'.$nl,	
				),
				'fields'	=> array(
					array(
						'label'		=> 'icon',
						'id'		=> 'icon',
						'type'		=> 'select',
						'options'	=> $option_color_classes
					),
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Div',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_div {param}]'.$dummy_content_block.'[/sg_div]'.$nl,	
				),
				'fields'	=> array(
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),
			array(
				'label'		=> 'Span',
				'type'		=> 'heading',
				'attr'		=> array(
					'data-code'	=> '[sg_span {param}]'.$dummy_content_inline.'[/sg_span]',	
				),
				'fields'	=> array(
					array(
						'label'		=> 'Extra Class',
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'type'		=> 'button_insert'
					),
				)
			),

		)
	),
	
);

return $fields;
}

new sg_metashortcode(array(
	'name'			=> 'sg_test_mce',
	'modal_title'	=> 'test modal title',
	'button_title'	=> 'test button title mce1',
	'button_icon'	=> 'http://localhost/wp-dev/wpsg/wp-content/plugins/mtphr-shortcodes/assets/images/mtphr-shortcodes-icon.png',
	'fields'		=> 'sg_admin_shortcode_asd'
));
