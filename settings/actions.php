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

function my_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'tai kucing Updated!', 'my-text-domain' ); ?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'my_admin_notice' );