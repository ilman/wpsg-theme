<?php 

function sg_cpt_property() {
	register_post_type('sg_cpt_property',
		array(
			'labels' => array(
				'name' => sg__('Properties'),
				'singular_name' => sg__('Property')
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);
}
add_action('init', 'sg_cpt_property');


/*----metabox for custom post type----*/

require_once(TEMPLATEPATH.'/settings/helpers/admin_helper.php');



// Field Array
$prefix = '_sg_property_'; //always use prefix _ for metabox

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
		'type'		=> 'text'
	),
	
);

//$sg_cpt_mtb_property = new sg_metabox('sg_cpt_mtb_property', 'Property Details', $fields, 'sg_cpt_property', true );