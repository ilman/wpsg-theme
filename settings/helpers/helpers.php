<?php 

function sg_val($var, $field_name='', $default=''){
	if($field_name===''){ return $var; }
	
	$value = '';
	
	if(is_array($var)){			
		if(isset($var[$field_name])){ $value = $var[$field_name]; }
		else{ return $default; }
	}
	elseif(is_object($var)){
		if(isset($var->$field_name)){ $value = $var->$field_name; }
		else{ return $default; }
	}
	else{
		$value = $var;
	}
	
	return ($value) ? $value : $default;
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

function sg_slug($str, $sep='-'){
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9'.$sep.']/', $sep, $str);
	$str = preg_replace('/'.$sep.'+/', $sep, $str);
	$str = trim($str, $sep);
	
	return $str;
}

/*wrapper to for get option*/
function sg_theme_options($param='',$default=''){
	global $sg_theme_options;
	
	return sg_val($sg_theme_options, $param, $default);
}

function sg_opt($param='',$default=''){
	return sg_theme_options($param, $default);
}

/*get post/page id from slug*/
function sg_get_id_by_slug($page_slug, $post_type='page') {
	global $wpdb;		
	$sql_query = "
		SELECT p.ID as id
		FROM $wpdb->posts p
		WHERE (p.post_type = '$post_type')
		AND p.post_name = '$page_slug'
		LIMIT 1
	";		
	return $wpdb->get_var($sql_query);	
}

/*bulk include files from certain path*/
function sg_include_path($path, $file_type='php'){
	$glob = glob(TEMPLATEPATH."$path/*.$file_type");		
	if(!is_array($glob)){
		return false;
	}
		
	foreach ($glob as $filename){
		include_once($filename);
	}	
}

/*safely get data from css or db*/
function sg_get_theme_data(){
	if(function_exists('wp_get_theme')){
		return wp_get_theme();	
	}
	else{
		return get_theme_data(STYLESHEETPATH . '/style.css');	
	}
}

/*check custom post types*/
function sg_check_custom_post_type($str){
	global $post_type;
	if ( ( isset($_GET['post_type']) && $_GET['post_type'] == $str ) || ( isset($post_type) && $post_type == $str ) || ( isset($_GET['post']) && get_post_type($_GET['post']) == $str ) ) {
		return true;
	}	
}

/*wrapper to wp_translate function*/
function sg__($str){
	return __($str, SG_THEME_ID);	
}

function sg_x($text, $context){
	return _x($text, $context, SG_THEME_ID);
}

function sg_e($text){
	return _e($text, SG_THEME_ID);
}

function sg_number_format($number){
	return number_format($number,0,'.',',');
}

function sg_cur_format($cur){
	$cur = strtolower($cur);

	if($cur=='usd'){
		return '$';
	}
	elseif($cur=='eur'){
		return '&euro;';
	}
	elseif($cur=='gbp'){
		return '&pound;';
	}
	else{
		return strtoupper($cur);
	}
}

function sg_price_format($number, $cur=''){
	return trim(sg_cur_format($cur).sg_number_format($number));
}