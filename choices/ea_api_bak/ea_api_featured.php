<?php 

use Scienceguard\SG_Util;

function get_ea_property_featured($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'dep' => 'for-sale',
		'layout' => 'list-column',
		'class' => '',
		'style' => '',
	), $attr));

	$wp_upload_dir = wp_upload_dir();
	$wp_upload_dir = $wp_upload_dir['basedir'];
	
	if(!is_dir($wp_upload_dir)){
		return false;
	}

	// $data_cache = file_get_contents($wp_upload_dir.'/pow-'.$dep.'.json');
	// $data_cache = json_decode($data_cache);

	$data_cache = get_transient('ea-pow-'.$dep);
	if(!$data_cache){
		$data_cache = cache_ea_property_featured($dep);
	}

	$data_cache = array(
		'result' => $data_cache, 
		'dep' => $dep
	);

	return render_ea_property_html_featured($data_cache, $layout);
}
add_shortcode('ea_property_featured', 'get_ea_property_featured');





function render_ea_property_html_featured($data, $layout='list-column'){

	if(!is_array($data)){
		return false;
	}

	extract($data);

	$path = sg_view_path('templates/ea_api_bak/ea-featured-'.$layout.'.php');

	ob_start();	
	include($path);
	return ob_get_clean();
}




function cache_ea_property_featured($dep='for-sale'){
	
	$param = array();

	if($dep=='for-investment'){
		$param['dep'] = 3;
		$arr_aid = array(
			'{24d98f02-eb6d-403f-ae34-7e095979f224}',
			'{5f1f7b68-e56e-447f-a26b-3b61e9853662}',
			'{6fc889aa-6e43-425b-ad52-ae608128fc6b}',
		);
	}
	elseif($dep=='to-rent'){
		$param['dep'] = 2;
		$arr_aid = array(
			'{deabd041-5ad1-41e3-a35f-25adac159e5b}',
			'{2176718a-3dab-46f6-a0e7-2ac198ad9afc}',
			'{b92042a3-30ca-4654-ad8c-3a5fac11e787}',
		);
	}
	else{
		$param['dep'] = 1;
		$arr_aid = array(
			'{eb8433a5-c8ca-486e-82c2-4772eacb65a6}',
			'{dade559b-5f03-4775-a321-a8856b5a1e26}',
			'{1da5b2e1-549d-44f2-a2bf-a496e82ca831}',
		);
	}

	$data_cache = array();
	foreach($arr_aid as $aid){

		$param['aid'] = $aid;
		$param['powURL'] = '';

		$url = EAHOST.'/pow.aspx';
		$url = $url.'?'.urldecode(http_build_query($param));

		$data_curl =  curl_ea($url);
		if($data_curl){
			$data_body = $data_curl['body'];
			$data_header = $data_curl['header'];
		}
		else{
			return false;
		}

		$data_cache[] = array_merge(
			get_ea_property_featured_dom($data_body), 
			array(
				'url' => SG_Util::val($data_header,'url')
			)
		);
	}

	set_transient('ea-pow-'.$dep, $data_cache, 60*60*12 );

	return $data_cache;
}



function get_ea_property_featured_dom($html)
{
	$dom = new DOMDocument();
	@$dom->loadHtml($html);
	
	$xpath = new DOMXPath($dom);

	//get item data

	$item_title = $xpath->query("//*[contains(@id, 'headingContainer')]")->item(0);
	$item_price = $xpath->query("//*[contains(@id, 'priceContainer')]")->item(0);
	$item_desc  = $xpath->query("//*[contains(@id, 'mainTextContainer')]")->item(0);
	$item_image = $xpath->query("//*[contains(@id, 'mainImageContainer')]//img")->item(0);
	$item_link = $xpath->query("//*[contains(@id, 'mainTextContainer')]//a")->item(0);

	$result = new stdClass();

	if($item_title){
		$result->title  = $item_title->nodeValue;
		$result->price  = $item_price->nodeValue;
		$result->desc   = domInnerXML($item_desc);
		$result->image  = $item_image->attributes->getNamedItem("src")->nodeValue;
		$result->link   = $item_link->attributes->getNamedItem("href")->nodeValue;

		if($result->image){
			$result->image = (strpos($result->image, EAHOST)!==false) ? $result->image : EAHOST.'/'.$result->image;	
		}

		if($result->link){
			$link = $result->link;

			$link = str_replace(array(
				'javascript:showPow',
				'(',
				"'",
				')',
				';'
			), '', $link);

			$link = explode(',', $link);

			$param = array(
				'aid' => '{'.trim($link[1]).'}',
				'pid' => trim($link[2])
			);

			$result->link = EAHOST.'/propertyDetails2.aspx?'.urldecode(http_build_query($param));
		}
	}

	return array('result'=>$result);
}