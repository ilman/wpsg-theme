<?php 

if(!class_exists('SG_Form')){
	Class SG_Form{
		static function init(){
			add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_scripts'));
		}

		static function admin_enqueue_scripts() {
			// js
			wp_register_script('sg_font_google', SG_FRAMEWORK_URL.'/assets/scripts/sg_pool.js', array(), '', false);
			wp_localize_script('sg_font_google', '$font_google', sg_get_google_font_json());
			wp_enqueue_script('sg_font_google');

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
			
			wp_enqueue_script('jquery-colorpicker', SG_FRAMEWORK_URL.'/assets/js/colorpicker/js/colorpicker.js', array('jquery'), NULL );
			$deps[] = 'jquery-colorpicker';
			wp_enqueue_script('jquery-cookie', SG_FRAMEWORK_URL.'/assets/js/jquery.cookie.js', array('jquery'), NULL );
			$deps[] = 'jquery-cookie';
			wp_enqueue_script('jquery-toastmessage', SG_FRAMEWORK_URL.'/assets/js/toastmessage/jquery.toastmessage.js', array('jquery'), NULL );
			$deps[] = 'jquery-toastmessage';
			wp_enqueue_script('jquery-select2', SG_FRAMEWORK_URL.'/assets/js/select2/select2.js', array('jquery'), NULL );
			$deps[] = 'jquery-select2';
			wp_enqueue_script('sg-helper', SG_FRAMEWORK_URL.'/assets/scripts/sg_helper.js', NULL, NULL );
			$deps[] = 'sg-helper';

			wp_enqueue_script('sg-form', SG_FRAMEWORK_URL.'/assets/scripts/sg_form.js', $deps, NULL );
			wp_enqueue_script('sg-form-upload', SG_FRAMEWORK_URL.'/assets/scripts/sg_form_upload.js', array('sg-form'), NULL );

			
			// css		
			wp_enqueue_style('thickbox');
			wp_enqueue_style('jquery-colorpicker', SG_FRAMEWORK_URL.'/assets/js/colorpicker/css/colorpicker.css');		
			wp_enqueue_style( 'sg-framework', SG_FRAMEWORK_URL.'/assets/css/sg-framework.css');
		}

		static function _inline_attr($attrs){
			if(is_array($attrs) || is_object($attrs)){
				return sg_util::inline_attr($attrs);
			}
			else{
				return $attrs;
			}
		}
		
		static function field($field_type, $field_name, $value=null, $field_attr='', $default='', $field_options=array()){
			$output = '';
			
			//prepare field_id
			$field_id = sg_util::val($field_attr,'id');
			$field_id = ($field_id) ? $field_id : sg_util::slug($field_name);
			
			//prepare event_attr
			$event_attr = sg_util::event_attr($field_attr);
			
			//prepare select2 class
			if($field_type=='select2'){
				$field_attr['class'] = trim(sg_util::val($field_attr,'class').' select-select2');	
			}
			
			//prepare select_font class
			if($field_type=='select_font'){
				$field_attr['class'] = trim(sg_util::val($field_attr,'class').' select-font');	
			}
					
			//prepare field_attr
			$prefix = sg_util::val($field_attr,'prefix');
			if(is_array($field_attr)){
				$field_attr['name'] = $field_name;
				if(!isset($field_attr['no_id'])){ 
					$field_attr['id'] = $field_id;
				}
				else{
					$field_attr['data-id'] = $field_id;
				}
			}

			//prepare field_class
			$field_class = sg_util::val($field_attr,'class');

			$value = sg_util::val($value, str_replace('[]', '', $field_name));
			
			if($value===null){
				$value = $default;	
			}
			
			switch($field_type) {
				
				case 'label':
					$output .= '<label '.$field_attr.'>'.$value.'</label>';
				break;
				
				case 'text':
					$field_attr['value'] = $value;
					$param_attr = self::_inline_attr($field_attr);
					$param_attr .= ($event_attr) ? ' '.$event_attr : '';
					$output .= '<input type="text" '.trim($param_attr).'/> ';
				break;
				
				case 'textarea':
					$param_attr = self::_inline_attr($field_attr);
					$param_attr .= ($event_attr) ? ' '.$event_attr : '';
					$output .= '<textarea '.trim($param_attr).'>'.$value.'</textarea>';
				break;
				
				case 'select':  
					$param_attr = self::_inline_attr($field_attr);
					$param_attr .= ($event_attr) ? ' '.$event_attr : '';
					$output .= '<select '.trim($param_attr).'>';  
					foreach ($field_options as $option) {  
						$option['value'] = (isset($option['value'])) ? $option['value'] : $option['label'];
						$output .= '<option value="'.$option['value'].'" '.self::input_checked($value, $option['value'], 'selected').'>'.$option['label'].'</option>';  
					}  
					$output .= '</select> ';  
				break; 
				
				case 'select2':  
					$param_attr = self::_inline_attr($field_attr);
					$param_attr .= ($event_attr) ? ' '.$event_attr : '';
					$output .= '<select '.trim($param_attr).'>';  
					foreach ($field_options as $option) {  
						$option['value'] = (isset($option['value'])) ? $option['value'] : $option['label'];
						$output .= '<option value="'.$option['value'].'" '.self::input_checked($value, $option['value'], 'selected').'>'.$option['label'].'</option>';  
					}  
					$output .= '</select> ';  
				break; 
				
				case 'select_font':  
					$field_attr['value'] = $value;
					$param_attr = self::_inline_attr($field_attr);
					$param_attr .= ($event_attr) ? ' '.$event_attr : '';
					$output .= '<input type="hidden" '.trim($param_attr).'>';
				break;
				
				case 'select_images':  
					foreach ($field_options as $option) { 
						$this_id = $field_id.'-'.sg_util::slug($option['value']);
						$this_checked = self::input_checked($value, $option['value']);
						$option['value'] = (isset($option['value'])) ? $option['value'] : $option['label'];
						
						$field_attr['value'] = $option['value'];
						$field_attr = sg_util::un_set($field_attr,'id');
						$param_attr = self::_inline_attr($field_attr);
						$param_attr .= ($event_attr) ? ' '.$event_attr : '';
						$param_attr .= ($this_checked) ? ' '.$this_checked : '';

						$output .= '<label class="select-image-item '.self::class_checked($value, $option['value']).'" id="'.$this_id.'">';
						$output .= '<input type="radio" '.trim($param_attr).'/>';
						$output .= '<img src="http://placekitten.com/70/60" alt="'.$option['label'].'" />';
						$output .= '</label> ';  
					}  
				break; 
				
				case 'radio':  				
					foreach ($field_options as $option) { 
						$this_id = $field_id.'-'.sg_util::slug($option['value']);
						$this_checked = self::input_checked($value, $option['value']);
						$this_class = sg_util::val($field_attr,'class');
						$option['value'] = (isset($option['value'])) ? $option['value'] : $option['label'];
						
						$field_attr['value'] = $option['value'];
						$param_attr = $field_attr;
						$param_attr = sg_util::un_set($param_attr,'id');
						$param_attr = sg_util::un_set($param_attr,'class');
						$param_attr = self::_inline_attr($field_attr);
						$param_attr .= ($event_attr) ? ' '.$event_attr : '';
						$param_attr .= ($this_checked) ? ' '.$this_checked : '';
						
						$output .= '<label class="'.$this_class.'">';
						$output .= '<input type="radio" '.trim($param_attr).'/> ';
						$output .= $option['label'];
						$output .= '</label> ';  
					}  
				break;
				
				case 'checkbox':
					if(!is_array($field_options)){
						$field_options = array(
							array('label'=>'true', 'value'=>'true')
						);
					}
					foreach ($field_options as $option) { 
						$this_id = $field_id.'-'.sg_util::slug($option['value']);
						$this_checked = self::input_checked($value, $option['value']);
						$this_class = sg_util::val($field_attr,'class');
						$option['value'] = (isset($option['value'])) ? $option['value'] : $option['label'];
						
						$field_attr['value'] = $option['value'];
						$field_attr = sg_util::un_set($field_attr,'id');
						$field_attr = sg_util::un_set($field_attr,'class');
						$param_attr = self::_inline_attr($field_attr);
						$param_attr .= ($event_attr) ? ' '.$event_attr : '';
						$param_attr .= ($this_checked) ? ' '.$this_checked : '';
						
						$output .= '<label class="'.$this_class.'">';
						$output .= '<input type="checkbox" '.trim($param_attr).'/> ';
						$output .= $option['label'];
						$output .= '</label> ';  
					}  
				break;
				
				case 'multicheckbox':  
					foreach ($field_options as $option) { 
						$this_id = $field_id.'-'.sg_util::slug($option['value']);
						$option['value'] = (isset($option['value'])) ? $option['value'] : $option['label'];
						
						$output .= '<label><input type="checkbox" name="'.$field_name.'[]" id="'.$this_id.'" value="'.$option['value'].'" '.self::input_checked($value, $option['value']).' /> '.$option['label'].'</label> ';  
					}  
				break;
							
				case 'slider':				
					$value = ($value) ? $value : 0; 

					$field_attr['value'] = $value;
					$field_attr['class'] = $field_class.$prefix.' ui-slider-value';
					$field_attr['id'] = $field_id; //exception for slider
					$param_attr = self::_inline_attr($field_attr);
					$param_attr .= ($event_attr) ? ' '.$event_attr : '';

					$output .= '<input type="text" readonly="readonly" '.trim($param_attr).'/>';
					$output .= '<div id="'.$field_id.'-slider" class="'.$prefix.' ui-slider"></div> ';
				break;
				
				case 'upload':
					$thumb = ($value) ? '<img src="'.$value.'" />' : '';

					$field_attr['value'] = $value;
					$field_attr['class'] = $field_class.$prefix.' media-upload-url';
					$param_attr = self::_inline_attr($field_attr);
					$param_attr .= ($event_attr) ? ' '.$event_attr : '';

					$output .= '<input type="text" '.trim($param_attr).'/> ';
					$output .= '<button type="button" class="'.$prefix.' button media-upload-button" id="'.$field_id.'-upload">Upload</button>';
					$output .= '<div class="'.$prefix.' media-upload-preview">'.$thumb.'</div> ';
				break;
				
				case 'color':
					$field_attr['value'] = $value;
					$field_attr['class'] = $field_class.$prefix.' color-value';
					$param_attr = self::_inline_attr($field_attr);
					$param_attr .= ($event_attr) ? ' '.$event_attr : '';

					$output .= '<span class="'.$prefix.' input color-placeholder"><span class="'.$prefix.' color-preview" style="background-color:'.$value.'"></span></span> ';
					$output .= '<input type="text" '.trim($param_attr).'/> ';
					$output .= '<button type="button" class="button '.$prefix.' color-button">Select Color</button> ';
				break;
				
			}
			return $output;
		}
		
		static function input_checked($value, $option='', $text='checked'){
			
			if(self::class_checked($value, $option)){
				return $text.'="'.$text.'"';	
			}
				
		} 
		
		static function class_checked($value, $option=false, $text='selected'){
			
			$return = $text;
				
			if(is_array($value)){
				if(in_array($option, $value)){ return $return; }
			}
			
			if($option!==false){
				if($value==$option){ return $return; }
			}
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