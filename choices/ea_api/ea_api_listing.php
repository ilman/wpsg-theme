<?php 

use Scienceguard\SG_Util;

function get_ea_property_list_new($attr=array()){

	global $wpdb;

	// extract the attributes into variables

	extract(shortcode_atts(array(

		'dep' => 'for-sale',
		'branch' => '',
		'xbranch' => '',
		'district' => '',
		'town' => '',
		'county' => '',
		'area' => '',
		'district_id' => '',
		'area_id' => '',
		'aid' => '',
		'class' => '',
		'style' => '',
		'show_text' => false,

	), $attr));

	

	$query = build_ea_propery_search_query_new($attr);
	$text = build_ea_property_search_text_new($attr);

	$key = 'ea_search_result';
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

	$per_page = 12;
	$current_page = (isset($_GET['eapage'])) ? $_GET['eapage'] : 1;
	$offset = ($current_page - 1) * $per_page;

	$pagination = (array) $wpdb->get_row("SELECT count(*) as `total_rows` FROM wp_ea_properties WHERE $query");
	$pagination['base_url'] = '//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$pagination['per_page'] = $per_page;


	$query = "SELECT id, advert_heading, advert_image, price_text, property_type, property_style, priority, bedrooms, bathrooms, receptions, web_link
			FROM wp_ea_properties
			WHERE $query
			ORDER BY numeric_price ASC
			LIMIT $per_page
			OFFSET $offset";

	$result = $wpdb->get_results($query);

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
			'result' => $result,
			'pagination' => render_ea_pagination_html_new($pagination, 'eapage'),
	);

	if(isset($show_text) && $show_text){
		$data_cache['text'] = $text;
	}

	// dont cache search data :(
	// set_transient($data_key, $data_cache, 60*60); //1 hour

	return render_ea_property_html_new($data_cache);
}
add_shortcode('ea_property_list', 'get_ea_property_list_new');



function get_ea_featured_property_new($attr=array()){

	global $wpdb;

	// extract the attributes into variables

	extract(shortcode_atts(array(

		'dep' => 'for-sale',
		'limit' => 4,
		'cols' => 4,

	), $attr));

	

	$query = build_ea_propery_search_query_new($attr);
	$text = build_ea_property_search_text_new($attr);

	$key = 'ea_search_result';
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

	$per_page = $limit;
	$current_page = (isset($_GET['eapage'])) ? $_GET['eapage'] : 1;
	$offset = ($current_page - 1) * $per_page;

	$pagination = (array) $wpdb->get_row("SELECT count(*) as `total_rows` FROM wp_ea_properties WHERE $query");
	$pagination['base_url'] = '//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$pagination['per_page'] = $per_page;


	$query = "SELECT id, advert_heading, advert_image, price_text, property_type, property_style, priority, bedrooms, bathrooms, receptions, web_link
			FROM wp_ea_properties
			WHERE $query
			LIMIT 4
			OFFSET $offset";

	$result = $wpdb->get_results($query);

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
		'result' => $result,
		// 'pagination' => render_ea_pagination_html_new($pagination, 'featured-list-slider'),
	);

	if(isset($show_text) && $show_text){
		$data_cache['text'] = $text;
	}

	// dont cache search data :(
	// set_transient($data_key, $data_cache, 60*60); //1 hour

	return render_ea_property_html_new($data_cache, 'featured-list-column');
}
add_shortcode('ea_featured_properties', 'get_ea_featured_property_new');

