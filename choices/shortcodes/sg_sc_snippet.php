<?php 

function sc_sg_snippet($attr){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'id' => '',
		'name' => ''
	), $attr));


	if($name){
		$query = "WHERE post_title = '%s'";
	}
	else{
		$query = "WHERE ID = %d";
	}

	global $wpdb;
	
	$output = $wpdb->get_var( 
		$wpdb->prepare( 
			"
				SELECT post_content
				FROM $wpdb->posts
			".$query,
			$name, $id
		)
	);
	return do_shortcode($output);
}
add_shortcode('sg_snippet', 'sc_sg_snippet');


function sc_sg_code($attr, $content=''){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'id' => '',
		'class' => ''
	), $attr));

	$param_class = trim('well '.$class);

	return '<pre class="'.$param_class.'">'.trim($content).'</pre>';
}
add_shortcode('sg_code', 'sc_sg_code');