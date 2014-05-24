<!DOCTYPE HTML>
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>

<!-- ****basic page needs**** -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php wp_title('|', true, 'right'); ?></title>

<!-- ****responsive viewport**** -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- ****wordpress enqueue**** -->
<?php wp_head(); ?>
<style>
	html{ margin-top:0 !important; }
	body{ padding:20px !important; }
	#wpadminbar{ display:none !important; }
</style>
</head>

<body>
<?php 
	$content = sg_val($_GET,'content');
	if($content){
		include(SG_THEME_PATH.'/settings/previews/'.$content);
	}
?>
<?php wp_footer(); ?>
</body>
</html>
