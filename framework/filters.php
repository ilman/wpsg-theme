<?php 

class SG_ThemeFilter{

	function widget_empty_title($output='') {
		if ($output == '') {
			return ' ';
		}
		return $output;
	}

	function widget_class($params){
		$params[0]['before_widget'] = str_replace('_','-',$params[0]['before_widget']);
		return $params;
	}

	function wp_title($title, $sep) {
		global $paged, $page;

		if(is_feed()){
			return $title;
		}

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo('description', 'display');
		if($site_description && (is_home() || is_front_page())){
			$title = "$title $sep $site_description";
		}

		// Add a page number if necessary.
		if($paged >= 2 || $page >= 2){
			$title = "$title $sep " . sprintf(__('Page %s', SG_THEME_ID), max($paged, $page));
		}

		return $title;
	}
}

add_filter('widget_title', array('SG_ThemeFilter', 'widget_empty_title'));
add_filter('dynamic_sidebar_params', array('SG_ThemeFilter', 'widget_class'));
add_filter('wp_title', array('SG_ThemeFilter', 'wp_title'), 10, 2);
