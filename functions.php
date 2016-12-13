<?php

/*----define constant----*/
define('SG_THEME_PATH', get_template_directory());
define('SG_THEME_URL', get_template_directory_uri());
define('SG_THEME_ID', basename(get_template_directory()));
// define('SG_THEME_OPTIONS', get_option(SG_THEME_ID));

$sg_theme_options = get_option(SG_THEME_ID);


/*----includes files----*/
require_once locate_template('vendor/autoload.php');
require_once locate_template('framework/helpers/wpsg_helpers.php');
require_once locate_template('framework/helpers/admin_helpers.php');
require_once locate_template('framework/sg_wrapper/init.php');
require_once locate_template('framework/sg_admin/init.php');
require_once locate_template('framework/sg_menu/init.php');
require_once locate_template('framework/tgm_plugin/init.php');
require_once locate_template('framework/actions.php');
require_once locate_template('framework/filters.php');
require_once locate_template('front/framework/init.php');
require_once locate_template('front/framework/actions.php');
require_once locate_template('front/framework/filters.php');

// sg_include_path('framework/template_tags');
sg_include_path('front/framework/template_tags');
require_once locate_template('framework/template_tags/sg_content_tags.php');
require_once locate_template('framework/template_tags/sg_paginations.php');

require_once locate_template('framework/plugins/sg_popular_posts/sg_popular_posts.php');
require_once locate_template('framework/plugins/sg_related_posts/sg_related_posts.php');
require_once locate_template('framework/plugins/sg_user_avatar/sg_user_avatar.php');
sg_include_path('/framework/custom_post_types');	
sg_include_path('/framework/shortcodes');	

require_once locate_template('settings/theme_options.php');
require_once locate_template('settings/metaboxes.php');
require_once locate_template('settings/taxonomies.php');

sg_include_path('/choices/custom_post_types');	
sg_include_path('/choices/shortcodes');	
sg_include_path('/choices/widgets');	

require_once locate_template('/choices/ea_api_bak/ea_api.php');			// EA Api
require_once locate_template('/choices/ea_api_bak/ea_api_search.php');	// EA Api
require_once locate_template('/choices/ea_api_bak/ea_api_search_investment.php');	// EA Api
require_once locate_template('/choices/ea_api_bak/ea_api_listing.php');	// EA Api
require_once locate_template('/choices/ea_api_bak/ea_api_details.php');	// EA Api
require_once locate_template('/choices/ea_api_bak/ea_api_featured.php');	// EA Api

require_once locate_template('/choices/ea_api/ea_api.php');			// EA Api
require_once locate_template('/choices/ea_api/ea_api_search.php');			// EA Api
require_once locate_template('/choices/ea_api/ea_api_listing.php');			// EA Api
require_once locate_template('/choices/ea_api/ea_api_details.php');			// EA Api

require_once locate_template('/choices/resales_api.php');	// EA Api
require_once locate_template('/choices/resales_api_search.php');	// EA Api
require_once locate_template('/choices/resales_api_details.php');	// EA Api
