<?php 

function sg_cpt_career() {
	register_post_type('sg_cpt_career',
		array(
			'labels' => array(
				'name' => __('Careers', SG_THEME_ID),
				'singular_name' => __('Career', SG_THEME_ID)
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'page-attributes' ),
			'rewrite' => array(
				'slug' => 'career'
			),
		)
	);
}
add_action('init', 'sg_cpt_career');


/*----metabox for custom post type----*/

function sg_cpt_mb_career(){

	$prefix = '_sg_mb_career_'; //always use prefix _ for metabox

	/*----options----*/

	$option_career_roles = array(
		array('label'=>'Sales', 'value'=>'sales'),
		array('label'=>'Admin', 'value'=>'admin'),
	);

	/*----fields----*/

	$fields = array(
		
		array(
			'label'		=> 'Ref Code',
			'id'		=> $prefix.'ref_code',
			'default'	=> '',
			'type'		=> 'text'
		), 
		array(
			'label'		=> 'Roles',
			'id'		=> $prefix.'roles',
			'default'	=> '',
			'type'		=> 'select',
			'options'	=> $option_career_roles
		)
		
	);

	return $fields;
}

$sg_cpt_mb_career = new sg_metabox(array(
	'id'		=> 'sg_cpt_mb_career', 
	'title'		=> 'Career Datas', 
	'fields'	=> 'sg_cpt_mb_career', 
	'post_type'	=> 'sg_cpt_career',
	'context'	=> 'normal',
	'priority'	=> 'high'
));

function sg_cpt_career_taxonomies() {
    register_taxonomy(
        'sg_cpt_career_group',
        array('sg_cpt_career'),
        array(
            'labels' => array(
                'name' => 'Career Group',
                'add_new_item' => 'Add New Career Group',
                'new_item_name' => "New Career Group"
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
add_action( 'init', 'sg_cpt_career_taxonomies', 0 );