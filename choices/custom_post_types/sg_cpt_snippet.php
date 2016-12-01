<?php 

$sg_cpt_id = 'sg_cpt_snippet';

function sg_cpt_snippet() {
	register_post_type('sg_cpt_snippet',
		array(
			'labels' => array(
				'name' => sg__('Snippets'),
				'singular_name' => sg__('Snippet'),
				'add_new_item' => sg__('Add New Snippet'),
				'edit_item' => sg__('Edit Snippet'),
				'new_item' => sg__('New Snippet'),
				'view_item' => sg__('View Snippet'),
				'search_items' => sg__('Search Snippet'),
				'not_found' => sg__('No snippet found'),
			),
			'public' => true,
			'supports' => array('title', 'editor'),
			'exclude_from_search' => true,
			'menu_position' => 100,
			'publicly_queryable' => false,
			'query_var' => false

		)
	);
}
add_action('init', 'sg_cpt_snippet');



// Modify save datas

function sg_cpt_snippet_save($post_id){
	if(isset($_POST['post_type']) && $_POST['post_type'] != 'sg_cpt_snippet'){
        return;
    }

    $data = array(
    	'ID' => $post_id
    );

    if(isset($_REQUEST['post_title'])){
    	$data['post_title'] = sg_util::slug($_REQUEST['post_title']);
    }

    // unhook this function so it doesn't loop infinitely
    remove_action('save_post', 'sg_cpt_snippet_save');
	// update the post, which calls save_post again
	wp_update_post($data);
	// re-hook this function
	add_action('save_post', 'sg_cpt_snippet_save');
}
add_action('save_post', 'sg_cpt_snippet_save');



// Change the columns for the edit CPT screen

function sg_cpt_snippet_change_columns($cols) {

	$cols = array(
		'cb' => '<input type="checkbox" />',
		'sg_col_id' => sg__('ID'),
		'sg_col_name' => sg__('Name' ),
		'sg_col_status' => sg__('Status'),
		'sg_col_action' => sg__('Action'),
	);
		
	return $cols;
}
add_filter('manage_sg_cpt_snippet_posts_columns', 'sg_cpt_snippet_change_columns');

function sg_cpt_snippet_custom_columns($column, $post_id){
	switch($column){
		case "sg_col_id":
			echo $post_id;
		break;
		case "sg_col_name":
			$name = get_the_title();
			echo '<a href="'.get_edit_post_link($post_id).'">'.$name.'</a>';
		break;
		case "sg_col_action":
			echo '<a href="'.get_edit_post_link($post_id).'"><span class="dashicons dashicons-edit"></span> Edit</a> ';
			echo '<a href="'.get_delete_post_link($post_id).'"><span class="dashicons dashicons-trash"></span> Delete</a> ';
		break;
		case "sg_col_status":
			echo get_post_status($post_id);
		break;
		
	}
}

add_action('manage_sg_cpt_snippet_posts_custom_column', 'sg_cpt_snippet_custom_columns', 10, 2 );



// Remove default permalink from edit post

function sg_cpt_snippet_permalinks($input){
	global $post;
	
	if($post->post_type == 'sg_cpt_snippet'){
		return 'Snippet name should be lower case and doesnt contain spaces';
	}
	return $input;
}
add_filter('get_sample_permalink_html', 'sg_cpt_snippet_permalinks');

// Remove default shortlink from edit post

function sg_cpt_snippet_shortlinks($input){
	global $post;

	if(isset($post->post_type) && $post->post_type == 'sg_cpt_snippet'){
		return '';
	}
	return $input;
}
add_filter('pre_get_shortlink', 'sg_cpt_snippet_shortlinks');