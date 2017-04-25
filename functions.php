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

// require_once locate_template('framework/template_tags/sg_content_tags.php');
// require_once locate_template('framework/template_tags/sg_paginations.php');

sg_include_path('framework/template_tags');
sg_include_path('/framework/custom_post_types');	

require_once locate_template('settings/tgm_plugins.php');
require_once locate_template('settings/theme_options.php');
require_once locate_template('settings/metaboxes.php');

add_filter('jpeg_quality', function($arg){ return 100; });