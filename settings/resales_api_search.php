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
		'search_type' => (isset($_GET['dep'])) ? $_GET['dep'] : $search_type, 
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

	// render
	$action = sg_opt('resales_search_result_page');
	$action = get_permalink($action);

	$data_property_types = get_resales_property_types();
	$data_property_locations = get_resales_property_locations();

	ob_start();	
	include(SG_THEME_PATH.'/templates/resales-search-form-'.$layout.'.php');
	return ob_get_clean();
}
add_shortcode('resales_search_form', 'get_resales_search_form');


function build_resales_property_search_url($params)
{
	extract((array) $params);
	
	$identifier = RESALESAID;
	$input = $_GET;
	$query = '';

	if($search_type == 'to-rent'){
		$query = 'http://weblink.resales-online.com/weblink/xml/V4-1/SearchRentalXML.asp';
	}
	elseif($search_type == 'featured'){
		$query = 'http://weblink.resales-online.com/weblink/xml/V4-1/FeaturedPropertiesXML.asp';
	}
	else{
		$query = 'http://weblink.resales-online.com/weblink/xml/V4-1/SearchResaleXML.asp';
	}

	//add identifier 
	$query .= '?p1='.$identifier;

	$input_country = SG_Util::val($input, 'country', $country);
	$input_area = SG_Util::val($input, 'area', $area);
	$input_per_page = SG_Util::val($input, 'per_page', 12);
	// $input_cur = SG_Util::val($input, 'cur', 'GBP');

	if($input_country){ $query .= '&P_Country='.$input_country; }
	if($input_area){ $query .= '&P_Area='.urlencode($input_area); }
	if($input_per_page){ $query .= '&P_PageSize='.$input_per_page; }
	// if($input_cur){ $query .= '&P_Currency='.$input_cur; }
	
	if(SG_Util::val($input,'location')){ $query .= '&P_Location='.urlencode($input['location']); }
	if(SG_Util::val($input,'ptype')){ $query .= '&P_PropertyTypes='.$input['ptype']; }
	if(SG_Util::val($input,'min')){ $query .= '&P_Min='.$input['min']; }
	if(SG_Util::val($input,'max')){ $query .= '&P_Max='.$input['max']; }
	if(SG_Util::val($input,'beds')){ $query .= '&P_Beds='.$input['beds']; }
	if(SG_Util::val($input,'baths')){ $query .= '&P_Baths='.$input['baths']; }
	if(SG_Util::val($input,'sort')){ $query .= '&P_SortType='.$input['sort']; }
	if(SG_Util::val($input,'own')){ $query .= '&P_Own='.$input['own']; }
	
	if(SG_Util::val($input,'query_id')){ $query .= '&P_QueryId='.$input['query_id']; }
	if(SG_Util::val($input,'s_page')){ $query .= '&P_PageNo='.$input['s_page']; }

	return $query;;
}


function build_resales_property_search_text($params)
{
	extract((array) $params);

	$input = $_GET;
	$text = 'Showing result for ';
	
	//map input dep
	$input_dep = SG_Util::val($input, 'dep', $search_type);
	if($input_dep=='to-rent'){
		$text .= 'properties to rent ';
	}
	elseif($input_dep=='for-investment'){
		$text .= 'properties for investment ';
	}
	else{
		$text .= 'properties for sale ';
	}

	//map input country
	$input_country = SG_Util::val($input, 'country', $country);
	$text .= 'in country '.trim($input_country,', ').' ';

	//map input area
	$input_area = SG_Util::val($input, 'area', $area);
	$text .= 'around '.trim($input_area,', ').' ';

	//map input location
	$input_location = SG_Util::val($input, 'location');
	if($input_location){
		$text .= 'in location '.trim($input_location,', ').' ';
	}

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
			'cur' => $xpath->query("./currency",$item)->item(0)->nodeValue,
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


function get_resales_property_types_dom($html)
{
	$result = array();

	$dom = new DOMDocument();
	@$dom->loadHtml($html);
	
	$xpath = new DOMXPath($dom);

	//get search result
	$xquery = "//propertytype";
	$row = $xpath->query($xquery);
	
	for($i=0; $i<$row->length; $i++){
		$item = $row->item($i);	
		
		$sub_type_data = array();
		$sub_types = $xpath->query("./subtype",$item);
		
		foreach($sub_types as $sub_type){
			$sub_type_data[] = array(
				'label' => $xpath->query("./type",$sub_type)->item(0)->nodeValue,
				'value' => $xpath->query("./optionvalue",$sub_type)->item(0)->nodeValue,
			);
		}

		//get item data
		$item_data = array(
			'label' => $xpath->query("./type",$item)->item(0)->nodeValue,
			'value' => $xpath->query("./optionvalue",$item)->item(0)->nodeValue,
			'sub_types' => $sub_type_data,
		);		
		
		$result[$i] = (object) $item_data;
	}

	return $result;
}


function get_resales_property_locations_dom($html)
{
	$result = array();

	$dom = new DOMDocument();
	@$dom->loadHtml($html);
	
	$xpath = new DOMXPath($dom);

	//get search result
	$xquery = "//locationname";
	$row = $xpath->query($xquery);
	
	for($i=0; $i<$row->length; $i++){
		$item = $row->item($i);	
		
		$result[$i] = $item->nodeValue;
	}

	return $result;
}


function get_resales_property_types()
{
	// curl get property types
	$url = 'http://weblink.resales-online.com/weblink/xml/V4-1/SearchPropertyTypesXML.asp?p1='.RESALESAID.'&p_country=Spain';

	//check if its already cached before
	//dont cache search data :(

	$data_key = 'resales_property_types';

	$data_cache = get_transient($data_key); //get_transient not working
	
	if($data_cache!==false){
		return $data_cache;
	}

	//continue

	$data_curl =  curl_resales($url);
	if($data_curl){
		$data_body = $data_curl['body'];
		$data_header = $data_curl['header'];
	}
	else{
		return false;
	}

	$data_cache = get_resales_property_types_dom($data_body);

	// dont cache search data :(
	set_transient($data_key, $data_cache, 60*60); //1 hour

	return $data_cache;
}


function get_resales_property_locations()
{
	// curl get property types
	$url = 'http://weblink.resales-online.com/weblink/xml/SearchLocationsXMLV4.asp?p1='.RESALESAID.'&p_area=costa%20del%20sol&p_country=Spain';

	//check if its already cached before
	//dont cache search data :(

	$data_key = 'resales_property_locations';

	$data_cache = get_transient($data_key); //get_transient not working
	
	if($data_cache!==false){
		return $data_cache;
	}

	//continue

	$data_curl =  curl_resales($url);
	if($data_curl){
		$data_body = $data_curl['body'];
		$data_header = $data_curl['header'];
	}
	else{
		return false;
	}

	$data_cache = get_resales_property_locations_dom($data_body);

	// dont cache search data :(
	set_transient($data_key, $data_cache, 60*60); //1 hour

	return $data_cache;
}