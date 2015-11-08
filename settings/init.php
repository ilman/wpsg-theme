<?php 

function sg_theme_setup(){ 		
	//Make theme available for translation
	load_theme_textdomain( SG_THEME_ID, get_template_directory() . '/languages' );
	
	//Enable support for post thumbnail
	add_theme_support( 'post-thumbnails' ); 
	
	//Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	//Add post formats (http://codex.wordpress.org/Post_Formats)
	add_theme_support('post-formats', array('quote','video','audio','image'));

	//Tell the TinyMCE editor to use a custom stylesheet
	add_editor_style('assets/css/editor-style.css');
	
	//This theme uses wp_nav_menu()
	register_nav_menus(array(
		'primary' => sg__('Primary Menu'),
		'footer' => sg__('Footer Menu')
	));
	
	//Enable shortcode in widget
	if (!is_admin()){
		add_filter('widget_text', 'do_shortcode', 11);
	}
	
	//This theme use widget area
	register_sidebar( array(
		'name' => 'Primary Sidebar',
		'id' => 'primary_sidebar',
		'before_widget' => '<div id="widget-%1$s" class="widget widget-box box-full %2$s">',
		'after_widget' => '</div><!-- widget -->',
		'before_title' => '<div class="widget-header">',
		'after_title' => '</div>',
	) );

	register_sidebar( array(
		'name' => 'Secondary Sidebar',
		'id' => 'secondary_sidebar',
		'before_widget' => '<div id="widget-%1$s" class="widget widget-box box-full %2$s">',
		'after_widget' => '</div><!-- widget -->',
		'before_title' => '<div class="widget-header">',
		'after_title' => '</div>',
	) );
		
	//Add image size
	if ( function_exists( 'add_image_size' ) ) { 
		//add_image_size( 'square40', 40, 40, true );
		//add_image_size( 'client-image', 220, 60 );
	}
}
add_action('after_setup_theme', 'sg_theme_setup');

/**
 * Theme Wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */
class SG_Wrap {
	// Stores the full path to the main template file
	static $main_template;

	// Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	static $base;

	static function wrap($template) {
		self::$main_template = $template;

		self::$base = substr(basename(self::$main_template), 0, -4);
		
		if ('index' == self::$base) {
			self::$base = false;
		}

		$templates = array('base.php');

		if (self::$base) {
			array_unshift($templates, sprintf('base-%s.php', self::$base ));
		}
		
		return locate_template($templates);
	}
}
add_filter('template_include', array('sg_wrap', 'wrap'), 99);

function sg_wrapper_template_path(){
	return sg_wrap::$main_template;
}
 
function sg_wrapper_template_base() {
	return sg_wrap::$base;
}

function sg_theme_scripts() 
{
	$css_cache_dir = wp_upload_dir();
	$css_cache_url = $css_cache_dir['baseurl'];
	$css_cache_path = $css_cache_dir['basedir'];
	
	$cache_file_url = $css_cache_url.'/style-cache.css';
	$cache_file_path = $css_cache_path.'/style-cache.css';
	$cache_mod_time = (file_exists($cache_file_path)) ? filemtime($cache_file_path) : 0;
	$cache_mod_time = date("Y-m-d-H:i:s", $cache_mod_time);
	
	$theme_file_url = get_template_directory_uri().'/assets/css/theme.css';
	$theme_file_path = TEMPLATEPATH.'/assets/css/theme.css';
	$theme_mod_time = (file_exists($theme_file_path)) ? filemtime($theme_file_path) : 0;
	$theme_mod_time = date("Y-m-d-H:i:s", filemtime($theme_file_path));
	
	//wp_register_style( $handle, $src, $deps, $ver, $media );
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), '', 'all' );
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.min.css', array(), '', 'all' );
	wp_enqueue_style('style-theme', $theme_file_url, array(), $theme_mod_time, 'all' );
	wp_enqueue_style('style-choices', get_template_directory_uri() . '/assets/css/choices.css', array(), '', 'all' );
	wp_enqueue_style('style-hover', get_template_directory_uri() . '/assets/css/hover.css', array(), '', 'all' );
	wp_enqueue_style('style-animate', get_template_directory_uri() . '/assets/css/animate.css', array(), '', 'all' );
	wp_enqueue_style('jquery-isotope', get_template_directory_uri() . '/assets/js/isotope/jquery.isotope.css', array(), '', 'all' );
	wp_enqueue_style('jquery-select2', get_template_directory_uri() . '/assets/js/select2/select2.css', array(), '', 'all' );
	wp_enqueue_style('jquery-magnific-popup', get_template_directory_uri() . '/assets/js/magnific-popup/magnific-popup.css', array(), '', 'all' );
	wp_enqueue_style('jquery-select2-bootstrap', get_template_directory_uri() . '/assets/js/select2-bootstrap-css/select2-bootstrap.css', array(), '', 'all' );
	wp_enqueue_style('theme-dynamic-css', $cache_file_url, array(), $cache_mod_time, 'all' );
	
	// wp_enqueue_style('bootstrap');
	// wp_enqueue_style('font-awesome');
	// wp_enqueue_style('style-theme');
	// wp_enqueue_style('style-choices');
	// wp_enqueue_style('jquery-isotope' );
	// wp_enqueue_style('theme-dynamic-css' );
	
	//wp_register_script( $handle, $src, $deps, $ver, $media );	
	wp_register_script('modernizr', 
		get_template_directory_uri() . '/assets/js/modernizr.min.js');
	wp_register_script('bootstrap-js', 
		get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-inview', 
		get_template_directory_uri() . '/assets/js/inview-zuk/jquery.inview.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-counterup', 
		get_template_directory_uri() . '/assets/js/counterup/jquery.counterup.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-flexslider', 
		get_template_directory_uri() . '/assets/js/flexslider/jquery.flexslider.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-isotope', 
		get_template_directory_uri() . '/assets/js/isotope/jquery.isotope.min.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-isotope-bootstrap', 
		get_template_directory_uri() . '/assets/js/isotope/jquery.isotope.bootstrap.js', 
		array('jquery', 'jquery-isotope'),'1.0.0',true);
	wp_register_script('jquery-knob', 
		get_template_directory_uri() . '/assets/js/knob/jquery.knob.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-magnific-popup', 
		get_template_directory_uri() . '/assets/js/magnific-popup/jquery.magnific-popup.min.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-sequence', 
		get_template_directory_uri() . '/assets/js/sequence/scripts/jquery.sequence-min.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('media-element', 
		get_template_directory_uri() . '/assets/js/media-element/mediaelement-and-player.min.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-infinite-scroll', 
		get_template_directory_uri() . '/assets/js/jquery.infinitescroll.min.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-select2', 
		get_template_directory_uri() . '/assets/js/select2/select2.min.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('jquery-match-height', 
		get_template_directory_uri() . '/assets/js/jquery.match-height.js', 
		array('jquery'),'1.0.0',true);


	wp_register_script('google-maps', '//maps.google.com/maps/api/js?sensor=false');

	wp_register_script('sg-animate', 
		get_template_directory_uri() . '/assets/scripts/animate.js', 
		array('jquery'),'1.0.0',true);
	wp_register_script('sg-shortcodes', 
		get_template_directory_uri() . '/assets/scripts/shortcodes.js', 
		array('jquery'),'1.0.0',true);

	wp_register_script(
		'theme-js', 
		get_template_directory_uri() . '/assets/scripts/theme.js', 
		array(
			'modernizr',
			'jquery',
			'bootstrap-js',
			'jquery-inview',
			'jquery-counterup',
			'jquery-flexslider',
			'jquery-isotope',
			'jquery-isotope-bootstrap',
			'jquery-knob',
			'jquery-magnific-popup',
			'jquery-sequence',
			'media-element',
			'jquery-infinite-scroll',
			'jquery-select2',
			'jquery-match-height',
			'google-maps',
			'sg-animate',
			'sg-shortcodes',
		), 
		'', 
		true 
	);
	wp_enqueue_script('theme-js');
		
	
	if(is_singular() && comments_open() && get_option('thread_comments')){
		wp_enqueue_script('comment-reply');
	}
	/*
	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/assets/js/small-menu.js', array( 'jquery' ), '20120206', true );
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/assets/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
	*/
}
add_action( 'wp_enqueue_scripts', 'sg_theme_scripts' );  


function wpcodex_hide_email_shortcode( $atts , $content = null ) {
	
	$content = do_shortcode($content);
	if(!is_email($content)){ return $content; }

	return '<a href="mailto:'.antispambot($content).'">'.antispambot($content).'</a>';
}
add_shortcode( 'email', 'wpcodex_hide_email_shortcode' );