<?php 

function sg_get_post_list($type='post'){
	global $wpdb;
		
	$sql_query = "
		SELECT p.ID as value, p.post_title as label
		FROM $wpdb->posts p
		WHERE p.post_type = '$type'
		AND p.post_status = 'publish'
		ORDER BY p.post_title
	";
		
	return $wpdb->get_results($sql_query, ARRAY_A);	
}

function sg_get_taxonomy_list($type='category'){
	global $wpdb;
		
	$sql_query = "
		SELECT t.term_id as value, t.name as label
		FROM $wpdb->terms t
		JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id
		WHERE tt.taxonomy = '$type'
		ORDER BY t.name
	";
		
	return $wpdb->get_results($sql_query, ARRAY_A);	
}

function sg_get_google_font_json(){
	$request = wp_remote_get(SG_THEME_URL.'/gwf.json');
	$response = wp_remote_retrieve_body($request);
	$response = json_decode($response);
	
	$font_list = array();
	foreach($response as $key=>$val){
		$font_list[] = array(
			'id'	=> $key,
			'text'	=> $key
		);
	}
	return $font_list;
}