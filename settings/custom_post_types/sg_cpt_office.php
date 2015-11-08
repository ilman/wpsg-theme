<?php 

function sg_cpt_office() {
	register_post_type('sg_cpt_office',
		array(
			'labels' => array(
				'name' => sg__('Offices'),
				'singular_name' => sg__('Office')
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'page-attributes'  ),
			'rewrite' => array(
				'slug' => 'office'
			),
		)
	);
}
add_action('init', 'sg_cpt_office');


/*----metabox for custom post type----*/

require_once(TEMPLATEPATH.'/settings/helpers/admin_helper.php');

function sg_cpt_mb_office(){

	$prefix = '_sg_mb_office_'; //always use prefix _ for metabox

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
			'label'		=> 'Phone',
			'id'		=> $prefix.'phone',
			'default'	=> '',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Fax',
			'id'		=> $prefix.'fax',
			'default'	=> '',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Email',
			'id'		=> $prefix.'email',
			'default'	=> '',
			'type'		=> 'text'
		)
		
	);

	return $fields;
}

$sg_cpt_mb_office = new sg_metabox(array(
	'id'		=> 'sg_cpt_mb_office', 
	'title'		=> 'Office Datas', 
	'fields'	=> 'sg_cpt_mb_office', 
	'post_type'	=> 'sg_cpt_office',
	'context'	=> 'normal',
	'priority'	=> 'high'
));

function sg_cpt_office_taxonomies() {
    register_taxonomy(
        'sg_cpt_office_group',
        array('sg_cpt_office'),
        array(
            'labels' => array(
                'name' => 'Office Group',
                'add_new_item' => 'Add New Office Group',
                'new_item_name' => "New Office Group"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'show_admin_column' => true,
	        // 'query_var' => true,
	        // 'rewrite' => array( 'slug' => 'fitness-type' ),
        )
    );
}
add_action( 'init', 'sg_cpt_office_taxonomies', 0 );