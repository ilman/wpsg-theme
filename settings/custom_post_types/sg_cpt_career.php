<?php 

function sg_cpt_career() {
	register_post_type('sg_cpt_career',
		array(
			'labels' => array(
				'name' => sg__('Careers'),
				'singular_name' => sg__('Career')
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor' ),
		)
	);
}
add_action('init', 'sg_cpt_career');



/*----rename featured image metabox----*/

function sg_cpt_career_change_image_box()
{
    remove_meta_box( 'postimagediv', 'custom_post_type', 'side' );
    add_meta_box('postimagediv', __('New Text'), 'post_thumbnail_meta_box', 'custom_post_type', 'normal', 'high');
}
//add_action('do_meta_boxes', 'sg_cpt_career_change_image_box');




/*----metabox for custom post type----*/

require_once(TEMPLATEPATH.'/settings/helpers/admin_helper.php');

function sg_cpt_mb_career(){

	$prefix = '_sg_mb_career_'; //always use prefix _ for metabox

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

// $sg_cpt_mb_career = new sg_metabox(array(
// 	'id'		=> 'sg_cpt_mb_career', 
// 	'title'		=> 'Staff Details', 
// 	'fields'	=> 'sg_cpt_mb_career', 
// 	'post_type'	=> 'sg_cpt_career',
// 	'context'	=> 'normal',
// 	'priority'	=> 'high'
// ));