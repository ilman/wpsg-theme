<?php 

function get_ea_search_result_new($attr=array()){
	global $wpdb;

	$query = build_ea_propery_search_query_new();
	$text = build_ea_property_search_text_new();

	// extract the attributes into variables
	extract(shortcode_atts(array(
		'list' => '',
		'class' => '',
		'style' => '',
	), $attr));

	$key = 'ea_search_result';
	foreach($_GET as $row){
		if(is_array($row)){
			foreach($row as $r){
				$key .= '_'.$r;
			}
		}
		else{
			$key = '_'.$row;
		}
	}

	$per_page = 12;
	$current_page = (isset($_GET['eapage'])) ? $_GET['eapage'] : 1;
	$offset = ($current_page - 1) * $per_page;

	$pagination = (array) $wpdb->get_row("SELECT count(*) as `total_rows` FROM wp_ea_properties WHERE $query");
	$pagination['base_url'] = '//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$pagination['per_page'] = $per_page;


	$query = "SELECT id, advert_heading, advert_image, price_text, property_type, priority
			FROM wp_ea_properties
			WHERE $query
			LIMIT $per_page
			OFFSET $offset";

	$result = $wpdb->get_results($query);

	//check if its already cached before
	//dont cache search data :(

	// $data_key = 'ea_search_md5_'.md5($url);
	// $data_cache = get_transient($data_key); //get_transient not working
	
	// if($data_cache!==false){
	// 	return render_ea_property_html($data_cache);
	// }

	// $data_curl = wp_remote_get($url, array('timeout'=>30));
	// if($data_curl['response']['code'] == 200){
	// 	$data_curl = $data_curl['body'];		
	// }

	$data_cache = array(
			'url' => '',
			'text' => $text,
			'result' => $result,
			'pagination' => render_ea_pagination_html_new($pagination, 'eapage'),
	);

	// dont cache search data :(
	// set_transient($data_key, $data_cache, 60*60); //1 hour

	return render_ea_property_html_new($data_cache);
}
add_shortcode('ea_search_result', 'get_ea_search_result_new');




function get_ea_search_form_new($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'action' => '',
		'layout' => 'vertical',
		'class' => '',
		'style' => '',
	), $attr));

	$action = sg_opt('ea_search_result_page');
	$action = get_permalink($action);

	ob_start();	
	include(SG_THEME_PATH.'/templates/ea_api/ea-search-form-'.$layout.'.php');
	return ob_get_clean();
}
add_shortcode('ea_search_form', 'get_ea_search_form_new');




function build_ea_propery_search_query_new($input=null){
	
	if($input===null){
		$input = $_GET;
	}

	$query = '';

	//map input dep
	$input_dep = SG_Util::val($input, 'dep');
	if($input_dep=='to-rent'){
		$query .= "department = 'lettings' ";
	}
	else{
		$query .= "department = 'sales' ";
	}


	//map input areas
	$param_districts = '';
	$input_districts = SG_Util::val($input, 'areas');
	$input_district = SG_Util::val($input, 'area');

	if($input_district){
		$input_districts = array($input_district);
	}

	if(is_array($input_districts)){		
		foreach($input_districts as $district){
			$param_districts .= "'".$district."' or";
		}
		$param_districts = trim($param_districts, ' or');
	}
	else{
		if(trim($input_districts)){
			$param_districts = trim($input_districts);
		}
	}

	if($param_districts){
		$query .= "and town like (".$param_districts.") ";
	}

	//map input area (single)
	// $param_district = '';
	// $input_district = SG_Util::val($input, 'area');

	// if(trim($input_district)){
	// 	$param_district = "'".trim($input_district)."'";
	// }

	// if($param_district){
	// 	$query .= "and town like (".$param_district.") ";
	// }

	//map input_price
	$param_pricemin = '';
	$input_pricemin = SG_Util::val($input, 'min');
	if($input_pricemin){
		$param_pricemin .= 'numeric_price >= '.$input_pricemin;
	}

	$param_pricemax = '';
	$input_pricemax = SG_Util::val($input, 'max');
	if($input_pricemax){
		$param_pricemax .= 'numeric_price <= '.$input_pricemin;
	}

	if($input_pricemin && $input_pricemax){
		$query .= "and (".$param_pricemin." and ".$param_pricemax.") ";
	}
	elseif($input_pricemin || $input_pricemax){
		$query .= "and (".$param_pricemin.$param_pricemax.") ";
	}

	//map input_room
	$input_room = SG_Util::val($input, 'bed');
	if($input_room){
		$query .= "and (bedrooms >= $input_room) ";
	}

	//map input_sort
	$input_sort = SG_Util::val($input, 'sort');
	if($input_sort == 'asc' || $input_sort == 'desc'){
		$query .= "";
	}

	return $query;
}





function build_ea_property_search_text_new($input=null){

	if($input===null){
		$input = $_GET;
	}

	$text = 'Search result for ';
	
	//map input dep
	$input_dep = SG_Util::val($input, 'dep');
	if($input_dep=='to-rent'){
		$text .= 'property to rent ';
	}
	elseif($input_dep=='for-investment'){
		$text .= 'property for investment ';
	}
	else{
		$text .= 'property for sale ';
	}

	//map input area
	$tmp_text = '';
	$input_districts = SG_Util::val($input, 'areas');
	$input_district = SG_Util::val($input, 'area');

	if($input_district){
		$input_districts = array($input_district);
	}

	if(is_array($input_districts)){	
		$length = count($input_districts);		
		$i=0;
		foreach($input_districts as $district){
			$delimiter = ($i==$length-2) ? ', ' : ' and ';
			$tmp_text .= ucwords(str_replace('-', ' ', $district)).$delimiter;

			$i++;
		}
	}
	else{
		if(trim($input_districts)){
			$tmp_text .= ucwords(str_replace('-', ' ', $input_districts));
		}
		else{
			$district_list = ea_district_code(null, $input_dep);
			$length = count($district_list);		
			$i=0;		
			foreach($district_list as $key=>$val){
				$delimiter = ($i<($length-1)) ? ', ' : ' and ';
				$tmp_text .= ucwords(str_replace('-', ' ', $key)).$delimiter;

				$i++;
			}
		}
	}
	$text .= 'in area '.trim($tmp_text,', ').' ';

	//map input_price
	$input_pricemin = SG_Util::val($input, 'min');
	if($input_pricemin){
		$text .='with minimum price &pound;'.$input_pricemin.' ';
	}
	else{
		$text .='with no minimum price ';
	}

	$text .= 'and ';

	$input_pricemax = SG_Util::val($input, 'max');
	if($input_pricemax){
		$text .='with maximum price &pound;'.$input_pricemax.' ';
	}
	else{
		$text .='with no maximum price ';
	}

	//map input_room
	$input_room = SG_Util::val($input, 'bed');
	if($input_room !=='' && $input_room !== null){
		if($input_room === 0){
			$text .=' which type is studio';
		}
		else{
			$text .=' with '.$input_room.' bedrooms';
		}
	}

	//map input_sort
	$input_sort = SG_Util::val($input, 'sort');
	if($input_sort == 'asc' || $input_sort == 'desc'){
		$text .=' sort '.$input_sort.'ending';
	}

	return trim($text);
}