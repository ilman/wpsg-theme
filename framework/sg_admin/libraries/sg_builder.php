<?php 

use Scienceguard\SG_Util;
use Scienceguard\SG_Form;
use Scienceguard\SG_FormBs;

if(!class_exists('SG_Builder')){
	Class SG_Builder{

		static function init(){
			// wp_register_script('sg-form-tab', SG_ADMIN_URL.'/assets/scripts/sg_form_tab.js', array('sg-form'));
			// wp_enqueue_script('sg-form-tab');
		}

		static function form_init(){
			add_action('admin_enqueue_scripts', array(__CLASS__, 'form_admin_enqueue_scripts'));
		}

		static function form_admin_enqueue_scripts() {
			// js
			wp_register_script('sg-font-google', SG_ADMIN_URL.'/assets/js/min/google-fonts.min.js', array(), '', false);
			// wp_localize_script('sg-font-google', '$font_google', SG_Wp::get_google_font_json());
			wp_enqueue_script('sg-font-google');

			$deps = array( 'jquery' );
			$deps[] = 'jquery-ui-slider';
			$deps[] = 'jquery-ui-sortable';

			/*----wp media manager----*/
			if(function_exists('wp_enqueue_media')) {
				//call for new media manager
				wp_enqueue_media();
			}
			else {
				//old thickbox upload
				$deps[] = 'media-upload';
				$deps[] = 'thickbox';
			}
			
			wp_enqueue_script('sg-form-plugins', SG_ADMIN_URL.'/assets/js/min/plugins.min.js', array('jquery'), NULL );
			$deps[] = 'sg-form-plugins';

			wp_enqueue_script('sg-form', SG_ADMIN_URL.'/assets/js/sg-form.js', $deps, NULL );
			wp_enqueue_script('sg-form-upload', SG_ADMIN_URL.'/assets/js/sg-form-upload.js', array('sg-form'), NULL );

			
			// css		
			wp_enqueue_style('thickbox');	
			wp_enqueue_style( 'sg-bootstrap', SG_ADMIN_URL.'/assets/css/sg-bootstrap.css');
			wp_enqueue_style( 'sg-framework', SG_ADMIN_URL.'/assets/css/sg-framework.css');
			wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css');
		}

		static function nav_builder($fields, $i=0, $has_active=false){
			$output = '';
			$is_child = ($i>0) ? true : false;
			
			foreach($fields as $field){
				
				$field_label = SG_Util::val($field,'label');
				$field_icon = SG_Util::val($field,'icon', SG_ADMIN_URL.'/assets/images/icons/cog.png');
				$toggle_icon = SG_ADMIN_URL.'/assets/images/icons/cog.png';
				
				if($field['type']==='heading'){
					$field_child = SG_Util::val($field,'fields');
					$field_icon = '<span class="sg-to-icon"><img src="'.$field_icon.'" alt="&bull;" /></span>';
					$li_class = 'tab-'.SG_Util::slug($field_label);

					if($has_active){
						$li_class = trim($li_class);
					}
					else{
						$li_class = trim($li_class.' active');
						$has_active = true;
					}
					
					if($field_child){
						$field_child = self::nav_builder($field_child, $i+1, $has_active);
					}
					
					if($field_child){
						$output .= '<li class="'.$li_class.' parent">';
						$output .= '<a>'.$field_icon.' '.ucwords($field_label).' <i class="caret"></i></a>';
						$output .= '<ul>'.$field_child.'</ul>';
					}
					else{
						$output .= '<li class="'.$li_class.'">';
						$output .= '<a href="#tab-'.SG_Util::slug($field_label).'" data-toggle="tab">';
						$output .= ($is_child) ? '' : $field_icon.' ';
						$output .= ucwords($field_label).'</a>';
					}
					$output .= '</li>';
					$i++;	
				}
			}
			
			return $output;
		}
		
		static function form_builder($fields, $values=array(), $i=0, $args=array()){
			$is_child = ($i>0) ? true : false;
			$output = '';

			$prefix = SG_Util::val($args,'prefix');
			$form_id = SG_Util::val($args,'form_id');
			$form_type = SG_Util::val($args,'form_type');
			$form_class = SG_Util::val($args, 'form_class');
			$context = SG_Util::val($args, 'context');
			$has_active = SG_Util::val($args, 'has_active', false);

			// $output .= ($is_child) ? '' : '<div class="sg-form-container">';


			foreach($fields as $field):
				$field_label = SG_Util::val($field,'label');
				$field_id = SG_Util::val($field,'id');
				$field_name = $field_id;
				$field_type = SG_Util::val($field,'type');
				$field_desc = SG_Util::val($field,'desc');
				$field_attr = SG_Util::val($field,'attr');
				$field_default = SG_Util::val($field,'default');
				$field_options = SG_Util::val($field,'options');

				$field_value = SG_Util::val($field, 'value');
				if($field_value===null){
					$field_value = SG_Util::val($values, $field_id);
				}

				$field_child = SG_Util::val($field,'fields');
				$field_trigger = SG_Util::val($field,'trigger');
				$field_bind = SG_Util::val($field,'binding');
				$field_class = SG_Util::val($field_attr, 'class');
				$field_data_code = htmlspecialchars(SG_Util::val($field_attr,'data-code'));
				$field_data_param = SG_Util::val($field_attr,'data-param');
				$field_data_param_type = SG_Util::val($field_attr,'data-param-type');

				//prepare field attr
				if(!is_array($field_attr)){
					$field_attr = array();
				}

				if($field_data_code){
					$field_attr['data-code'] = $field_data_code;
					$field_attr['class'] = trim($field_class.' data-code');
				}

				if($field_trigger){
					$field_attr['class'] = trim($field_class.' trigger');
					$field_attr['rel'] = SG_Util::slug($field_id);
				}
				
				if($field_bind){
					$field_attr['class'] = trim($field_class.' binded bind-'.SG_Util::slug(SG_Util::val($field_bind,'trigger')).' '.SG_Util::val($field_bind,'value'));
						
				}

				//overwrite metabox field
				if($form_type=='sg_metabox'){
					$field_value = ($field_name) ? sg_get_metadata('post', get_the_ID(), $field_name, true) : null;
				}
				
				//overwrite metaoption field
				if($form_type=='sg_metaoption'){
					$field_name = $prefix.'['.$field_id.']';
				}

				//overwrite metashortcode field
				if($form_type=='sg_metashortcode'){
					$field_attr['no_id'] = true;
					$field_attr['data-param'] = ($field_data_param) ? $field_data_param : '{param}';
					$field_attr['data-param-type'] = ($field_data_param_type == 'content') ? 'content' : 'attr';
				}
									
				if($field['type']=='heading'){
					if($i > 0){
						$output .= '</div><!-- tab item heading -->';	
					}

					if($has_active){
						$field_attr['class'] = trim('sgtb-tab-pane '.$field_class);
					}
					else{
						$field_attr['class'] = trim('sgtb-tab-pane active '.$field_class);
						$has_active = true;
					}

					$field_attr['rel'] = SG_Util::slug($field_label);
					$field_attr['id'] = SG_Util::slug('tab-'.$field_label);

					$output .= '<div '.self::inline_attr($field_attr).'>';
					$output .= '<h2 class="sg-form-title">'.ucwords($field_label).'</h2>';
					if($field_child){
						if($has_active){
							$args['has_active'] = true;
						}
						else{
							$args['has_active'] = false;
						}
						$output .= self::form_builder($field_child, $values, $i+1, $args);
					}
					$i++;
				}
				elseif($field['type']=='info'){
					$output .= '<div class="sgtb-form-group sgtb-row row-'.SG_Util::slug($field_type).'"><div class="option">';
					$output .= '<div class="controls">'.$field_desc.'</div>';
					$output .= '</div></div><!-- sg-section -->';
				}
				elseif($field['type']=='button_insert'){
					$output .= '<div class="sgtb-form-group sgtb-row row-'.SG_Util::slug($field_type).'">';
					$output .= '<div class="option"><button type="button" class="sg-insert-shortcode button button-primary" rel="'.$form_id.'">Insert Shortcode</button></div>';
					$output .= '</div><!-- sg-section -->';
				}
				elseif($field['type']=='fieldset'){
					$field_attr['class'] = trim('sg-section-set '.$field_class);
					$field_attr['rel'] = SG_Util::slug($field_label);

					$output .= '<fieldset '.self::inline_attr($field_attr).'><legend>'.$field_label.'</legend>';
					if($field_child){
						$output .= self::form_builder($field_child, $values, $i, $args);
					}
					$output .= '</fieldset>';
				}
				elseif($field['type']=='fieldset_open'){
					$field_attr['class'] = trim('sg-section-set '.$field_class);
					$field_attr['rel'] = SG_Util::slug($field_label);

					$output .= '<fieldset '.self::inline_attr($field_attr).'><legend>'.$field_label.'</legend>';
				}
				elseif($field['type']=='fieldset_close'){
					$output .= '</fieldset>';
				}
				elseif($field['type']=='html_preview'){
					$field_content = SG_Util::val($field,'content');
					$field_content_file = SG_Util::val($field_content,'file','default.php');
					
					$field_attr['class'] = trim('sg-section sg-section-preview '.$field_class);
					$field_attr['id'] = SG_Util::slug($field_id);
					$output .= '<div '.self::inline_attr($field_attr).'><div class="controls">';
					//$output .= '<iframe src="http://localhost/wp-dev/wpsg/?preview=true&content='.$field_content_file.'" '.SG_Util::event_attr($field_attr).' style="'.SG_Util::val($field_attr,'style').'"></iframe>';
					$output .= '</div></div>';
				}
				elseif($field['type']=='backup'){
					$output .= '<div class="sgtb-form-group">';
					$output .= '<div class="sgtb-form-label">'.ucwords($field_label).'</div>';
					$output .= '<p>You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.</p>';
					$output .= '<p><button class="sgtb-btn sgtb-btn-default" name="backup" value="backup">Backup</button> <button class="sgtb-btn sgtb-btn-default" name="restore" value="restore">Restore</button></p>';
					// $output .= '</div';

					$backup = trim(get_option($form_id.'_backup'));
					if($backup){
						$backup = (array) @json_decode($backup);
						if(isset($backup['date'])){
							$output .= '<p><em>Last backup: '.date('Y-m-d H:i:s', $backup['date']).'</em></p>';
						}
					}
				}
				elseif($field['type']=='transfer'){
					$output .= '<div class="sgtb-form-group">';
					$output .= '<div class="sgtb-form-label">'.ucwords($field_label).'</div>';
					$output .= '<p>You can transfer the saved options data between different installations by copying the text inside the text box. To import data from another installation, replace the data in the text box with the one from another installation and click "Import Options".</p>';
					$output .= '<p><textarea class="sgtb-form-control" rows="10" name="import_code" style="color:#999">'.base64_encode(json_encode(sg_opt())).'</textarea></p>';
					$output .= '<p><button class="sgtb-btn sgtb-btn-default" name="import" value="import">Import Options</button></p>';
					// $output .= '</div';
				}
				else{
					$field_desc = ($field_desc) ? '<p class="sgtb-help-block">'.$field_desc.'</p>' : '';
								

					if($context == 'side'){
						$output .= '<div class="sgtb-form-group row-'.SG_Util::slug($field_type).'">';
						$output .= '<div class="sgtb-form-label">'.$field_label.'</div>';
						$output .= '<div class="sgtb-form-content">';
					}
					else{
						$output .= '<div class="sgtb-form-group sgtb-row row-'.SG_Util::slug($field_type).'">';
						$output .= '<div class="sgtb-form-label sgtb-col-sm-4">'.$field_label.'</div>';
						$output .= '<div class="sgtb-form-content sgtb-col-sm-8">';
					}
					
					// $output .= '<div class="controls">';
					if(SG_Util::val($field,'repeat')){
						$field_default = (is_array($field_default) && isset($field_default[0])) ? $field_default : array('');
						$field_value = (is_array($field_value) && isset($field_value[0])) ? $field_value : $field_default;
						$output .= '<ul class="repeat-list">';
						
						$j=0; 
						foreach($field_value as $value){
							$this_name = $field_name.'['.$j.']';
							$this_value = SG_Util::val($field_value,$j);
							$this_default = SG_Util::val($field_default,$j);
							
							$output .= '<li class="repeat-item">';
							$output .= SG_FormBs::field($field_type, $this_name, $this_value, $field_attr, $this_default, $field_options);
							$output .= '<a class="repeat-delete"><span class="sg-icon icon-delete"></span></a>';
							$output .= '<a class="repeat-sort"><span class="sg-icon icon-sort"></span></a>';
							$output .= '</li>';
							$j++;
						}
						$output .= '</ul>';
						$output .= '<div class="repeat-more"><a class="repeat-btn"><i class="sg-icon icon-add"></i> Add More</a></div>';
					}
					else{
						if($field['type']=='radio'){
							if(!$field_class){
								$field_class = 'sgtb-radio-block';
							}
							$field_attr['class'] = trim('sgtb-radio '.$field_class.' '.SG_Util::slug($field_name));
						}
						elseif($field['type']=='checkbox' || $field['type']=='switch'){
							if(!$field_class){
								$field_class = 'sgtb-checkbox-block';
							}
							$field_attr['class'] = trim('sgtb-checkbox '.$field_class.' '.SG_Util::slug($field_name));
						}
						else{
							$field_attr['class'] = trim('sgtb-form-control '.$field_class.' '.SG_Util::slug($field_name));
						}
						$output .= SG_FormBs::field($field_type, $field_name, $field_value, $field_attr, $field_default, $field_options);
					}
					// $output .= '</div><!-- controls -->';
					$output .= $field_desc.'</div><!-- form-content -->';
					$output .= '</div><!-- sg-section -->';
				}
				
			endforeach;

			if(!$is_child && $i>0){
				$output .= '</div><!-- tab item -->';
			}
			// $output .= ($is_child) ? '' : '</div><!-- sg-sc-container -->';
			
			return $output;
		}

		static function inline_attr($attr=array()){
			$inline_attr = '';
			$allowed_attr = array('class','type','value','name','placeholder','readonly','disabled','rel','id','style','selected','checked','rows','multiple');

			if(!is_array($attr) && !is_object($attr)){ return false; }
						
			foreach($attr as $key => $val){
				if(in_array($key, $allowed_attr) || strpos($key,'data-')===0){
					$inline_attr .= $key.'="'.htmlspecialchars($val).'" ';
				}
			}
			
			return $inline_attr;	
		}


		static function sanitize( $string, $function = 'text_field' ) {
			switch ( $function ) {
				case 'int':
					return intval( $string );
				case 'absint':
					return absint( $string );
				case 'post':
					return wp_kses_post( $string );
				case 'data':
					return wp_kses_data( $string );
				case 'url':
					return esc_url_raw( $string );
				case 'email':
					return sanitize_email( $string );
				case 'title':
					return sanitize_title( $string );
				case 'boolean':
					return form_sanitize_boolean( $string );
				case 'repeat':
					if(is_array($string)){
						return array_values( $string );
					}
					else{
						return $string;
					}
				case 'text_field':
					return sanitize_text_field( $string );
				default:
					return $string;
			}
		}
	}
}