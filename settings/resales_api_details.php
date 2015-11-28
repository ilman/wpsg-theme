<?php 

function get_resales_property_details($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => '',
		'style' => '',
	), $attr));

	$url  = build_resales_property_details_url();

	if(!$url){
		return false;
	}

	//check if its already cached before
	//dont cache search data :(

	$data_key = 'resales_details_'.SG_Util::val($_GET, 'ref_id');
	$data_cache = get_transient($data_key); //data key length must be less than 40 char

	$data_curl =  curl_resales($url);
	if($data_curl){
		$data_body = $data_curl['body'];
		$data_header = $data_curl['header'];
	}
	else{
		return false;
	}

	$data_header_url = SG_Util::val($data_header,'url');

	$data_cache = array_merge(
		get_resales_property_details_dom($data_body, $data_header_url), 
		array(
			'url' => $data_header_url
		)
	);

	// dont cache search data :(
	set_transient($data_key, $data_cache, 60*60); //1 hour

	return render_resales_property_html($data_cache, 'property-details');
}
add_shortcode('resales_property_details', 'get_resales_property_details');


function build_resales_property_details_url()
{
	$identifier = 1014809;
	$input = $_GET;
	$query = 'http://weblink.resales-online.com/weblink/xml/V4-1/PropertyDetailsXML.asp';

	//add identifier 
	$query .= '?p1='.$identifier;

	$input_cur = SG_Util::val($input, 'cur', 'GBP');

	// if($input_cur){ $query .= '&P_Currency='.$input_cur; }
	
	if(isset($input['query_id'])){ $query .= '&P_QueryId='.$input['query_id']; }
	if(isset($input['ref_id'])){ $query .= '&P_RefId='.$input['ref_id']; }

	return $query;;
}


function get_resales_property_details_dom($html)
{
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
	);
	
	$query_info = (object) $item_data;

	//get search result
	$xquery = "//property";
	$row = $xpath->query($xquery);
	
	for($i=0; $i<$row->length; $i++){
		$item = $row->item($i);	
		
		//get images
		$images = array();
		$ximages = $xpath->query(".//pictureurl",$item);
		foreach($ximages as $img){
			$images[] = $img->nodeValue;
		}

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
			'images' => $images,
		);
		
		// $result[$i] = (object) $item_data;
		$result = (object) $item_data;
	}

	return array('query_info'=>$query_info, 'result'=>$result);
}
