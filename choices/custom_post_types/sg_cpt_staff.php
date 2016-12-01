<?php 

function sg_cpt_staff() {
	register_post_type('sg_cpt_staff',
		array(
			'labels' => array(
				'name' => __('Staffs', SG_THEME_ID),
				'singular_name' => __('Staff', SG_THEME_ID)
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'rewrite' => array(
				'slug' => 'staff'
			),
		)
	);
}
add_action('init', 'sg_cpt_staff');

if(function_exists('add_image_size')){ 
	add_image_size('profile_square', 150, 150, true);
	add_image_size('profile_medium', 300, 400, true);
}



/*----rename featured image metabox----*/

function sg_cpt_staff_change_image_box()
{
    remove_meta_box( 'postimagediv', 'custom_post_type', 'side' );
    add_meta_box('postimagediv', __('New Text'), 'post_thumbnail_meta_box', 'custom_post_type', 'normal', 'high');
}
//add_action('do_meta_boxes', 'sg_cpt_staff_change_image_box');




/*----metabox for custom post type----*/

function sg_cpt_mb_staff(){

	$prefix = '_sg_mb_staff_'; //always use prefix _ for metabox

	/*----options----*/

	

	/*----fields----*/

	$fields = array(
		
		array(
			'label'		=> 'Title / Position',
			'id'		=> $prefix.'title',
			'default'	=> '',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Linkedin Url',
			'id'		=> $prefix.'linkedin_url',
			'default'	=> '',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'All Agent Url',
			'id'		=> $prefix.'all_agent_url',
			'default'	=> '',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Quote',
			'id'		=> $prefix.'quote',
			'default'	=> '',
			'type'		=> 'textarea',
			'sanitizer'	=> 'none',
			'attr'		=> array(
				'rows'		=> 8
			)
		)
		
	);

	return $fields;
}

$sg_cpt_mb_staff = new sg_metabox(array(
	'id'		=> 'sg_cpt_mb_staff', 
	'title'		=> 'Staff Datas', 
	'fields'	=> 'sg_cpt_mb_staff', 
	'post_type'	=> 'sg_cpt_staff',
	'context'	=> 'normal',
	'priority'	=> 'high'
));

/*----filters----*/

// function sg_cpt_staff_template( $template_path ) {
//     // http://code.tutsplus.com/tutorials/a-guide-to-wordpress-custom-post-types-creation-display-and-meta-boxes--wp-27645
//     if(get_post_type() == 'sg_cpt_staff') {
//         if( is_single() ) {
//             $file = '/templates/sg-cpt-staff.php';
//             if($theme_file = locate_template($file)){
//                 $template_path = $theme_file;
//             } 
// 	        else {
// 	            $template_path = plugin_dir_path( __FILE__ ) . $file;
// 	        }
//         }
//     }
//     return $template_path;
// }
// add_filter( 'template_include', 'sg_cpt_staff_template', 1 );


/*----taxonomies----*/

function sg_cpt_staff_taxonomies() {
    register_taxonomy(
        'sg_cpt_staff_group',
        array('sg_cpt_staff'),
        array(
            'labels' => array(
                'name' => 'Staff Group',
                'add_new_item' => 'Add New Staff Group',
                'new_item_name' => "New Staff Group"
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
add_action( 'init', 'sg_cpt_staff_taxonomies', 0 );

/*----change column in post list----*/

function sg_cpt_staff_change_columns($cols) {
	$cols = array(
		'cb' => '<input type="checkbox" />',
		'title' => sg__('Name'),
		'sg_col_image' => sg__('Image'),
		'sg_col_title' => sg__('Title'),
		'taxonomy-sg_cpt_staff_group' => sg__('Staff Group'),
		'date' => sg__('Date'),
	);
		
	return $cols;
}
add_filter('manage_sg_cpt_staff_posts_columns', 'sg_cpt_staff_change_columns');

function sg_cpt_staff_custom_columns($column, $post_id){
	switch($column){
		case "sg_col_image":
			if(has_post_thumbnail()){
				echo 'yes';
			}
			else{
				echo 'no';
			}
		break;	
		case "sg_col_title":
			$dep = get_post_meta($post_id, '_sg_mb_staff_title', true);
			echo $dep;
		break;
	}
}
add_action('manage_sg_cpt_staff_posts_custom_column', 'sg_cpt_staff_custom_columns', 10, 2 );

function sg_cpt_staff_taxonomies_columns( $taxonomies ) {
    $taxonomies[] = 'sg_cpt_staff_group';
    return $taxonomies;
}
add_filter('manage_taxonomies_for_sg_cpt_staff_columns', 'sg_cpt_staff_taxonomies_columns');