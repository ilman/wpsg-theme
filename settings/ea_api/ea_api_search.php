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


	$query = "SELECT id, advert_heading, advert_image, price_text, property_type, priority, bedrooms, bathrooms, receptions, web_link
			FROM wp_ea_properties
			WHERE $query
			ORDER BY numeric_price ASC
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

	//map input xbranches
	$query .= ea_query_array_xbranch_helper($input, 'xbranch', 'xbranches', 'branch');

	//map input department
	$query .= ea_query_department_helper($input, 'dep');

	//map input branches
	$query .= ea_query_array_helper($input, 'branch', 'branches', 'branch');

	//map input districts
	$query .= ea_query_array_helper($input, 'district', 'districts', 'district');

	//map input towns
	$query .= ea_query_array_helper($input, 'town', 'towns', 'town');

	//map input counties
	$query .= ea_query_array_helper($input, 'county', 'counties', 'county');

	//map input areas
	$query .= ea_query_array_helper($input, 'area', 'areas', 'area');

	//map input areas
	$query .= ea_query_array_helper($input, 'region', 'regions', 'agency_region');

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


function ea_query_department_helper($input, $key='dep'){
	$input_dep = SG_Util::val($input, 'dep');
	$input_branch = SG_Util::val($input, 'branch');
	$input_xbranch = SG_Util::val($input, 'xbranch');
	$input_xbranches = SG_Util::val($input, 'xbranches');

	if($input_dep=='to-rent'){
		$query .= "department = 'lettings' ";
	}
	else{
		// elseif($input_dep=='new-homes'){
		// 	$query .= "department = 'new homes' ";
		// }
		if(in_array('New Homes', SG_Util::val($input, 'xbranches', []))){
			// $query .= "(department = 'new homes' or department ='sales') ";
			$query .= "department != 'lettings' ";
		}
		elseif(stripos($input_xbranch, 'new homes') !== false){
			// $query .= "(department = 'new homes' or department ='sales') ";
			$query .= "department != 'lettings' ";
		}
		else{
			$query .= "department = 'sales' ";
		}
	}

	return (SG_Util::val($input, 'xbranch') || SG_Util::val($input, 'xbranches')) ? "and $query ": "$query ";
}


function ea_query_array_helper($input, $key, $key_plural = '', $key_sql = ''){
	
	if(!$key_plural){
		$key_plural = $key.'s';
	}

	if(!$key_sql){
		$key_sql = $key;
	}

	$query = '';
	$param_items = '';

	$input_items = SG_Util::val($input, $key_plural);
	$input_item = trim(SG_Util::val($input, $key), '|');

	if($input_item){
		$input_items = explode('|', $input_item);
	}

	if(is_array($input_items)){		
		foreach($input_items as $item){

			$param_items .= $key_sql." like '%".trim($item)."%' or ";
		}
		$param_items = trim($param_items, ' or ');
	}
	else{
		if(trim($input_items)){
			$param_items = trim($input_items);
		}
	}

	if($param_items){
		$query .= "and (".$param_items.") ";
	}

	return $query;
}


function ea_query_array_xbranch_helper($input, $key='xbranch', $key_plural = 'xbranches', $key_sql = 'branch'){
	
	if(!$key_plural){
		$key_plural = $key.'s';
	}

	if(!$key_sql){
		$key_sql = $key;
	}

	$query = '';
	$param_items = '';

	$input_items = SG_Util::val($input, $key_plural);
	$input_item = trim(SG_Util::val($input, $key), '|');

	if($input_item){
		$input_items = explode('|', $input_item);
	}

	if(is_array($input_items)){		
		foreach($input_items as $item){

			if(stripos($item, '&') !== false){
				$items = explode('&', $item);

				foreach($items as $item){
					$param_items .= $key_sql." like '%".trim($item)."%' or ";
				}
			}
			elseif($item == 'Executive Property'){
				$param_items .= $key_sql." like '%Choices Select%' or ";
			}
			else{
				$param_items .= $key_sql." like '%".trim($item)."%' or ";
			}

		}
		$param_items = trim($param_items, ' or ');
	}
	else{
		if(trim($input_items)){
			$param_items = trim($input_items);
		}
	}

	if($param_items){
		$query .= "(".$param_items.") ";
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
	// elseif($input_dep=='new-homes'){
	// 	$text .= 'new homes ';
	// }
	else{
		$text .= 'property for sale ';
	}

	//map input area
	$tmp_text = '';
	$input_districts = SG_Util::val($input, 'xbranches');
	$input_district = SG_Util::val($input, 'xbranch');

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
			// $district_list = ea_district_code(null, $input_dep);
			$district_list = clean_ea_branch_list();
			$length = count($district_list);		
			$i=0;		
			foreach($district_list as $key=>$val){
				$delimiter = ($i<($length-1)) ? ', ' : ' and ';
				$tmp_text .= ucwords(str_replace('-', ' ', $val)).$delimiter;

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

function get_ea_group_list($key='branch'){

	global $wpdb;

	$query = "SELECT $key
			FROM wp_ea_properties
			GROUP BY $key
			ORDER BY $key ASC";

	return $wpdb->get_col($query);
}

function clean_ea_branch_list(){
	$areas = array();
    $array = get_ea_group_list('branch');
    foreach($array as $item){
        $item = str_ireplace('choices - ', '', $item);
        $item = str_ireplace('office', '', $item);
        $item = str_ireplace('department', '', $item);
        $item = trim($item);

        if($item == 'Caterham'){
        	$item = 'Caterham & Coulsdon';
        }
        elseif($item == 'Redhill'){
        	$item = 'Horley & Redhill';
        }
        elseif($item == 'Choices Select'){
        	$item = 'Executive Property';
        }

        if($item != 'Coulsdon' && $item != 'Horley'){
        	$areas[] = $item;
        }
    }

    return $areas;
}
