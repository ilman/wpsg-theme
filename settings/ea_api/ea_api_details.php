<?php 

function get_ea_property_details_new($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => '',
		'style' => '',
	), $attr));

	global $wpdb;

	$key = 'ea_property_details';
	if(is_array($attr)){
		foreach($attr as $row){
			if(is_array($row)){
				foreach($row as $r){
					$key .= '_'.$r;
				}
			}
			else{
				$key = '_'.$row;
			}
		}
	}


	if(!isset($pid)){
		$pid = (isset($_GET['pid'])) ? $_GET['pid'] : 0;
	}

	$key .= ($pid) ? '_pid_'.$pid : '';

	if(!isset($eapid)){
		$eapid = (isset($_GET['eapid'])) ? $_GET['eapid'] : '';
	}

	$key .= ($eapid) ? '_eapid_'.$eapid : '';

	if($eapid){
		$query = "SELECT *
			FROM wp_ea_properties
			WHERE web_link like '%$eapid%'
			LIMIT 1";
	}
	else{
		$query = "SELECT *
			FROM wp_ea_properties
			WHERE id = $pid
			LIMIT 1";
	}

	$row = $wpdb->get_row($query);

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

	$data_cache = array(
			'url' => '',
			'row' => $row,
			'cache_key' => $key,
	);

	// dont cache search data :(
	// set_transient($data_key, $data_cache, 60*60); //1 hour

	return render_ea_property_html_new($data_cache, 'property-details');
}
add_shortcode('ea_property_details', 'get_ea_property_details_new');

