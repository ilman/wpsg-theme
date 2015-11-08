<?php 

require_once(SG_FRAMEWORK_PATH.'/helpers/sg_wp.php');
require_once(SG_FRAMEWORK_PATH.'/helpers/sg_form.php');

if(!class_exists('SG_MetaOption')){
	class SG_MetaOption{
		var $id,
			$title,
			$fields;
		
		public function __construct($args) {

			if(is_array($args)){
				foreach($args as $key=>$val){
					$this->$key = $val;	
				}
			}

			if(!$this->id){ die('Option id is required'); }
			if(!$this->fields){ die('Option fields is required'); }
			elseif(!is_callable($this->fields)){ die('Option fields must be callable function'); }

			$this->fields = call_user_func($this->fields);
					
			//add_action('admin_head',  array($this, 'admin_head'));
			add_action('admin_menu', array($this, '_menu'));				
			add_action('admin_init', array($this, 'init'));
	    }
		
		function init(){
			global $pagenow;
			register_setting($this->id.'_settings', $this->id, array($this, '_save'));
			if(in_array($pagenow, array('admin.php', 'themes.php')) && isset($_GET['page'])){
				sg_form::init();
				sg_builder::init();
				add_action('admin_enqueue_scripts', array($this, '_admin_enqueue_scripts'));
			}
		}
		
		function _admin_enqueue_scripts() {
			wp_enqueue_script('sg-theme-options', SG_FRAMEWORK_URL.'/assets/scripts/sg_theme_options.js', array('sg-form') );
			wp_enqueue_script('sg-theme-settings', SG_FRAMEWORK_URL.'/assets/scripts/sg_theme_settings.js', 'sg-theme-options');
			
			// css
			wp_enqueue_style('thickbox');
			wp_enqueue_style('jquery-colorpicker', SG_FRAMEWORK_URL.'/assets/js/colorpicker/css/colorpicker.css');
			wp_enqueue_style('jquery-toastmessage', SG_FRAMEWORK_URL.'/assets/js/toastmessage/css/jquery.toastmessage.css');
			wp_enqueue_style('sg-framework', SG_FRAMEWORK_URL.'/assets/css/sg-framework.css');
		}
		
		function _defaults(){
			$fields = sg_util::array_linear($this->fields);
			$default_values = array();
			
			if(!is_array($fields)){
				return false;	
			}
			
			foreach($fields as $field){
				$field_name = sg_util::val($field, 'id');
				$field_default = sg_util::val($field, 'default');
				$field_child = sg_util::val($field, 'fields');
				
				if($field_name){
					$default_values[$field_name] = $field_default;
				}
			}
					
			return $default_values;
		}
		
		function _save($input) {
			$fields = sg_util::array_linear($this->fields);
			$output = array();
							
			// return default value when reset
			if(isset($_POST['reset']) && $_POST['reset']=='reset'){
				return $this->_defaults();
			}
			
			// loop through fields and save the data
			foreach ( $fields as $field ) {
				$field_name = sg_util::val($field, 'id');
				$field_type = sg_util::val($field, 'type');
				
				if( $field_type == 'section' ) {
					$sanitizer = null;
					continue;
				}
				
				//only save exist field in theme options, save all theme option which has an id
				if($field_name){
					if(isset($input[$field_name])){
						$new = $input[$field_name];
						// clean up
						$sanitizer = isset( $field['sanitizer'] ) ? $field['sanitizer'] : 'text_field';
						$sanitizer = is_array($new) ? 'none' : $sanitizer;
						if(isset($field['repeat']) && $field['repeat']==true){
							$sanitizer = 'repeat';
						}
														
						$new = sg_form::sanitize($new, $sanitizer);	
						$output[$field_name] = $new;
					}
					else{
						$output[$field_name] = '';
					}
				}
			}

			do_action('sg_to_save');
			
			return $output;
		}
		
		function _menu(){
			add_menu_page($this->title, $this->title, 'manage_options', $this->id.'_menu', array($this, '_menu_cb'));		
			add_theme_page($this->title, 'Theme Options', 'manage_options', $this->id.'_menu', array($this, '_menu_cb'));
		}
		
		function _menu_cb(){
			?>
			<script type="text/javascript">
				var theme_option_prefix = '<?php echo sg_util::slug($this->id) ?>';
			</script>

			<form rel="" action="options.php" method="post" enctype="multipart/form-data" >
				<?php settings_fields($this->id.'_settings') ?>
				<div class="wrap sg-to-wrap">
					<div class="sg-to-container sg-container" id="<?php echo sg_util::slug($this->id.'-to-container'); ?>">
						<h2></h2>
						<div class="sg-to-header">
							<div class="sg-to-logo"><h1><?php echo $this->title.' Options' ?></h1></div>
							<div class="icon32 icon-settings"></div>
						</div>
						<!-- header -->						
						<div class="sg-to-toolbar">
							<div class="pull-left">
								<a class="button sg-to-expand collapse"><i class="sg-icon icon-expand">&nbsp;</i></a>
							</div>
							<div class="pull-right">
								<button class="button-primary sg-to-save" name="save" value="save">Save All Changes</button>
							</div>
						</div>
						<!-- toolbar -->
						
						<div class="sg-form-tab collapse">
							<div class="sg-form-tab-nav">
								<ul>
									<?php echo sg_builder::nav_builder($this->fields); ?>
								</ul>
							</div>
							<!-- tab nav -->
							<div class="sg-form-tab-group">
								<?php echo sg_builder::form_builder($this->fields,get_option($this->id),0,array('prefix'=>$this->id, 'form_type'=>'sg_metaoption')); ?>
							</div>
							<!-- tab group -->
						</div>
						<!-- content -->
						
						<div class="sg-to-toolbar">
							<div class="pull-left">
								<button class="button sg-to-reset" name="reset" value="reset">Reset Options</button>
							</div>
							<div class="pull-right">
								<button class="button-primary sg-to-save" name="save" value="save">Save All Changes</button>
							</div>
						</div>
						<!-- toolbar -->
						<div class="sg-to-footer">Theme Option Framework <strong>1.0.0</strong></div>
					</div>
					<!-- container -->
				</div>
				<!-- wrap -->	
				</form>
			
			<?php
		}
	}
}