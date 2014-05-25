<?php 

function sg_cpt_testimonial() {
	register_post_type('sg_cpt_testimonial',
		array(
			'labels' => array(
				'name' => sg__('Testimonials'),
				'singular_name' => sg__('Testimonial')
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);
}
add_action('init', 'sg_cpt_testimonial');



/*----rename featured image metabox----*/

function sg_cpt_testimonial_change_image_box()
{
    remove_meta_box( 'postimagediv', 'custom_post_type', 'side' );
    add_meta_box('postimagediv', __('New Text'), 'post_thumbnail_meta_box', 'custom_post_type', 'normal', 'high');
}
//add_action('do_meta_boxes', 'sg_cpt_testimonial_change_image_box');




/*----metabox for custom post type----*/

require_once(TEMPLATEPATH.'/settings/helpers/admin_helper.php');

function sg_cpt_mb_testimonial(){

	$prefix = '_sg_mb_testimonial_'; //always use prefix _ for metabox

	/*----options----*/

	

	/*----fields----*/

	$fields = array(
		
		array(
			'label'		=> 'Title / Position',
			'id'		=> $prefix.'section_class',
			'default'	=> '',
			'type'		=> 'text'
		)
		
	);

	return $fields;
}

$sg_cpt_mb_testimonial = new sg_metabox(array(
	'id'		=> 'sg_cpt_mb_testimonial', 
	'title'		=> 'Staff Details', 
	'fields'	=> 'sg_cpt_mb_testimonial', 
	'post_type'	=> 'sg_cpt_testimonial',
	'context'	=> 'normal',
	'priority'	=> 'high'
));