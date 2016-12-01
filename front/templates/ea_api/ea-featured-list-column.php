<?php
	use Scienceguard\SG_Util;
	
	if(!isset($col_width)){ $col_width = 3; }

	$page_detail_url = sg_opt('ea_property_details_page');

	//get session_id from last curl url
	$parsed_url = parse_url($url);
	$url_path = SG_Util::val($parsed_url,'path');
	$exploded_path = explode('/', $url_path);
	$easid = SG_Util::val($exploded_path,1);
?>

<ul class="post-list list-column ea-featured-property row">
	<?php if(is_array($result) && count($result)): foreach($result as $row): ?>
		<?php 
			$prop_image    = SG_Util::val($row,'advert_image');
			$prop_title    = SG_Util::val($row,'advert_heading');
			$prop_price    = SG_Util::val($row,'price_text');
			$prop_priority = SG_Util::val($row,'priority');
			$prop_id      = SG_Util::val($row,'id');
			$prop_type     = SG_Util::val($row,'property_type');
			$bedrooms     = SG_Util::val($row,'bedrooms');
			$bathrooms     = SG_Util::val($row,'bathrooms');
			$receptions     = SG_Util::val($row,'receptions');
			$aid_pid = substr($row->web_link, (strrpos($row->web_link, '?') ?: -1) +1);
			$aid_pid = str_replace('pid', 'eapid', $aid_pid);
			$aid_pid = str_replace('aid', 'eaaid', $aid_pid);

			//prepare property detail query
			$prop_query = $aid_pid;

			//get property detail url page
			$prop_link = get_permalink($page_detail_url);
			if(strpos($prop_link, '?')!==false){
				$prop_link .= '&'.$prop_query;
			}
			else{
				$prop_link .= '?'.$prop_query;
			}

			$data = array(
				'prop_image' => $prop_image,
				'prop_title' => $prop_title,
				'prop_price' => $prop_price,
				'prop_priority' => $prop_priority,
				'prop_type' => $prop_type,
				'prop_link' => $prop_link,
				'prop_id' => $prop_id,
				'bedrooms' => $bedrooms,
				'bathrooms' => $bathrooms,
				'receptions' => $receptions,
			);

			echo '<li class="col-sm-'.$col_width.'">'.ea_property_block($data).'</li>'
		?>
	<?php endforeach; endif; ?>
</ul>
<!-- post-list -->