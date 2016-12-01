<?php 

$kwirk_product_template = sg_get_post_meta(get_the_ID(), '_kwirk_product_template', true);

if($kwirk_product_template){

	$kwirk_product_template_name = sg_get_post_meta(get_the_ID(), '_kwirk_product_template_name', true);
	$kwirk_template_name = ($kwirk_product_template_name) ? $kwirk_product_template.'-'.$kwirk_product_template_name : $kwirk_product_template;
	$kwirk_template_path = sg_view_path('woocommerce/'.$kwirk_template_name.'.php');
	$kwirk_template_path_alt = sg_view_path('woocommerce/'.$kwirk_product_template.'.php');

	if(file_exists($kwirk_template_path)){
		echo '<div class="'.$kwirk_template_name.'">'."\n";
		include($kwirk_template_path);
		echo '</div>'."\n";
	}
	elseif(file_exists($kwirk_template_path_alt)){
		echo '<div class="'.$kwirk_product_template.'">'."\n";
		include($kwirk_template_path_alt);
		echo '</div>'."\n";
	}
	else{
		include('composite-summary-default.php');
	}
}
else{
	include('composite-summary-default.php');
}