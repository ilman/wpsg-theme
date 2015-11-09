<?php 

function get_resales_search_result($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'list' => '',
		'class' => '',
		'style' => '',
		
		'search_type' => 'for-sale',
		'country' => 'spain',
		'area' => 'costa del sol',
	), $attr));

	$params = array(
		'search_type' => $search_type, 
		'country' => $country, 
		'area' => $area, 
	);

	$url  = build_resales_property_search_url($params);
	$text = build_resales_property_search_text($params);

	//check if its already cached before
	//dont cache search data :(

	$data_key = array_merge($params, $_GET);
	$data_key = SG_Util::slug(implode('_', $data_key), '_');
	$data_key = 'resales_'.str_replace('_', '', $data_key);

	$data_cache = get_transient($data_key); //get_transient not working
	
	if($data_cache!==false){
		return render_resales_property_html($data_cache);
	}

	$data_curl =  curl_resales($url);
	if($data_curl){
		$data_body = $data_curl['body'];
		$data_header = $data_curl['header'];
	}
	else{
		return false;
	}

	$data_cache = array_merge(
		get_resales_property_search_dom($data_body), 
		array(
			'url' => SG_Util::val($data_header,'url'),
			'text' => $text, 
			'search_type' => $search_type,
		)
	);

	// dont cache search data :(
	set_transient($data_key, $data_cache, 60*60); //1 hour

	return render_resales_property_html($data_cache);
}
add_shortcode('resales_search_result', 'get_resales_search_result');



function get_resales_search_form($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'action' => '',
		'layout' => 'vertical',
		'class' => '',
		'style' => '',
	), $attr));

	$action = sg_opt('resales_search_result_page');
	$action = get_permalink($action);

	ob_start();	
	include(SG_THEME_PATH.'/templates/resales-search-form-'.$layout.'.php');
	return ob_get_clean();
}
add_shortcode('resales_search_form', 'get_resales_search_form');



function build_resales_property_search_url($params)
{
	extract((array) $params);
	
	$identifier = 1014809;
	$input = $_GET;
	$query = '';

	if($search_type == 'to-rent'){
		$query = 'http://weblink.resales-online.com/weblink/xml/V4-1/SearchRentalXML.asp';
	}
	elseif($search_type == 'featured'){
		$query = 'http://weblink.resales-online.com/weblink/xml/V4-1FeaturedPropertiesXML.asp';
	}
	else{
		$query = 'http://weblink.resales-online.com/weblink/xml/V4-1/SearchResaleXML.asp';
	}

	//add identifier 
	$query .= '?p1='.$identifier;

	$input_country = SG_Util::val($input, 'country', $country);
	$input_area = SG_Util::val($input, 'area', $area);
	$input_per_page = SG_Util::val($input, 'per_page', 12);
	$input_cur = SG_Util::val($input, 'cur', 'GBP');

	if($input_country){ $query .= '&P_Country='.$input_country; }
	if($input_area){ $query .= '&P_Area='.urlencode($input_area); }
	if($input_per_page){ $query .= '&P_PageSize='.$input_per_page; }
	if($input_cur){ $query .= '&P_Currency='.$input_cur; }
	
	if(isset($input['location'])){ $query .= '&P_Location='.urlencode($input['location']); }
	if(isset($input['ptype'])){ $query .= '&PropertyTypes='.$input['ptype']; }
	if(isset($input['min'])){ $query .= '&P_Min='.$input['min']; }
	if(isset($input['max'])){ $query .= '&P_Max='.$input['max']; }
	if(isset($input['beds'])){ $query .= '&P_Beds='.$input['beds']; }
	if(isset($input['baths'])){ $query .= '&P_Baths='.$input['baths']; }
	if(isset($input['sort'])){ $query .= '&P_SortType='.$input['sort']; }
	if(isset($input['own'])){ $query .= '&P_Own='.$input['own']; }
	
	if(isset($input['query_id'])){ $query .= '&P_QueryId='.$input['query_id']; }
	if(isset($input['s_page'])){ $query .= '&P_PageNo='.$input['s_page']; }

	return $query;;
}


function build_resales_property_search_text($params)
{
	extract((array) $params);

	$input = $_GET;
	$text = 'Search result for ';
	
	//map input dep
	$input_type = SG_Util::val($input, 'type', $search_type);
	if($input_type=='to-rent'){
		$text .= 'property to rent ';
	}
	elseif($input_type=='for-investment'){
		$text .= 'property for investment ';
	}
	else{
		$text .= 'property for sale ';
	}

	//map input country
	$input_country = SG_Util::val($input, 'country', $country);
	$text .= 'in country '.trim($input_country,', ').' ';

	//map input area
	$input_area = SG_Util::val($input, 'area', $area);
	$text .= 'in area '.trim($input_area,', ').' ';

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



function get_resales_property_search_dom($html)
{
	$pagination = array();
	$result = array();
	$query_info = array();

	$dom = new DOMDocument();
	@$dom->loadHtml($html);
	
	$xpath = new DOMXPath($dom);

	//get query info
	$xquery = "//queryinfo";
	$row = $xpath->query($xquery);
	$item = $row->item(0);

	//get item data
	$item_data = array(
		'query_id' => $xpath->query("./queryid",$item)->item(0)->nodeValue,
		'property_count' => $xpath->query("./propertycount",$item)->item(0)->nodeValue,
		'current_page' => $xpath->query("./currentpage",$item)->item(0)->nodeValue,
		'per_page' => $xpath->query("./propertiesperpage",$item)->item(0)->nodeValue,
	);
	
	$query_info = (object) $item_data;

	//get search result
	$xquery = "//property";
	$row = $xpath->query($xquery);
	
	for($i=0; $i<$row->length; $i++){
		$item = $row->item($i);	
		
		//get item data
		$item_data = array(
			'ref' => $xpath->query("./reference",$item)->item(0)->nodeValue,
			'country' => $xpath->query("./country",$item)->item(0)->nodeValue,
			'area' => $xpath->query("./area",$item)->item(0)->nodeValue,
			'location' => $xpath->query("./location",$item)->item(0)->nodeValue,
			'type' => $xpath->query("./type",$item)->item(0)->nodeValue,
			'type2' => $xpath->query("./type2",$item)->item(0)->nodeValue,
			'beds' => $xpath->query("./bedrooms",$item)->item(0)->nodeValue,
			'baths' => $xpath->query("./bathrooms",$item)->item(0)->nodeValue,
			'currency' => $xpath->query("./currency",$item)->item(0)->nodeValue,
			'price' => $xpath->query("./price",$item)->item(0)->nodeValue,
			'original_price' => $xpath->query("./originalprice",$item)->item(0)->nodeValue,
			'dims' => $xpath->query("./dimensions",$item)->item(0)->nodeValue,
			'build' => $xpath->query("./built",$item)->item(0)->nodeValue,
			'terrace' => $xpath->query("./terrace",$item)->item(0)->nodeValue,
			'desc' => $xpath->query("./description",$item)->item(0)->nodeValue,
			'image' => $xpath->query("./mainimage",$item)->item(0)->nodeValue,
		);
		
		
		$result[$i] = (object) $item_data;
	}

	return array('query_info'=>$query_info, 'result'=>$result);
}
