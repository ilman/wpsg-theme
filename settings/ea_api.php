<?php 

define('EAHOST','http://powering2.expertagent.co.uk');
define('EAAID','{1da5b2e1-549d-44f2-a2bf-a496e82ca831}');


function ea_area_code($type='for-sale'){
	$area_codes_sale = array(
		'caterham' => '6476,40879,23391,10790,38007,6479,9140,25051,6483,6456,40771,42663,22498,36133,47063,12108,6478,6481,38941,6477,6484',
		'coulsdon' => '36136,47060,6167,6482,6458,6452,42118,42441,6455,33244,36132,47063,6454,36135,47061,38876',
		'crawley'  => '38333,4541,4538,4544,15475,4539,4545,4807,39630,38338,29913,4533,4547,4565,39632,38337,29911,25050,4534,4535,4542,38336,29914,4543,4537,4550,4546,4530,6159,4531,4529,4548,4549,4540,38335,4532,38334,4536',
		'croydon'  => '5369,5367,5356,9711,35650,5357,43808,33242,5403,12031,35087,6448,6453,5365,42662,6480,5366,5363,5370,5360,5359,5361,33243,43307,35651,5364,5362,5371,5358,5372,44477,43307,49702',
		'horley'   => '4797,4800,4804,4796,11861,4792,39635,4798,39623',
		// 'horsham'  => '4575,39622,39633,6981,39634,4566,39841,39636,39692',
		'redhill'  => '10442,6445,8593,6447,6444,6446,6442,6443,4795',
		'sutton'   => '30636,6171,6170,6165,47059,47045,47057,47048,38004,6161,15506,35086,6162,6163,6449,6166,30458,6427,57414,57413',
		'worthing' => '36217,36337,36335,36218,36239,36336,36242,33407,36219,40368,36216,36240',
		// 'east-grinstead' => '29910,43272,29909,4806,38862,29915,15325,11048,38002',
	);
	$area_codes_rent = array(
		'brighton-hove' => '4061',
		'caterham' => '56',
		'coulsdon' => '57',
		'crawley'  => '8',
		'croydon' => '60',
		'dorking' => '8593',
		// 'east-grinstead' => '4084',
		// 'epsom' => '9303',
		// 'haywards-heath' => '4086',
		'horley' => '9',
		// 'horsham' => '6454',
		// 'kingston' => '9796',
		'redhill' => '58',
		'sutton' => '59',
		// 'tunbridge-wells' => '5892',
		'worthing' => '4897'
	);

	if($type=='for-sale'){
		return $area_codes_sale;
	}
	elseif($type=='to-rent'){
		return $area_codes_rent;
	}
}



function ea_district_code($area=null, $dep='for-sale'){
	$district_code = array(
		'brighton-hove' => '4061',
		'south-coast' => '4061',
		'caterham' => '56',
		'coulsdon' => '57',
		'crawley'  => '8',
		'croydon' => '60',
		'dorking' => '8593',
		// 'east-grinstead' => '4084',
		// 'epsom' => '9303',
		// 'haywards-heath' => '4086',
		'horley' => '9',
		// 'horsham' => '6454',
		// 'kingston' => '9796',
		'redhill' => '58',
		'sutton' => '59',
		// 'tunbridge-wells' => '5892',
		'worthing' => '4897',
		'dockland' => '30582',
		'central-london' => '30582',
	);

	$district_investment_code = array(
		'london-north' => 50,
		'london-south' => 51,
		'surrey-sussex' => 54,
		'essex-kent' => 49,
		'east-midlands' => 48,
		'west-midlands' => 55,
		'central-southern-england' => 47,
		'south-west-counties' => 53,
		'north-england' => 52,
	);

	if($dep=='for-investment'){
		$district_code = $district_investment_code;
	}

	if($area){
		return SG_Util::val($district_code, $area);
	}
	elseif($area===''){
		return array();
	}

	return $district_code;
}



function ea_agent_id($area=null, $dep='for-sale'){
	$district_code = array(
		'brighton-hove' => '4061',
		'south-coast' => '4061',
		'caterham' => '56',
		'coulsdon' => '57',
		'crawley'  => '8',
		'croydon' => '60',
		'dorking' => '8593',
		// 'east-grinstead' => '4084',
		// 'epsom' => '9303',
		// 'haywards-heath' => '4086',
		'horley' => '9',
		// 'horsham' => '6454',
		// 'kingston' => '9796',
		'redhill' => '58',
		'sutton' => '59',
		// 'tunbridge-wells' => '5892',
		'worthing' => '4897',
		'dockland' => '30582',
		'central-london' => '30582',
	);

	$district_investment_code = array(
		'nationwide' => '{93872ae5-d20d-46f4-80e3-b1a7a2dca642}',
		'london-north' => '{24d98f02-eb6d-403f-ae34-7e095979f224}',
		'london-north-south' => '{F697FB33-148C-4F66-9ABD-EE4500EF9054}',
		'london-south' => '{F697FB33-148C-4F66-9ABD-EE4500EF9054}',
		'surrey-sussex' => '{5F1F7B68-E56E-447F-A26B-3B61E9853662}',
		'essex-kent' => '{10329E55-8363-4605-8E78-C6995C326CCB}',
		'east-midlands' => '{52c361a9-4c4b-4022-adae-a5b6f37fd2de}',
		'west-midlands' => '{5c0082ee-c16c-467f-a7fe-0f8a79417b64}',
		'central-southern-england' => '{D78BCF69-0E74-490B-B588-610B4046AB95}',
		'south-west-counties' => '{A4D4CECD-BDF1-4695-A4B6-53E0B79961C7}',
		'north-england' => '{6FC889AA-6E43-425B-AD52-AE608128FC6B}',
	);

	if($dep=='for-investment'){
		$district_code = $district_investment_code;
	}

	if($area){
		return SG_Util::val($district_code, $area);
	}
	elseif($area===''){
		return array();
	}

	return $district_code;
}




function render_ea_property_html($data, $layout='list-column'){

	if(!is_array($data)){
		return false;
	}

	extract($data);

	if(strrpos(strtolower($url), 'accessdenied') !== false){
		return '<p><i>Temporary session from EA is expired, please repeat your search</i></p>';
	}

	$path = '/templates/ea-'.$layout.'.php';

	ob_start();	
	include(SG_THEME_PATH.$path);
	return ob_get_clean();
}

function curl_ea($url, $params=array())
{
	//http://www.sitepoint.com/using-curl-for-remote-requests/

	$ch = curl_init();
	$wp_upload_dir = wp_upload_dir();
	$wp_upload_dir = $wp_upload_dir['basedir'];

	curl_setopt_array(
    $ch, array( 
	    CURLOPT_URL => $url,
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_FOLLOWLOCATION => true,
	    CURLOPT_CONNECTTIMEOUT => 0,
	    CURLOPT_TIMEOUT => 400,
	    // CURLOPT_NOBODY => true,
	    // CURLOPT_COOKIESESSION => true,
    	// CURLOPT_COOKIEJAR => $wp_upload_dir.'/choices-ea-cookie.txt'
	));
 
	$body = curl_exec($ch);
	$header = curl_getinfo($ch);

	curl_close($ch);

	if($body){
		return array('body'=>$body,'header'=>$header);
	}

	return false;
}




function domInnerXML($node) { 
	$doc  = $node->ownerDocument;
	$frag = $doc->createDocumentFragment();
	foreach ($node->childNodes as $child){
		$frag->appendChild($child->cloneNode(TRUE));
	}
	return $doc->saveXML($frag);
}


function ea_price_array($key=null){
	$price = array(
		'for-sale' => array(
		   '25000','50000','75000','100000','125000','150000','175000','225000','250000','275000',
		   '300000','350000','400000','450000','500000','550000','600000','700000','800000','900000',
		   '1000000'
		),
		'to-rent' => array(
		   '400','500','600','700','800','900','1000','1200','1400','1600',
		   '1800','2000','3000',
		)
	);

	if($key){
		return SG_Util::val($price, $key);
	}
	else{
		return $price;
	}
}


function ea_price_init(){
	$choices_price = array(
		'for-sale' => array(
		   '25000','50000','75000','100000','125000','150000','175000','225000','250000','275000',
		   '300000','350000','400000','450000','500000','550000','600000','700000','800000','900000',
		   '1000000'
		),
		'to-rent' => array(
		   '400','500','600','700','800','900','1000','1200','1400','1600',
		   '1800','2000','3000',
		)
	);

	// Register the script first.
	wp_register_script('ea-form-price', 
		get_template_directory_uri() . '/assets/scripts/ea-form-price.js',
		array('theme-js'),
		'',
		true
	);

	// Now we can localize the script with our data.
	wp_localize_script('ea-form-price', 'choices_price', ea_price_array());

	// The script can be enqueued now or later.
	wp_enqueue_script('ea-form-price');
}
add_action('init','ea_price_init');