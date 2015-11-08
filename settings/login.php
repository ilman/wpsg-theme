<?php 

//http://premium.wpmudev.org/blog/create-a-custom-wordpress-login-page/

/*----add custom css to login page----*/

function sg_login_head() {
	echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/assets/css/login.css" />';
}
add_action('login_head', 'sg_login_head');

/*----change login logo link url----*/

function sg_login_logo_url() {
	return get_bloginfo('url');
}
add_filter('login_headerurl', 'sg_login_logo_url');

function sg_login_logo_title() {
	return get_bloginfo('name');
}
add_filter('login_headertitle', 'sg_login_logo_title');
