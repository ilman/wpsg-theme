<?php

/*----define constant----*/
define('SG_THEME_PATH', get_template_directory());
define('SG_THEME_URL', get_template_directory_uri());
define('SG_THEME_ID', 'sg');
if (!isset($content_width)) $content_width = 900;

/*----includes files----*/
require_once locate_template('/includes/sg_framework/sg_framework.php');			// Utility functions
require_once locate_template('/settings/helpers/helpers.php');				// Initial theme setup and constants
require_once locate_template('/settings/init.php');				// Initial theme setup and constants
require_once locate_template('/settings/tgm_plugin.php');		// Initial theme setup and constants
require_once locate_template('/settings/theme_options.php');	// Back-end functions
require_once locate_template('/settings/actions.php');			// Actions
require_once locate_template('/settings/filters.php');			// Filters
require_once locate_template('/settings/taxonomies.php');		// Taxonomies
require_once locate_template('/settings/rewrite_urls.php');		// URLS
require_once locate_template('/settings/shortcodes.php');		// Global custom shortcodes
require_once locate_template('/settings/metaboxes.php');		// Global custom metaboxes
require_once locate_template('/settings/template_tags.php');	// Template tags
require_once locate_template('/settings/sg_walker_menu.php');	// Menu Walker
require_once locate_template('/settings/login.php');			// Login
require_once locate_template('/settings/ea_api.php');			// EA Api
require_once locate_template('/settings/ea_api_search.php');	// EA Api
require_once locate_template('/settings/ea_api_search_investment.php');	// EA Api
require_once locate_template('/settings/ea_api_listing.php');	// EA Api
require_once locate_template('/settings/ea_api_details.php');	// EA Api
require_once locate_template('/settings/ea_api_featured.php');	// EA Api

require_once locate_template('/settings/resales_api.php');	// EA Api
require_once locate_template('/settings/resales_api_search.php');	// EA Api
require_once locate_template('/settings/resales_api_details.php');	// EA Api

sg_include_path('/settings/custom_post_types');				// Custom post types
sg_include_path('/settings/widgets');						// Widgets
sg_include_path('/settings/template_tags');					// Template Tags
sg_include_path('/settings/shortcodes');					// Shortcodes
sg_include_path('/settings/metaboxes');						// Metaboxes
sg_include_path('/custom');									// Custom files related to the theme

/*---- define theme global variable ----*/
$sg_theme_options = get_option('wpsg_choices');

/*---- generate css file using sg-less plugin -----*/
if(function_exists('compile_less_css')){
	compile_less_css('bootstrap.less', 'bootstrap.css', get_template_directory().'/assets/bootstrap');
	compile_less_css('theme.less', 'theme.css', get_template_directory().'/assets');
	compile_less_css('admin.less', 'admin.css', get_template_directory().'/includes/sg_framework/assets');	
}