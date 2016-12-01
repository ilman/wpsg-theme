<?php 

use Scienceguard\SG_Util;

function get_ea_search_result($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'list' => '',
		'class' => '',
		'style' => '',
	), $attr));

	$url  = build_ea_property_search_url();
	$text = build_ea_property_search_text();

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

	return render_ea_property_html($data_cache);
}
add_shortcode('ea_search_result', 'get_ea_search_result');




function get_ea_search_form($attr=array()){
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
	include(sg_view_path('templates/ea_api_bak/ea-search-form-'.$layout.'.php'));
	return ob_get_clean();
}
add_shortcode('ea_search_form', 'get_ea_search_form');




function build_ea_property_search_url($input=null){
	//sample url
	//'http://powering2.expertagent.co.uk/CustomSearch.aspx?aid={1da5b2e1-549d-44f2-a2bf-a496e82ca831}&dep=1&areas=6476,40879,23391,10790,38007,6479,9140,25051,6483,6456,40771,42663,22498,36133,47063,12108,6478,6481,38941,6477,6484&sort=Desc'

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

	$param['aid'] = EAAID;

	//map input dep
	$input_dep = SG_Util::val($input, 'dep');
	if($input_dep=='to-rent'){
		$param['dep'] = 2;		
	}
	else{
		$param['dep'] = 1;
	}
	$district_codes = ea_district_code();

	//map input areas
	$param['Districts'] = '';
	$input_districts = SG_Util::val($input, 'areas');

	if(is_array($input_districts)){		
		foreach($input_districts as $district){
			$district = SG_Util::slug($district, '-');
			$district_code = SG_Util::val($district_codes, $district);
			$param['Districts'] .= ($district_code) ? $district_code.',' : '';
		}
	}
	else{
		if(trim($input_districts)){
			$district = SG_Util::slug($input_districts, '-');
			$district_code = SG_Util::val($district_codes, $district);
			$param['Districts'] .= ($district_code) ? $district_code : '';
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





function build_ea_property_search_text(){

	$input = $_GET;
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



function get_ea_property_search_dom($html)
{
	$dom = new DOMDocument();
	@$dom->loadHtml($html);
	
	$xpath = new DOMXPath($dom);

	//get pagination
	$xquery = "//*[contains(@class, 'pagingLinks')]";
	$row = $xpath->query($xquery)->item(0);
	$row = $xpath->query(".//td/u | .//td/a",$row);
	
	$pagination = array();
	for($i=0; $i<$row->length; $i++){
		$item = $row->item($i);

		$pagination[$i] = new stdClass;
		$pagination[$i]->text = $item->nodeValue;
		$pagination[$i]->link = ($item->tagName=='a') ? $item->attributes->getNamedItem("href")->nodeValue : '';
	}
	

	//get search result
	$xquery = "//*[contains(@class, 'propListItemCont')]";
	$row = $xpath->query($xquery);
	
	$result = array();
	for($i=0; $i<$row->length; $i++){
		$item = $row->item($i);	
		
		//get item data
		$item_title = $xpath->query(".//*[contains(@class, 'propListItemTemplateAdvertHeader')]",$item)->item(0);
		$item_price    = $xpath->query(".//*[contains(@class, 'propListItemTemplatePriceText')]",$item)->item(0);
		$item_desc     = $xpath->query(".//*[contains(@class, 'propListItemTemplateDescription')]",$item)->item(0);
		$item_priority = $xpath->query(".//*[contains(@class, 'propListItemTemplatePriority')]",$item)->item(0);
		$item_ref      = $xpath->query(".//*[contains(@class, 'propListItemTemplateReference')]",$item)->item(0);
		$item_link     = $xpath->query(".//a",$item)->item(0);
		$item_image    = $xpath->query(".//*[contains(@class, 'propListItemTemplatePropImage')]//img",$item)->item(0);

		if(!$item_title){
			$item_title =  $xpath->query(".//*[contains(@class, 'propListItemTemplateAddress')]",$item)->item(0);
		}
		
		$result[$i] = new stdClass;
		$result[$i]->title = $item_title->nodeValue;
		$result[$i]->price = $item_price->nodeValue;
		$result[$i]->desc = $item_desc->nodeValue;
		$result[$i]->priority = $item_priority->nodeValue;
		$result[$i]->ref = $item_ref->nodeValue;
		$result[$i]->link = EAHOST.'/'.$item_link->attributes->getNamedItem("href")->nodeValue;
		$result[$i]->image = $item_image->attributes->getNamedItem("src")->nodeValue;	
		$result[$i]->image = (strpos($result[$i]->image, EAHOST)!==false) ? $result[$i]->image : EAHOST.'/'.$result[$i]->image;	
	}

	return array('pagination'=>$pagination, 'result'=>$result);
}
