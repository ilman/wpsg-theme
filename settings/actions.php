<?php 

function sg_author_page_content(){
	if(is_archive() && is_author()){
	?>
		<div class="block thumb-left block-author">
			<div class="block-thumb">
				<?php echo get_avatar($email = '', $size = '100'); ?>
			</div>
			<div class="block-body">
				We all like a bit of insider knowledge when it comes to travelling. And it's no different when it comes to holiday tipples. We'll ask friends – or trawl TripAdvisor – to find out where the best bars are, what to drink, and how to replicate the best cocktails back home. So, hot on the heels of part 1
			</div>
		</div>
	<?php	
	}
}
add_action('sg_content_header','sg_author_page_content');

function sg_content_pagination(){
	$pagination = sg_opt('pagination');
	if($pagination=='load_more'){
		sg_load_more();
	}
	elseif($pagination=='numbers'){
		sg_pagination();
	}
	else{
		sg_content_nav('nav-below');
	}
}
add_action('sg_content_footer','sg_content_pagination');

function sg_create_dynamic_css($input){
	$css_cache_dir = wp_upload_dir();
	$css_cache_dir = $css_cache_dir['basedir'];
	
	if(!is_dir($css_cache_dir)){
		$dir_exists = wp_mkdir_p($css_cache_dir);
		@chmod($dir_exists, 0777);
	}
	
	ob_start();
	include('action_create_css.php');
	file_put_contents($css_cache_dir.'/style-cache.css', ob_get_clean());
}
add_action('sg_to_save','sg_create_dynamic_css');

function sg_admin_menu_js(){
	//wp_enqueue_script('test_asd', plugins_url( 'test.js' , __FILE__ ), array('jquery'), NULL );
}
add_action('admin_init','sg_admin_menu_js');

/*function my_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'tai kucing Updated!', 'my-text-domain' ); ?></p>
    </div>
    <?php
}
add_action('admin_notices', 'my_admin_notice');*/


function sg_admin_enqueue_scripts() {
    wp_enqueue_style('sg-admin', SG_FRAMEWORK_URL.'/assets/css/admin.css');
}
add_action('admin_enqueue_scripts', 'sg_admin_enqueue_scripts');


function sg_add_tags_to_page() {
    register_taxonomy_for_object_type( 'post_tag', 'page' );
}
add_action('init' , 'sg_add_tags_to_page');



function sg_print_script($param) {
	$content = sg_theme_options($param);

	if(!$content){
		return;
	}

	if(strpos($content, '<script') !== false){
		print_r($content);
	}
	else{
		echo "\n".'<script type="text/javascript">'."\n";
		print_r($content);
		echo "\n".'</script>'."\n";
	}
}

function sg_head_script(){
	sg_print_script('script_head');
}
add_action('wp_head', 'sg_head_script');

function sg_foot_script(){
	sg_print_script('script_foot');
}
add_action('wp_footer', 'sg_foot_script');

function choices_property_redirect(){
	if (is_admin()){
		return;
	}

	$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if(strpos($url, '/property-details.html') !== false){
		$str = urldecode($_SERVER['QUERY_STRING']);
		parse_str($str, $arr);

		$eaaid = isset($arr['aid']) ? '{'.$arr['aid'].'}' : '';
		$eapid = isset($arr['pid']) ? $arr['pid'] : '';

		$redirect = site_url('/property-details/?eaaid='.$eaaid.'&eapid='.$eapid);

		wp_redirect($redirect);
		exit();
	}
}
add_action('init', 'choices_property_redirect');

function my_form_phone_cleaner($form){

	$fields = SG_Util::val($form, 'fields');
	foreach($fields as $key_field=>$field){
		$label = SG_Util::val($field, 'label');
		
		if(trim($label) == 'Phone Number'){
			$input_id = SG_Util::val($field, 'id');

			break;
		}
	}

	if(isset($input_id) && isset($_POST['input_'.$input_id])){
		$_POST['input_'.$input_id] = preg_replace("/[^0-9+]/", '', $_POST['input_'.$input_id]);
	}
}
add_action("gform_pre_submission", "my_form_phone_cleaner");