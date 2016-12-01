<?php 

if(!class_exists('SG_MetaShortcode')){
	class SG_MetaShortcode{
		
		public static $pool = array();
		public $name;
		public $fields;
		public $modal_title = '';
		public $button_title = '';
		public $button_icon;
		public $post_type = array();
		
		function __construct($args){
			global $pagenow;

			if(is_array($args)){
				foreach($args as $key=>$val){
					$this->$key = $val;	
				}
			}

			if(!$this->name){ die("Shortcode name is required"); }
			if(!$this->fields){ die("Shortcode fields is required"); }
			elseif(!is_callable($this->fields)){ die('Shortcode fields must be callable function'); }
			
			$this->fields = call_user_func($this->fields);

			if(!isset($this->post_type) || empty($this->post_type)){
				$this->post_type = array('post','page');
			}
			else{
				if(!is_array($this->post_type)){
					$this->post_type = array($this->post_type);
				}
			}

			if(in_array($pagenow, array('post-new.php', 'post.php'))){
				if(self::_can_output($this)){
					// SG_Form::init();
					// SG_Builder::init();
					add_action('admin_enqueue_scripts', array(new SG_Form, 'init'));
					add_action('admin_enqueue_scripts', array(new SG_Builder, 'init'));
					add_action('admin_footer', array($this,'_render_form'));
					add_action('admin_enqueue_scripts', array($this, '_admin_enqueue_scripts'));
				}
			}

			self::$pool[$this->name] = $this;
		}
		
		static function init(){
			global $pagenow;

			if (!current_user_can('edit_posts') && !current_user_can('edit_pages')){
				return false;
			}		
			
			if(in_array($pagenow, array('post-new.php', 'post.php'))){
				$buttons_array = array();
				foreach(self::$pool as $sc_button){
					if(self::_can_output($sc_button)){
						add_filter('mce_external_plugins', array(__CLASS__,'_register_button_action'));
						add_filter('mce_buttons', array(__CLASS__,'_register_button'));
					}
					$buttons_array[] = array(
						'name'         => $sc_button->name,
						'modal_title'  => $sc_button->modal_title,
						'button_title' => $sc_button->button_title,
						'button_icon' => $sc_button->button_icon,
					);
				}				
			}
		}

		function _admin_enqueue_scripts() {
			global $pagenow;
			if(in_array($pagenow, array('post-new.php', 'post.php'))){
				//js
				// wp_enqueue_script( 'sg-form-tab', SG_ADMIN_URL.'/assets/scripts/SG_Form_tab.js', array('sg-form') );
				
				// css
				// wp_enqueue_style( 'sg-admin', SG_ADMIN_URL.'/assets/css/admin.css');
			}
		}

		static function _can_output($sc_button){
			$can_output = false;
					
			if(!sg_wp::getCurrentPostType()){ $can_output = true; }
			if(in_array(sg_wp::getCurrentPostType(), $sc_button->post_type)){ $can_output = true; }
			if (get_user_option('rich_editing') == 'true'){ $can_output = true;	}
			return $can_output;
		}
		
		static function _register_button($buttons){
			$buttons_array = array();
			array_push($buttons, '|');

			foreach(self::$pool as $sc_button){
				$buttons_array[] = $sc_button->name;
			}

			$buttons = array_merge($buttons,$buttons_array);

			return $buttons;
		}
		
		static function _register_button_action($plugin_array){
			$plugin_array['sg_shortcode_gen'] = SG_ADMIN_URL.'/assets/scripts/sg_metashortcode.js';
			foreach(self::$pool as $sc_button){
				$plugin_array[$sc_button->name] = SG_ADMIN_URL.'/assets/scripts/sg_pool.js';
			}
			return $plugin_array;
		}

		function _render_form(){
			?>
			<div id="<?php echo $this->name ?>" style="display:none;">
				<div class="sg-container sg-sc-container" id="<?php echo $this->name ?>">		
					<div class="sg-form-tab">
						<div class="sg-form-tab-nav">
							<ul>
								<?php echo SG_Builder::nav_builder($this->fields); ?>
							</ul>
						</div>
						<!-- tab nav -->
						<div class="sg-form-tab-group">
							<?php echo SG_Builder::form_builder($this->fields, array(), 0, array('form_class'=>'sg-sc','form_type'=>'sg_metashortcode')); ?>
						</div>
						<!-- tab group -->
					</div>
					<!-- content -->
				</div>
				<!-- container -->
			</div>
			<?php
		}

	}

	add_action('init',array('SG_MetaShortcode','init'));
}