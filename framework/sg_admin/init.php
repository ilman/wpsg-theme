<?php

require_once (dirname(__FILE__).'/libraries/sg_wp.php');
require_once (dirname(__FILE__).'/libraries/sg_builder.php');
require_once (dirname(__FILE__).'/media-manager/media-manager.php');

define('SG_ADMIN_PATH', SG_Wp::file_base_dir(__FILE__));
define('SG_ADMIN_URL', SG_Wp::file_base_url(__FILE__));

require_once (SG_ADMIN_PATH.'/libraries/sg_metashortcode.php');
require_once (SG_ADMIN_PATH.'/libraries/sg_metabox.php');
require_once (SG_ADMIN_PATH.'/libraries/sg_metaoption.php');
