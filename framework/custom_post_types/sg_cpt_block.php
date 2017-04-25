<?php 

use Scienceguard\SG_Util;

class SG_CptBlock
{

	static function init() {
		register_post_type('sg_cpt_block',
			array(
				'labels' => array(
					'name' => __('Blocks', SG_THEME_ID),
					'singular_name' => __('Block', SG_THEME_ID),
					'add_new_item' => __('Add New Block', SG_THEME_ID),
					'edit_item' => __('Edit Block', SG_THEME_ID),
					'new_item' => __('New Block', SG_THEME_ID),
					'view_item' => __('View Block', SG_THEME_ID),
					'search_items' => __('Search Block', SG_THEME_ID),
					'not_found' => __('No block found', SG_THEME_ID),
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
	


	// Modify save datas

	static function save($post_id){
		if(isset($_POST['post_type']) && $_POST['post_type'] != 'sg_cpt_block'){
		  return;
		}

		$data = array(
			'ID' => $post_id
		);

		if(isset($_REQUEST['post_title'])){
			$data['post_title'] = SG_Util::slug($_REQUEST['post_title']);
		}

		// unhook this function so it doesn't loop infinitely
		remove_action('save_post', array('SG_CptBlock', 'save'));
		// update the post, which calls save_post again
		wp_update_post($data);
		// re-hook this function
		add_action('save_post', array('SG_CptBlock', 'save'));
	}



	// Change the columns for the edit CPT screen

	static function change_columns($cols) {

		$cols = array(
			'cb' => '<input type="checkbox" />',
			'sg_col_name' => __('Name', SG_THEME_ID),
			'sg_col_id' => __('ID', SG_THEME_ID),
			'sg_col_status' => __('Status', SG_THEME_ID),
			'sg_col_action' => __('Action', SG_THEME_ID),
		);
			
		return $cols;
	}
	

	static function custom_columns($column, $post_id){
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


	// Remove default permalink from edit post

	static function permalinks($input){
		global $post;
		
		if(isset($post->post_type) && $post->post_type == 'sg_cpt_block'){
			return 'Block name should be lower case and doesnt contain spaces';
		}
		return $input;
	}
	

	// Remove default shortlink from edit post

	static function shortlinks($input){
		global $post;

		if(isset($post->post_type) && $post->post_type == 'sg_cpt_block'){
			return '';
		}
		return $input;
	}

	static function render($post_id){
		
		$post = get_post($post_id);
		$block_class = sg_get_post_meta($post_id, '_sg_block_wrapper', true);		
		$block_container = sg_get_post_meta($post_id, '_sg_block_container', true);

		$content = '';
		$text = '<a class="edit-block block-{{ id }}" href="{{ link }}" target="_blank">Edit Block</a>';

		if(trim($post->post_content)){
			$content .= '<div class="'.trim('page-block '.$block_class).'">';
			$content .= ($block_container) ? '<div class="container">' : '';
			$content .= $post->post_content.sg_action_post_link($post_id, $text);
			$content .= ($block_container) ? '</div>' : '';
			$content .= '</div>';
		}

		return do_shortcode($content);
	}
}

add_action('init',  array('SG_CptBlock', 'init'));
add_action('save_post', array('SG_CptBlock', 'save'));
add_filter('manage_sg_cpt_block_posts_columns', array('SG_CptBlock', 'change_columns'));
add_action('manage_sg_cpt_block_posts_custom_column', array('SG_CptBlock', 'custom_columns'), 10, 2 );
add_filter('get_sample_permalink_html', array('SG_CptBlock', 'permalinks'));
add_filter('pre_get_shortlink', array('SG_CptBlock', 'shortlinks'));











function sg_block_metabox(){

	$prefix = '_sg_block_'; //always use prefix _ for metabox

	/*----options----*/

	$option_true_false = array(
		array('label'=>'Yes', 'value'=>1),
		array('label'=>'No', 'value'=>0),
	);

	/*----fields----*/

	$fields = array(
		
		array(
			'label'		=> 'Section Class',
			'id'		=> $prefix.'class',
			'default'	=> '',
			'type'		=> 'text',
		),
		array(
			'label'		=> 'Add Container',
			'id'		=> $prefix.'container',
			'default'	=> 1,
			'type'		=> 'radio',
			'options'	=> $option_true_false,
			'attr'		=> array(
				'class' => 'sgtb-radio-inline'
			)
		),
		
	);

	return $fields;
}

$sg_mb_layout = new sg_metabox(array(
	'id'		=> 'sg_block_metabox', 
	'title'		=> 'Block Settings', 
	'fields'	=> 'sg_block_metabox', 
	'post_type'	=> 'sg_cpt_block',
	'context'	=> 'side',
	'priority'	=> 'high'
));