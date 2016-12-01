<?php 

/**
 * Theme Wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */
class SG_Wrap {
	// Stores the full path to the main template file
	static $main_template;

	// Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	static $base;

	static function wrap($template) {
		self::$main_template = $template;

		self::$base = substr(basename(self::$main_template), 0, -4);
		
		if ('index' == self::$base) {
			self::$base = false;
		}

		$templates = array('framework/sg_wrapper/base.php');

		if (self::$base) {
			array_unshift($templates, sprintf('base-%s.php', self::$base ));
		}
		
		return locate_template($templates);
	}
}
add_filter('template_include', array('sg_wrap', 'wrap'), 99);

// function sg_wrapper_template_path(){
// 	return SG_Wrap::$main_template;
// }
