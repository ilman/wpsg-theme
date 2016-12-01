<?php 

function sg_cpt_office() {
	register_post_type('sg_cpt_office',
		array(
			'labels' => array(
				'name' => __('Offices', SG_THEME_ID),
				'singular_name' => __('Office', SG_THEME_ID)
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'rewrite' => array(
				'slug' => 'office'
			),
		)
	);
}
add_action('init', 'sg_cpt_office');


if(function_exists('add_image_size')){ 
	add_image_size('office_thumb', 320, 230, true);
}

function sg_cpt_office_scripts(){
	if(get_post_type()=='sg_cpt_office'){
		wp_enqueue_script( 'google-map', 'http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyDvRACO1kNp1n64CVZpXpKQW98i8BkzAyo', array('jquery') );
		wp_enqueue_script( 'shortcode-map', SG_THEME_URL.'/assets/scripts/shortcode-map.js', array('jquery','google-map') );
	}
}
add_action('wp', 'sg_cpt_office_scripts');


/*----metabox for custom post type----*/

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
		),
		array(
			'label'		=> 'Opening Hours',
			'id'		=> $prefix.'opening_hour',
			'default'	=> '',
			'type'		=> 'textarea',
			'attr'		=> array(
				'rows'		=> 8
			)
		),
		
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