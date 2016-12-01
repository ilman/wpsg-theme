<?php 

class SG_ThemeAction{

	public static function admin_head(){
		echo '<style type="text/css">'."\n";
		echo ".notice, .update-nag, .settings-error{ display:block !important; }";
		echo '<style type="text/css">'."\n";
	}

	public static function content_pagination(){
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

	function print_script($param) {
		$content = sg_opt($param);

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

	public static function head_script(){
		self::print_script('script_head');
	}

	public static function foot_script(){
		self::print_script('script_foot');
	}

	public static function create_dynamic_css($input){
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
}

add_action('admin_head', array('SG_ThemeAction', 'admin_head'));
add_action('sg_content_footer', array('SG_ThemeAction', 'content_pagination'));
add_action('wp_head', array('SG_ThemeAction', 'head_script'));
add_action('wp_footer', array('SG_ThemeAction', 'foot_script'));
add_action('sg_to_save', array('SG_ThemeAction', 'create_dynamic_css'));
