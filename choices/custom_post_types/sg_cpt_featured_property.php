<?php 

function sg_cpt_featured_property() {
	register_post_type('sg_cpt_featured_prop',
		array(
			'labels' => array(
				'name' => __('Properties', SG_THEME_ID),
				'singular_name' => __('Property', SG_THEME_ID)
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);

	if(function_exists('add_image_size')){ 
		add_image_size('property_square', 150, 150, true);
		add_image_size('property_thumb', 250, 150, true);
	}
}
add_action('init', 'sg_cpt_featured_property');


/*----metabox for custom post type----*/

function sg_cpt_mb_featured_property(){

	$prefix = '_sg_mb_featured_property_'; //always use prefix _ for metabox

	/*----options----*/

	

	/*----fields----*/

	$fields = array(
		
		array(
			'label'		=> 'Address',
			'id'		=> $prefix.'address',
			'default'	=> '',
			'type'		=> 'textarea',
			'attr'		=> array(
				'rows'		=> 6
			)
		),
		array(
			'label'		=> 'Price',
			'id'		=> $prefix.'price',
			'default'	=> '',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Url',
			'id'		=> $prefix.'url',
			'default'	=> '',
			'type'		=> 'text'
		)
		
	);

	return $fields;
}

$sg_cpt_mb_featured_property = new sg_metabox(array(
	'id'		=> 'sg_cpt_mb_featured_property', 
	'title'		=> 'Property Datas', 
	'fields'	=> 'sg_cpt_mb_featured_property', 
	'post_type'	=> 'sg_cpt_featured_property',
	'context'	=> 'normal',
	'priority'	=> 'high'
));