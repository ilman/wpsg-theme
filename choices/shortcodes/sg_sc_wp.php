<?php 

function sc_sg_template_url(){
	return get_template_directory_uri();
}
add_shortcode('sg_template_url', 'sc_sg_template_url');