<?php 

use Scienceguard\SG_Util;

function sg_val($array, $key=null, $default=null){
	return SG_Util::val($array, $key, $default);
}

function sg_val_class($inputs=array()){
	$output = '';
	foreach($inputs as $input){
		if($input){
			$output .= ' '.$input;	
		}
	}
	return trim($output);
}

/*wrapper to get theme option*/
function sg_opt($param=null, $default=null){
	global $sg_theme_options;
	
	if($sg_theme_options){
		return sg_val($sg_theme_options, $param, $default);
	}
	else{		
		return sg_val(null, $param, $default);
	}
}



function sg_view_path($path){
	if(file_exists($path)){ return $path; }

	$base = rtrim(TEMPLATEPATH, '/');
	$path = trim($path, '/');

	if(file_exists($base.'/front/'.$path)){
		$path = $base.'/front/'.$path;
	}
	elseif(file_exists($base.'/framework/'.$path)){
		$path = $base.'/framework/'.$path;
	}
	else{
		$path = $base.'/'.$path;
	}

	return $path;
}


function sg_asset_url($path){
	$path = trim($path, '/');
	return get_template_directory_uri().'/'.$path;
}


function sg_get_template_part( $slug, $name = null ) {
	if($name){
		$file = $slug.'-'.$name;
	}
	else{
		$file = $slug;
	}

	include sg_view_path($file.'.php');
}


function sg_include_path($path, $file_type='php'){

	$glob = glob(rtrim(TEMPLATEPATH, '/')."/$path/*.$file_type");
	if(!is_array($glob)){
		return false;
	}
		
	foreach ($glob as $filename){
		include_once($filename);
	}
}

if(!function_exists('sg_action_post_link')){
	function sg_action_post_link($id = null, $text = ''){
		$output = $text;
		$link = get_edit_post_link($id);

		if($text){
			$output = str_replace('{{ id }}', $id, $output);
			$output = str_replace('{{ link }}', $link, $output);
		}
		else{
			$output .= '<div class="float-actions">';
			$output .= '<a class="btn btn-warning btn-sm id-'.$id.'" href="'.get_edit_post_link($id).'"><i class="fa fa-pencil"></i> Edit Post</a>';
			$output .= '</div>';
		}

		if(current_user_can('edit_posts')){
			return $output;
		}	
	}
}


function sg_get_metadata($meta_type, $object_id, $meta_key = '', $single = false) {
	if ( ! $meta_type || ! is_numeric( $object_id ) ) {
		return null;
	}

	$object_id = absint( $object_id );
	if ( ! $object_id ) {
		return null;
	}

	/**
	 * Filter whether to retrieve metadata of a specific type.
	 *
	 * The dynamic portion of the hook, `$meta_type`, refers to the meta
	 * object type (comment, post, or user). Returning a non-null value
	 * will effectively short-circuit the function.
	 *
	 * @since 3.1.0
	 *
	 * @param null|array|string $value     The value get_metadata() should return - a single metadata value,
	 *                                     or an array of values.
	 * @param int               $object_id Object ID.
	 * @param string            $meta_key  Meta key.
	 * @param bool              $single    Whether to return only the first value of the specified $meta_key.
	 */
	$check = apply_filters( "get_{$meta_type}_metadata", null, $object_id, $meta_key, $single );
	if ( null !== $check ) {
		if ( $single && is_array( $check ) )
			return $check[0];
		else
			return $check;
	}

	$meta_cache = wp_cache_get($object_id, $meta_type . '_meta');

	if ( !$meta_cache ) {
		$meta_cache = update_meta_cache( $meta_type, array( $object_id ) );
		$meta_cache = $meta_cache[$object_id];
	}

	if ( ! $meta_key ) {
		return $meta_cache;
	}

	if ( isset($meta_cache[$meta_key]) ) {
		if ( $single )
			return maybe_unserialize( $meta_cache[$meta_key][0] );
		else
			return array_map('maybe_unserialize', $meta_cache[$meta_key]);
	}

	if ($single)
		return null;
	else
		return array();
}


function sg_get_post_meta( $post_id, $key = '', $single = false, $default = null) {
	$value = sg_get_metadata('post', $post_id, $key, $single);
	return ($value !== null) ? $value : $default;
}


function sg_get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
    global $wpdb;
    $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s", $page_slug, $post_type ) );
    if ( $page )
            return get_page($page, $output);
    return null;
}