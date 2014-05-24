<?php

require_once (dirname(__FILE__).'/helpers/sg_util.php');
require_once (dirname(__FILE__).'/helpers/sg_wp.php');
require_once (dirname(__FILE__).'/helpers/sg_form.php');
require_once (dirname(__FILE__).'/helpers/sg_builder.php');
require_once (dirname(__FILE__).'/media-manager/media-manager.php');

define('SG_FRAMEWORK_PATH', sg_wp::file_base_dir(__FILE__));
define('SG_FRAMEWORK_URL', sg_wp::file_base_url(__FILE__));

require_once (SG_FRAMEWORK_PATH.'/libraries/sg_metashortcode.php');
require_once (SG_FRAMEWORK_PATH.'/libraries/sg_metabox.php');
require_once (SG_FRAMEWORK_PATH.'/libraries/sg_metaoption.php');
