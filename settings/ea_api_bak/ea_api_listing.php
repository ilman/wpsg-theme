<?php 



function get_ea_property_list($attr=array()){

	// extract the attributes into variables

	extract(shortcode_atts(array(

		'dep' => 'for-sale',
		'area' => '',
		'district_id' => '',
		'area_id' => '',
		'aid' => '',
		'class' => '',
		'style' => '',

	), $attr));

	$area = SG_Util::slug($area);

	$param = $attr;
	$param['district'] = $area;
	$param['district_id'] = $district_id;
	$param['area_id'] = $area_id;

	unset($param['area']);
	unset($param['district_id']);
	unset($param['area_id']);
	unset($param['class']);
	unset($param['style']);

	$url  = build_ea_property_list_url($param);

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
			'curl_url' => $url,
		)
	);

	return render_ea_property_html($data_cache);
}
add_shortcode('ea_property_list', 'get_ea_property_list');




function build_ea_property_list_url($input=null){
	if($input===null){
		$input = $_GET;
	}

	$param = array();

	//map input aid
	$input_aid = SG_Util::val($input, 'aid');
	$param['aid'] = ($input_aid) ? $input_aid : EAAID;


	//map input pagination
	$input_pagination = SG_Util::val($input, 'pagination');
	if(!$input_pagination || $input_pagination == 'false'){
		$param['allProps'] = 'true';
	}

	//map input dep
	$input_dep = SG_Util::val($input, 'dep');
	if($input_dep=='to-rent'){
		$param['dep'] = 2;
	}
	elseif($input_dep=='for-sale'){
		$param['dep'] = 1;
	}
	elseif($input_dep=='for-investment'){
		$param['dep'] = 3;
	}

	//map input district
	$input_district = SG_Util::val($input, 'district');
	$input_district_id = SG_Util::val($input, 'district_id');
	$input_area_id = SG_Util::val($input, 'district_id');

	if($input_district_id){
		$param['Districts'] = $input_district_id;
	}
	elseif($input_area_id){
		$param['Area'] = $input_area_id;
	}
	elseif($input_district){
		$param['Districts'] = ea_district_code($input_district);
	}

	//map url
	if($input_aid){
		$url = EAHOST.'/default.aspx';
	}
	else{
		$url = EAHOST.'/customsearch.aspx';
	}

	return $url.'?'.urldecode(http_build_query($param));
}