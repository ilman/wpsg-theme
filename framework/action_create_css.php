/*----fonts----*/
<?php 
if(!function_exists('sg_str_if')){
	function sg_str_if($str,$key,$suffix='',$default=''){
		return (sg_opt($key,$default)) ? $str.sg_opt($key).$suffix.";\r\n" : '';	
	}
}
?>

<?php 
$vars = array(
	'body'	=> 'body',
	'h1'	=> 'heading_1',
	'h2'	=> 'heading_2',
	'h3'	=> 'heading_3',
	'h4'	=> 'heading_4',
	'h5'	=> 'heading_5',
	'h6'	=> 'heading_6'
);
foreach($vars as $key=>$val): 
	echo $key."{\r\n";
	echo sg_str_if('font-family: ', $val.'_font_family');
	echo sg_str_if('font-size: ', $val.'_font_size','px');
	echo sg_str_if('line-height: ', $val.'_line_height','px');
	echo sg_str_if('font-style: ', $val.'_font_style');
	echo sg_str_if('font-weight: ', $val.'_font_weight');
	echo sg_str_if('color: ', $val.'_color');
	echo "}\r\n";
endforeach;
?>

/*----color-set----*/
<?php
for($i=1; $i<=10; $i++): 
	$key = ".color-set-".$i;
	$prefix = 'color_set_'.$i;
	echo "$key{\r\n";
	echo sg_str_if('background-color: ', $prefix.'_background_color');
	echo sg_str_if('color: ', $prefix.'_text_color');
	echo "}\r\n";
	
	echo "$key h1, $key h2, $key h3, $key h4, $key h5, $key h6{\r\n";
	echo sg_str_if('background-color: ', $prefix.'_background_color');
	echo sg_str_if('color: ', $prefix.'_text_color');
	echo "}\r\n";
	
	echo "$key a{\r\n";
	echo sg_str_if('color: ', $prefix.'_accent_color');
	echo "}\r\n";
	
	echo "$key button, $key input[type=button], $key .btn, $key .btn-default{\r\n";
	echo sg_str_if('background-color: ', $prefix.'_accent_color');
	echo "}\r\n";
	
	echo "$key hr, $key .hr{\r\n";
	echo sg_str_if('border-color: ', $prefix.'_line_color');
	echo "}\r\n";
	
	echo ".separator-triangle-out$key:before{\r\n";
	echo sg_str_if('border-top-color: ', $prefix.'_background_color');
	echo "}\r\n";
endfor;
?>

/*----layout----*/

<?php 

echo "#header{\r\n";
echo sg_str_if('padding-top: ', 'header_padding_top','px');
echo sg_str_if('padding-bottom: ', 'header_padding_bottom','px');
echo sg_str_if('height: ', 'header_height','px');
echo "}\r\n";

echo "#subheader{\r\n";
echo sg_str_if('padding-top: ', 'subheader_padding_top','px');
echo sg_str_if('padding-bottom: ', 'subheader_padding_bottom','px');
echo "}\r\n";

echo "#footer{\r\n";
echo sg_str_if('padding-top: ', 'footer_padding_top','px');
echo sg_str_if('padding-bottom: ', 'footer_padding_bottom','px');
echo "}\r\n";

?>

/*----theme option----*/

<?php

echo sg_opt('style_head');

?>