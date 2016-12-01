<?php 

function sg_cpt_property() {
	register_post_type('sg_cpt_property',
		array(
			'labels' => array(
				'name' => __('Properties', SG_THEME_ID),
				'singular_name' => __('Property', SG_THEME_ID)
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'page-attributes'),
			'rewrite' => array(
				'slug' => 'property'
			),
		)
	);
}
add_action('init', 'sg_cpt_property');


/*----metabox for custom post type----*/

function sg_cpt_mb_property(){

	$prefix = '_sg_mb_property_'; //always use prefix _ for metabox

	/*----options----*/

	$option_property_department = array(
		array('label'=>'For Sale', 'value'=>'for-sale'),
		array('label'=>'To Rent', 'value'=>'to-rent'),
		array('label'=>'For Investment', 'value'=>'for-investment'),
		array('label'=>'Below Market Value', 'value'=>'below-market-value'),
		array('label'=>'Development', 'value'=>'development'),
		array('label'=>'Stock', 'value'=>'stock'),
	);

	/*----fields----*/

	$fields = array(
		array(
			'label'		=> 'Department',
			'id'		=> $prefix.'dep',
			'type'		=> 'select',
			'options'	=> $option_property_department
		),
	);

	return $fields;
}

$sg_cpt_mb_property = new sg_metabox(array(
	'id'		=> 'sg_cpt_mb_property', 
	'title'		=> 'Property Datas', 
	'fields'	=> 'sg_cpt_mb_property', 
	'post_type'	=> 'sg_cpt_property',
	'context'	=> 'normal',
	'priority'	=> 'high'
));


/*----change column in post list----*/

function sg_cpt_property_change_columns($cols) {

	$cols = array(
		'cb' => '<input type="checkbox" />',
		'title' => sg__('Title'),
		'sg_col_dep' => sg__('Department'),
		'date' => sg__('Date'),
	);
		
	return $cols;
}
add_filter('manage_sg_cpt_property_posts_columns', 'sg_cpt_property_change_columns');

function sg_cpt_property_custom_columns($column, $post_id){
	switch($column){
		case "sg_col_dep":
			$dep = get_post_meta($post_id, '_sg_mb_property_dep', true);
			echo '<a href="'.get_edit_post_link($post_id).'">'.$dep.'</a>';
		break;		
	}
}
add_action('manage_sg_cpt_property_posts_custom_column', 'sg_cpt_property_custom_columns', 10, 2 );

/*----sort column in post list----*/

function sg_cpt_property_sortable_columns( $columns ) {

	$columns['sg_col_dep'] = 'sg_col_dep';

	return $columns;
}
add_filter( 'manage_edit-sg_cpt_property_sortable_columns', 'sg_cpt_property_sortable_columns' );

function sg_cpt_property_sort($vars) {
	/* Check if we're viewing the 'sg_cpt_property' post type. */
	if ( isset( $vars['post_type'] ) && 'sg_cpt_property' == $vars['post_type'] ) {
		/* Check if 'orderby' is set to 'sg_col_dep'. */
		if ( isset( $vars['orderby'] ) && 'sg_col_dep' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => '_sg_mb_property_dep',
					'orderby' => 'meta_value'
				)
			);
		}
	}
	return $vars;
}

function sg_cpt_property_load() {
	add_filter( 'request', 'sg_cpt_property_sort' );
}
add_action('load-edit.php', 'sg_cpt_property_load');


function sg_cpt_property_taxonomies() {
    register_taxonomy(
        'sg_cpt_property_group',
        array('sg_cpt_property'),
        array(
            'labels' => array(
                'name' => 'Property Group',
                'add_new_item' => 'Add New Property Group',
                'new_item_name' => "New Property Group"
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
add_action( 'init', 'sg_cpt_property_taxonomies', 0 );