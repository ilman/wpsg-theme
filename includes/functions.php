<?php 

function sg_no_menu_cb($args=array()){
	echo '<ul class="'.sg_val($args,'menu_class').'">';
	echo '<li>'.sg__('No Menu Assigned').'</li>';
	echo '</ul>';
}