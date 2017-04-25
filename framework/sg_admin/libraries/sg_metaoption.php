<?php 

use Scienceguard\SG_Util;
use Scienceguard\SG_Form;

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
				SG_Builder::form_init();
				SG_Builder::init();
				add_action('admin_enqueue_scripts', array($this, '_admin_enqueue_scripts'));
			}
		}
		
		function _admin_enqueue_scripts() {
			// wp_enqueue_script('sg-theme-options', SG_ADMIN_URL.'/assets/scripts/sg-theme-options.js', array('sg-form') );
			// wp_enqueue_script('sg-theme-settings', SG_ADMIN_URL.'/assets/scripts/sg-theme-settings.js', 'sg-theme-options');
			
			// css
			wp_enqueue_style('sg-bootstrap', SG_ADMIN_URL.'/assets/css/sg-bootstrap.css');
			wp_enqueue_style('sg-framework', SG_ADMIN_URL.'/assets/css/sg-framework.css');
		}
		
		function defaults(){
			$fields = SG_Util::arrayLinear($this->fields);
			$default_values = array();
			
			if(!is_array($fields)){
				return false;	
			}
			
			foreach($fields as $field){
				$field_name = SG_Util::val($field, 'id');
				$field_default = SG_Util::val($field, 'default');
				$field_child = SG_Util::val($field, 'fields');
				
				if($field_name){
					$default_values[$field_name] = $field_default;
				}
			}
					
			return $default_values;
		}
		
		function _save($input) {
			$fields = SG_Util::arrayLinear($this->fields);
			$output = array();
							
			// return default value when reset
			if(isset($_POST['reset']) && $_POST['reset']=='reset'){
				return $this->defaults();
			}

			// make backup
			if(isset($_POST['backup']) && $_POST['backup']=='backup'){
				$backup = array(
					'date' => time(),
					'data' => $input,
				);
				update_option($this->id.'_backup', json_encode($backup));
			}

			// do restore
			if(isset($_POST['restore']) && $_POST['restore']=='restore'){
				$backup = (array) @json_decode(trim(get_option($this->id.'_backup')));
				if(isset($backup['data'])){
					return $backup['data'];
				}
			}

			// do import
			if(isset($_POST['import']) && $_POST['import']=='import' && isset($_POST['import_code'])){
				$input = (array) json_decode(base64_decode(trim(@$_POST['import_code'])));
			}
			
			// loop through fields and save the data
			foreach ( $fields as $field ) {
				$field_name = SG_Util::val($field, 'id');
				$field_type = SG_Util::val($field, 'type');
				
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
														
						$new = SG_Builder::sanitize($new, $sanitizer);	
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
			// add_menu_page($this->title, $this->title, 'manage_options', $this->id.'_menu', array($this, '_menu_cb'));		
			add_theme_page($this->title, __('Theme Options', SG_THEME_ID), 'manage_options', $this->id.'_menu', array($this, '_menu_cb'));
		}
		
		function _menu_cb(){
			?>
			<script type="text/javascript">
				var theme_option_prefix = '<?php echo SG_Util::slug($this->id) ?>';
			</script>

			<h2></h2>
			<!-- wp message placeholder -->

			<form rel="" action="options.php" method="post" enctype="multipart/form-data" >
				<?php settings_fields($this->id.'_settings') ?>
				<div class="sgtb sg-to-wrapper">
					<div class="sg-to-container sgtb-container" id="<?php echo SG_Util::slug($this->id.'-to-container'); ?>">
						
						<div class="sg-to-header">
							<div class="sg-to-logo"><h3><?php echo '<strong>'.$this->title.'</strong> Options' ?></h3></div>
							<div class="icon32 icon-settings"></div>
						</div>
						<!-- header -->						
						<div class="sg-to-toolbar">
							<div class="sgtb-navbar-left">
								<a class="button sg-to-expand collapse"><i class="sg-icon icon-expand">&nbsp;</i></a>
								<button class="sgtb-btn sgtb-btn-default sg-to-reset" name="reset" value="reset">Reset Options</button>
							</div>
							<div class="sgtb-navbar-right">
								<button class="sgtb-btn sgtb-btn-primary sg-to-save" name="save" value="save">Save All Changes</button>
							</div>
						</div>
						<!-- toolbar -->
						
						<div class="sg-to-content">
							<div class="sgtb-row">
								<div class="sgtb-col-sm-3 sg-to-side">
									<div class="sgtb-collapse sgtb-navbar-collapse">
										<ul class="sgtb-nav sgtb-navbar-nav sgtb-navbar-vertical">
											<?php echo SG_Builder::nav_builder($this->fields); ?>
										</ul>
									</div>
								</div>
								<!-- tab nav -->
								<div class="sgtb-col-sm-9 sg-to-main">
									<div class="sgtb-tab-content bg-white">
										<?php echo SG_Builder::form_builder($this->fields,get_option($this->id),0,array('prefix'=>$this->id, 'form_type'=>'sg_metaoption', 'form_id'=>$this->id)); ?>
									</div>
								</div>
								<!-- tab group -->
							</div>
							<!-- row -->
						</div>
						<!-- content -->
						
						<div class="sg-to-toolbar">
							<div class="sgtb-navbar-left">
								<button class="sgtb-btn sgtb-btn-default sg-to-reset" name="reset" value="reset">Reset Options</button>
							</div>
							<div class="sgtb-navbar-right">
								<button class="sgtb-btn sgtb-btn-primary sg-to-save" name="save" value="save">Save All Changes</button>
							</div>
						</div>
						<!-- toolbar -->
					</div>
					<!-- container -->
				</div>
				<!-- wrap -->	
				</form>
			
			<?php
		}
	}
}