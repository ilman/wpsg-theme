<?php 

use Scienceguard\SG_Util;

function get_ea_property_details($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => '',
		'style' => '',
	), $attr));

	$url  = build_ea_property_details_url();

	if(!$url){
		return false;
	}

	$data_curl =  curl_ea($url);
	if($data_curl){
		$data_body = $data_curl['body'];
		$data_header = $data_curl['header'];
	}
	else{
		return false;
	}

	$data_header_url = SG_Util::val($data_header,'url');

	$data_cache = array_merge(
		get_ea_property_details_dom($data_body, $data_header_url), 
		array(
			'url' => $data_header_url
		)
	);

	return render_ea_property_html($data_cache, 'property-details');
}
add_shortcode('ea_property_details_old', 'get_ea_property_details');




function build_ea_property_details_url(){
	//sample url
	//'http://powering2.expertagent.co.uk/(S(jf2tkx3c11p0be55pc1gee55))/propertyDetails2.aspx?aid={1da5b2e1-549d-44f2-a2bf-a496e82ca831}&pid=30fa374c-70c1-41e1-b2ee-b6501837275a'

	$input = $_GET;
	$input_aid = SG_Util::val($input, 'eaaid');
	$input_pid = SG_Util::val($input, 'eapid');
	$easid = SG_Util::val($input, 'easid');
	$param = array();

	if(!$input_pid){
		return false;
	}

	$param['aid']   = ($input_aid) ? $input_aid : EAAID;	
	$param['pid']   = $input_pid;

	return EAHOST.'/'.$easid.'/propertyDetails2.aspx?'.urldecode(http_build_query($param));
}




function get_ea_property_details_dom($html, $url='')
{
	$dom = new DOMDocument();
	@$dom->loadHtml($html);
	
	$xpath = new DOMXPath($dom);

	//get session_id from last curl url
	$parsed_url = parse_url($url);
	$url_path = SG_Util::val($parsed_url,'path');
	$exploded_path = explode('/', $url_path);
	$easid = SG_Util::val($exploded_path,1);

	//get item data
	$xquery = "//*[contains(@class, 'propListItemCont')]";
	$row = $xpath->query($xquery);

	$item_address = $xpath->query("//*[contains(@id, 'propAddress')]")->item(0);
	$item_price   = $xpath->query("//*[contains(@id, 'propPrice')]")->item(0);
	$item_branch  = $xpath->query("//*[contains(@id, 'propBranch')]")->item(0);
	$item_status  = $xpath->query("//*[contains(@id, 'propStatus')]")->item(0);
	$item_ref     = $xpath->query("//*[contains(@id, 'propReference')]")->item(0);
	$item_desc    = $xpath->query("//*[contains(@id, 'propDetShortDescCont1')]")->item(0);
	$item_roomdet = $xpath->query("//*[contains(@id, 'propDetRoomDetCont1')]")->item(0);

	$item_images  = $xpath->query("//*[contains(@id, 'propDetThumbnailCont1')]//img");
	$item_details = $xpath->query("//*[contains(@id, 'propDetStarItemsCont1')]//li");
	$item_actions   = $xpath->query("//*[contains(@id, 'propDetIconsCont1')]//a");

	$result = new stdClass();
	$result->address = $item_address->nodeValue;
	$result->price   = $item_price->nodeValue;
	$result->branch  = $item_branch->nodeValue;
	$result->status  = $item_status->nodeValue;
	$result->ref     = $item_ref->nodeValue;
	$result->desc    = domInnerXML($item_desc);
	$result->roomdet = domInnerXML($item_roomdet);
	$result->images  = array();
	$result->details = array();
	$result->actions   = new stdClass;

	for($i=0; $i<$item_images->length; $i++){
		$item = $item_images->item($i);	
		$result->images[$i] = $item->attributes->getNamedItem("src")->nodeValue;
	}

	for($i=0; $i<$item_details->length; $i++){
		$item = $item_details->item($i);	
		$result->details[$i] = $item->nodeValue;
	}

	for($i=0; $i<$item_actions->length; $i++){
		$item = $item_actions->item($i);
		$item_value = $item->attributes->getNamedItem("href")->nodeValue;

		if(stripos($item_value, 'propertymap')!==false){
			$result->actions->map = str_replace('propertyMap.aspx', EAHOST.'/propertyMap.aspx', $item_value);
		}

		if(stripos($item_value, 'maps.google')!==false){
			$result->actions->map = $item_value;
		}

		if(stripos($item_value, 'brochure')!==false){
			if(stripos($item_value, 'javascript:showParticulars')!==false){
				$item_value = str_replace(array(
					'javascript:showParticulars',
					'(',
					"'",
					');',
				), '', $item_value);

				$item_value = "javascript:void(window.open('$item_value','_blank','width=600,height=650,left=20,top=20,resizable=yes,status=no,scrollbars=no'))";
			}
			$result->actions->brochure = $item_value;
		}

		if(stripos($item_value, 'propertyFullDetails')!==false){
			$item_value = EAHOST.'/'.$item_value;
			$item_value = "javascript:void(window.open('$item_value','_blank','width=600,height=650,left=20,top=20,resizable=yes,status=no,scrollbars=no'))";
			$result->actions->brochure = $item_value;
		}

		if(stripos($item_value, 'RequestViewing')!==false){
			$item_value = EAHOST.'/'.$easid.'/'.$item_value;
			$item_value = "javascript:void(window.open('$item_value','_blank','width=600,height=650,left=20,top=20,resizable=yes,status=no,scrollbars=no'))";
			$result->actions->reqview = $item_value;
		}

		if(stripos($item_value, 'floorplan')!==false){
			if(stripos($item_value, 'javascript:showFloorPlan')!==false){
				$item_value = str_replace(array(
					'javascript:showFloorPlan',
					'(',
					"'",
					');',
				), '', $item_value);

				$item_value = explode(',', $item_value);
				$item_value = EAHOST.'/propertyFloorplan.aspx?aid='.SG_Util::val($item_value,0).'&pid='.SG_Util::val($item_value,1);
				$item_value = "javascript:void(window.open('$item_value','_blank','width=600,height=650,left=20,top=20,resizable=yes,status=no,scrollbars=no'))";
			}
			$result->actions->floorplan = $item_value;
		}

		//http://powering2.expertagent.co.uk/(S(sisut545hsmrjjjyz1npix55))/propertyFloorplan.aspx?aid={eb8433a5-c8ca-486e-82c2-4772eacb65a6}&pid=a3613657-547d-490e-a042-d42de5a9409f&height=900&width=1600

		//<a href="javascript:showFloorPlan('{eb8433a5-c8ca-486e-82c2-4772eacb65a6}','a3613657-547d-490e-a042-d42de5a9409f');" target="">Floor plans</a>
		//http://powering2.expertagent.co.uk/(S(4hawqca01kwupm45wpb2m155))/propertyFloorplan.aspx?aid={eb8433a5-c8ca-486e-82c2-4772eacb65a6}&pid=75d24ff3-500d-44cc-b01c-c26c73ebf5ba&height=600&width=600
	}

	return array('result'=>$result);
}