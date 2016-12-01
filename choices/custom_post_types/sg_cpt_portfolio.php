<?php 

function sg_cpt_portfolio() {
	register_post_type('sg_cpt_portfolio',
		array(
			'labels' => array(
				'name' => sg__('Portfolios'),
				'singular_name' => sg__('Portfolio')
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);
}
//add_action('init', 'sg_cpt_portfolio');


/*----metabox for custom post type----*/

require_once(TEMPLATEPATH.'/settings/helpers/admin_helper.php');



// Field Array
$prefix = '_test_'; //always use prefix _ for metabox

$sample_options = array (
			array (
				'label' => 'Option One',
				'value'	=> 'one'
			),
			array (
				'label' => 'Option Two',
				'value'	=> 'two'
			),
			array (
				'label' => 'Option Three',
				'value'	=> 'three'
			)
		);

$fields = array(
	array(
		'label'=> 'Heading 1',
		'type'	=> 'heading'
	),
	array(
		'label'		=> 'Text Input',
		'desc'		=> 'A description for the field.',
		'id'		=> $prefix.'text',
		'default'	=> 'test',
		//'repeat'	=> true,
		'type'		=> 'text'
	),
	array(
		'label'		=> 'Text Input',
		'desc'		=> 'A description for the field.',
		'id'		=> $prefix.'textasd',
		'default'	=> array('asd','zxc'),
		'repeat'	=> true,
		'type'		=> 'text'
	),
	array(
		'label'=> 'Textarea',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'textarea',
		'default'	=> 'test area',
		'type'	=> 'textarea'
	),
	array(
		'label'=> 'Heading 2',
		'type'	=> 'heading'
	),
	array(
		'label'=> 'Select Box',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'select',
		'default'	=> 'two',
		'type'	=> 'select',
		'options' => sg_get_post_list()
	),
	array(
		'label'=> 'Select Box 2',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'select2',
		'default'	=> 'two',
		'type'	=> 'select',
		'options' => sg_get_taxonomy_list()
	),
	array(
		'label'=> 'Info',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'info',
		'type'	=> 'info',
		'options' => $sample_options
	),
	array(
		'label'=> 'Font',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'font',
		'repeat'	=> true,
		'default' => array(
			array(
				'font_size' => '14px',
				'font_face' => 'verdana',
				'font_style' => 'italic',
				'font_color' => '#xxx'
			),
			array(
				'font_size' => '15px',
				'font_face' => 'verdana',
				'font_style' => 'bolc',
				'font_color' => '#eee'
			),
		),
		'type'	=> 'font'
	),
	array(
		'label'=> 'Border',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'border',
		'default' => array(
			'border_width' => '5px',
			'border_style' => 'dashed',
			'border_color' => '#zcxxvc'
		),
		'type'	=> 'border'
	),
	array (  
		'label' => 'Radio Group',  
		'desc'  => 'A description for the field.',  
		'id'    => $prefix.'radio',
		'default'	=> 'three', 
		//'repeat' => true, 
		'type'  => 'radio',  
		'options' => $sample_options
	),
	array (  
		'label' => 'Multicheckbox',  
		'desc'  => 'A description for the field.',  
		'id'    => $prefix.'multicheckbox', 
		'default'	=> 'two', 
		//'repeat' => true, 
		'type'  => 'multicheckbox',  
		'options' => $sample_options
	),
	array (  
		'label' => 'Select Images',  
		'desc'  => 'A description for the field.',  
		'id'    => $prefix.'selectimages',  
		'default'	=> 'three', 
		'repeat' => true, 
		'type'  => 'select_images',  
		'options' => $sample_options
	),
	array(  
		'label' => 'Slider',  
		'desc'  => 'A description for the field.',  
		'id'    => $prefix.'slider', 
		'default'	=> '40', 
		'repeat' => true, 
		'type'  => 'slider',  
		'min'   => '0',  
		'max'   => '100',  
		'step'  => '5'  
	),
	array(  
		'label' => 'Upload',  
		'desc'  => 'A description for the field.',  
		'id'    => $prefix.'upload', 
		'default'	=> 'http://placekitten.com/200/200', 
		'repeat' => true, 
		'type'  => 'upload'  
	),
	array(  
		'label' => 'Colorpicker',  
		'desc'  => 'A description for the field.',  
		'id'    => $prefix.'color', 
		'default'	=> '#ddd', 
		//'repeat' => true, 
		'type'  => 'color'  
	),
	array(  
		'label' => 'Carousel',  
		'desc'  => 'A description for the field.',  
		'id'    => $prefix.'carousel', 
		'default' => array(
			'carousel_media' => 'http://placekitten.com/200/200',
			'carousel_html' => 'dashed',
			'carousel_link' => '#zcxxvc'
		), 
		//'repeat' => true, 
		'type'  => 'carousel'  
	),
	array(  
		'label' => 'Background',  
		'desc'  => 'A description for the field.',  
		'id'    => $prefix.'background',  
		'default' => array(
			'bg_image' => 'http://placekitten.com/200/200',
			'bg_color' => '#zcxxvc',
			'bg_repeat' => 'no-repeat',
			'bg_pos_x' => 'left',
			'bg_pos_y' => 'top'
		),
		//'repeat' => true, 
		'type'  => 'background'  
	),
	
);

//$sg_cpt_mtb_portfolio = new sg_metabox('sg_cpt_mtb_portfolio', 'Portfolio Details', $fields, 'sg_cpt_portfolio', true );