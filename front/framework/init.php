<?php 

class SG_FrontSetup{
	static function setup()
	{			
		//Add image size
		if(function_exists('add_image_size')){ 
			add_image_size('small', 50, 50, true);
			add_image_size('post-thumb', 340, 340, true);			
			add_image_size('post-large', 850, 440);			
			add_image_size('post-featured', 1140, 340, true);			
		}


		//Make theme available for translation
		load_theme_textdomain( SG_THEME_ID, get_template_directory() . '/languages' );
		
		//Enable support for post thumbnail
		add_theme_support('post-thumbnails'); 
		
		//Add default posts and comments RSS feed links to head
		add_theme_support('automatic-feed-links');
		
		//Add post formats (http://codex.wordpress.org/Post_Formats)
		add_theme_support('post-formats', array('quote','video','audio','image'));

		//Tell the TinyMCE editor to use a custom stylesheet
		add_editor_style('assets/css/editor-style.css');
		
		//This theme uses wp_nav_menu()
		register_nav_menus(array(
			'primary' => __('Primary Menu', SG_THEME_ID),
			'footer' => __('Footer Menu', SG_THEME_ID)
		));
		
		//Enable shortcode in widget
		if (!is_admin()){
			add_filter('widget_text', 'do_shortcode', 11);
		}
	}

	public static function widgets_init()
	{
		//This theme use widget area
		register_sidebar(array(
			'name' => 'Primary Sidebar',
			'id' => 'primary_sidebar',
			'before_widget' => '<div id="widget-%1$s" class="widget panel %2$s">',
			'before_title' => '<div class="widget-heading panel-heading"><h4 class="widget-title panel-title">',
			'after_title' => '</h4></div><!-- widget-heading --><div class="widget-body panel-body">',
			'after_widget' => '</div><!-- widget body --></div><!-- widget -->',
		));

		register_sidebar(array(
			'name' => 'Secondary Sidebar',
			'id' => 'secondary_sidebar',
			'before_widget' => '<div id="widget-%1$s" class="widget panel %2$s">',
			'before_title' => '<div class="widget-heading panel-heading"><h4 class="widget-title panel-title">',
			'after_title' => '</h4></div><!-- widget-heading --><div class="widget-body panel-body">',
			'after_widget' => '</div><!-- widget body --></div><!-- widget -->',
		));
		
	}

	static function scripts() 
	{
		$css_cache_dir = wp_upload_dir();
		$css_cache_url = $css_cache_dir['baseurl'];
		$css_cache_path = $css_cache_dir['basedir'];
		
		$cache_file_url = $css_cache_url.'/style-cache.css';
		$cache_file_path = $css_cache_path.'/style-cache.css';
		$cache_mod_time = (file_exists($cache_file_path)) ? filemtime($cache_file_path) : 0;
		$cache_mod_time = date("Y-m-d-H:i:s", $cache_mod_time);
		
		$theme_file_url = get_template_directory_uri().'/front/assets/css/theme.css';
		$theme_file_path = TEMPLATEPATH.'/front/assets/css/theme.css';
		$theme_mod_time = (file_exists($theme_file_path)) ? filemtime($theme_file_path) : 0;
		$theme_mod_time = date("Y-m-d-H:i:s", $theme_mod_time);
		
		//wp_register_style( $handle, $src, $deps, $ver, $media );
		wp_enqueue_style('theme-front', $theme_file_url, array(), $theme_mod_time, 'all' );
		wp_enqueue_style('google-font', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700');
		wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
		wp_enqueue_style('jquery-isotope', get_template_directory_uri() . '/front/assets/vendors/isotope/jquery.isotope.css', array(), '', 'all' );
		
		
		if(file_exists($cache_file_path)){
			wp_enqueue_style('theme-dynamic-css', $cache_file_url, array(), $cache_mod_time, 'all' );
		}
		
		//wp_register_script( $handle, $src, $deps, $ver, $media );	
		// wp_register_script('modernizr', 
		// 	get_template_directory_uri() . '/front/assets/js/modernizr.min.js');

		// wp_register_script('vendors', 
		// 	get_template_directory_uri() . '/front/assets/js/vendors.min.js',
		// 	array('jquery'),'1.0.0',true);

		// wp_register_script('sg-shortcodes', 
		// 	get_template_directory_uri() . '/front/assets/js/shortcodes.js', 
		// 	array('jquery'),'1.0.0',true);

		// wp_register_script('theme-js', 
		// 	get_template_directory_uri() . '/front/assets/js/theme.js', 
		// 	array('vendors'),'',true);
		// wp_enqueue_script('theme-js');



	
		//wp_register_script( $handle, $src, $deps, $ver, $media );	
		wp_register_script('modernizr', 
			get_template_directory_uri() . '/front/assets/vendors/modernizr.min.js');
		wp_register_script('bootstrap-js', 
			get_template_directory_uri() . '/front/assets/vendors/bootstrap/js/bootstrap.min.js', 
			array('jquery'),'1.0.0',true);
		
		wp_register_script('jquery-isotope', 
			get_template_directory_uri() . '/front/assets/vendors/isotope/jquery.isotope.min.js', 
			array('jquery'),'1.0.0',true);
		wp_register_script('jquery-isotope-bootstrap', 
			get_template_directory_uri() . '/front/assets/vendors/isotope/jquery.isotope.bootstrap.js', 
			array('jquery', 'jquery-isotope'),'1.0.0',true);
		
		wp_register_script('jquery-infinite-scroll', 
			get_template_directory_uri() . '/front/assets/vendors/jquery.infinitescroll.min.js', 
			array('jquery'),'1.0.0',true);
		
		wp_register_script('jquery-match-height', 
			get_template_directory_uri() . '/front/assets/vendors/jquery.match-height.js', 
			array('jquery'),'1.0.0',true);


		wp_register_script('google-maps', '//maps.google.com/maps/api/js?sensor=false');

		wp_register_script(
			'theme-js', 
			get_template_directory_uri() . '/front/assets/js/theme.js', 
			array(
				'modernizr',
				'jquery',
				'bootstrap-js',
				'jquery-isotope',
				'jquery-isotope-bootstrap',
				'jquery-infinite-scroll',
				'jquery-match-height',
				// 'google-maps'
			), 
			'', 
			true 
		);
		wp_enqueue_script('theme-js');





			
		
		if(is_singular() && comments_open() && get_option('thread_comments')){
			wp_enqueue_script('comment-reply');
		}
	}
}


add_action('after_setup_theme', array('SG_FrontSetup', 'setup'));
add_action('widgets_init', array('SG_FrontSetup', 'widgets_init'));
add_action('wp_enqueue_scripts', array('SG_FrontSetup', 'scripts'));  