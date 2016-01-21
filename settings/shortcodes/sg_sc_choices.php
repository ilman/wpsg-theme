<?php 

function sc_choices_form($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'title' => 'To find out more, simply fill in the form below.',
		'class'	=> 'image-left',
		'id' => '',
	), $attr));

	$param_class = trim('widget widget-find-out-more '.$class);
	$param_id = ($id) ? ' id="'.$id.'"' : '';

	$output = '<div class="'.$param_class.'"'.$param_id.'>
		<div class="widget-header">
			<div class="sg-title title-fill">'.$title.'</div>
		</div>
		<div class="widget-content">'.do_shortcode($content).'</div>
	</div>';


	return $output;
}
add_shortcode('choices_form', 'sc_choices_form');