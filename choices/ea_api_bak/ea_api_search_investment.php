<?php 

use Scienceguard\SG_Util;

function get_ea_search_investment_result($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'list' => '',
		'class' => '',
		'style' => '',
	), $attr));

	$url  = build_ea_property_search_investment_url();
	$text = build_ea_property_search_text();

	$data_curl =  curl_ea($url);
	if($data_curl){
		$data_body = $data_curl['body'];
		$data_header = $data_curl['header'];
	}
	else{
		return false;
	}

	$data_cache = array_merge(
		get_ea_property_search_dom($data_body), 
		array(
			'url' => SG_Util::val($data_header,'url'),
			'text' => $text
		)
	);

	// dont cache search data :(
	// set_transient($data_key, $data_cache, 60*60); //1 hour

	return render_ea_property_html($data_cache, 'list-column-investment');
}
add_shortcode('ea_search_investment_result', 'get_ea_search_investment_result');




function get_ea_search_investment_form($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'action' => '',
		'layout' => 'vertical',
		'class' => '',
		'style' => '',
	), $attr));

	$action = sg_opt('ea_search_investment_result_page');
	$action = get_permalink($action);

	ob_start();	
	include(sg_view_path('templates/ea_api_bak/ea-search-investment-form-'.$layout.'.php'));
	return ob_get_clean();
}
add_shortcode('ea_search_investment_form', 'get_ea_search_investment_form');




function build_ea_property_search_investment_url($input=null){
	//sample url
	//http://powering2.expertagent.co.uk/CustomSearch.aspx?aid={0309c51a-a909-4a5d-b4ff-abe7874f5a35}&minprice=0&maxprice=50000&districts=50,51,54,49,55,48,47,53,52,

	if($input===null){
		$input = $_GET;
	}
	
	$param = array();

	$easid = SG_Util::val($input, 'easid');
	$eapage = SG_Util::val($input, 'eapage');

	//for pagination only use session id
	//sample url
	//http://powering2.expertagent.co.uk/(S(zccrrv55unj4ch55zzxdkby0))/default.aspx?page=2
	if($easid && $eapage){
		$param['page'] = $eapage; 
		$url = EAHOST.'/'.$easid.'/default.aspx?'.urldecode(http_build_query($param));

		return $url;
	}
	
	$url = EAHOST.'/CustomSearch.aspx';

	// $param['aid'] = '{0309c51a-a909-4a5d-b4ff-abe7874f5a35}';
	$param['aid'] = '';
	
	$agent_ids = ea_agent_id(null, 'for-investment');
	$district_codes = ea_district_code(null, 'for-investment');

	//map input areas
	$param['Districts'] = '';
	$input_districts = SG_Util::val($input, 'areas');

	if(is_array($input_districts)){		
		foreach($input_districts as $district){
			$district = SG_Util::slug($district, '-');
			$district_code = SG_Util::val($district_codes, $district);
			$agent_id = SG_Util::val($agent_ids, $district);
			$param['Districts'] .= ($district_code) ? $district_code.',' : '';
			$param['aid'] .= ($agent_id) ? $agent_id.',' : '';
		}
	}
	else{
		if(trim($input_districts)){
			$district = SG_Util::slug($input_districts, '-');
			$district_code = SG_Util::val($district_codes, $district);
			$agent_id = SG_Util::val($agent_ids, $district);
			$param['Districts'] .= ($district_code) ? $district_code : '';
			$param['aid'] .= ($agent_id) ? $agent_id : '';
		}
		else{			
			foreach($district_codes as $district_code){
				$param['Districts'] .= $district_code.',';
			}
		}
	}
	$param['Districts'] = trim($param['Districts'],',');

	//map input_price
	$input_pricemin = SG_Util::val($input, 'min');
	if($input_pricemin){
		$param['minprice'] = $input_pricemin;
	}

	$input_pricemax = SG_Util::val($input, 'max');
	if($input_pricemax){
		$param['maxprice'] = $input_pricemax;
	}

	//map input_room
	$input_room = SG_Util::val($input, 'bed');
	if($input_room){
		$param['minbeds'] = $input_room;
	}

	//map input_radius
	$input_radius = SG_Util::val($input, 'radius');
	if($input_radius){
		$param['radius'] = $input_radius;
	}

	//map input_sort
	$input_sort = SG_Util::val($input, 'sort');
	if($input_sort == 'asc' || $input_sort == 'desc'){
		$param['sort'] = ucfirst($input_sort);
	}

	return $url.'?'.urldecode(http_build_query($param));
}

