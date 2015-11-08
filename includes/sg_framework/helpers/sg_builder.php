<?php 

if(!class_exists('SG_Builder')){
	Class SG_Builder{

		static function init(){
			wp_register_script('sg-form-tab', SG_FRAMEWORK_URL.'/assets/scripts/sg_form_tab.js', array('sg-form'));
			wp_enqueue_script('sg-form-tab');
		}

		static function nav_builder($fields, $i=0){
			$output = '';
			$is_child = ($i>0) ? true : false;
			
			foreach($fields as $field){
				
				$field_label = sg_util::val($field,'label');
				$field_icon = sg_util::val($field,'icon', SG_FRAMEWORK_URL.'/assets/images/icons/cog.png');
				$toggle_icon = SG_FRAMEWORK_URL.'/assets/images/icons/cog.png';
				
				if($field['type']==='heading'){
					$field_child = sg_util::val($field,'fields');
					$field_icon = '<span class="to-icon"><img src="'.$field_icon.'" alt="&bull;" /></span>';
					$li_class = 'tab-'.sg_util::slug($field_label);
					
					if($field_child){
						$field_child = self::nav_builder($field_child, $i+1);
					}
					
					if($field_child){
						$output .= '<li class="'.$li_class.' parent">';
						$output .= '<a>'.$field_icon.' '.$field_label.' <i class="sg-icon icon-toggle"></i></a>';
						$output .= '<ul>'.$field_child.'</ul>';
					}
					else{
						$output .= '<li class="'.$li_class.'">';
						$output .= '<a href="#tab-'.sg_util::slug($field_label).'">';
						$output .= ($is_child) ? '' : $field_icon.' ';
						$output .= $field_label.'</a>';
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

			$prefix = sg_util::val($args,'prefix');
			$form_id = sg_util::val($args,'form_id');
			$form_type = sg_util::val($args,'form_type');
			$form_class = sg_util::val($args, 'form_class');

			$output .= ($is_child) ? '' : '<div class="sg-form-container">';

			foreach($fields as $field):
				$field_label = sg_util::val($field,'label');
				$field_id = sg_util::val($field,'id');
				$field_name = $field_id;
				$field_type = sg_util::val($field,'type');
				$field_desc = sg_util::val($field,'desc');
				$field_attr = sg_util::val($field,'attr');
				$field_default = sg_util::val($field,'default');
				$field_options = sg_util::val($field,'options');

				$field_value = sg_util::val($field, 'value');
				if($field_value===null){
					$field_value = sg_util::val($values, $field_id);
				}

				$field_child = sg_util::val($field,'fields');
				$field_trigger = sg_util::val($field,'trigger');
				$field_bind = sg_util::val($field,'binding');
				$field_class = sg_util::val($field_attr, 'class');
				$field_data_code = htmlspecialchars(sg_util::val($field_attr,'data-code'));
				$field_data_param = sg_util::val($field_attr,'data-param');
				$field_data_param_type = sg_util::val($field_attr,'data-param-type');

				//prepare field attr
				if(!is_array($field_attr)){
					$field_attr = array();
				}

				if($field_data_code){
					$field_attr['data-code'] = $field_data_code;
					$field_attr['class'] = trim(sg_util::val($field_attr,'class').' data-code');
				}

				if($field_trigger){
					$field_attr['class'] = trim(sg_util::val($field_attr,'class').' trigger');
					$field_attr['rel'] = sg_util::slug($field_id);
				}
				
				if($field_bind){
					$field_attr['class'] = trim(sg_util::val($field_attr,'class').' binded bind-'.sg_util::slug(sg_util::val($field_bind,'trigger')).' '.sg_util::val($field_bind,'value'));
						
				}

				//overwrite metabox field
				if($form_type=='sg_metabox'){
					$field_value = ($field_name) ? get_post_meta(get_the_ID(), $field_name, true) : '';
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
					$field_attr['class'] = trim('sg-form-tab-item '.sg_util::val($field_attr,'class'));
					$field_attr['rel'] = sg_util::slug($field_label);
					$field_attr['id'] = sg_util::slug('tab-'.$field_label);

					$output .= '<div '.sg_util::inline_attr($field_attr).'>';
					$output .= '<h2 class="sg-form-title">'.$field_label.'</h2>';
					if($field_child){
						$output .= self::form_builder($field_child, $values, $i+1, $args);
					}
					$i++;
				}
				elseif($field['type']=='info'){
					$output .= '<div class="sg-section sg-section-'.sg_util::slug($field_type).'"><div class="option">';
					$output .= '<div class="controls">'.$field_desc.'</div>';
					$output .= '</div></div><!-- sg-section -->';
				}
				elseif($field['type']=='button_insert'){
					$output .= '<div class="sg-section sg-section-'.sg_util::slug($field_type).'">';
					$output .= '<div class="option"><button type="button" class="sg-insert-shortcode button button-primary" rel="'.$form_id.'">Insert Shortcode</button></div>';
					$output .= '</div><!-- sg-section -->';
				}
				elseif($field['type']=='fieldset'){
					$field_attr['class'] = trim('sg-section-set '.sg_util::val($field_attr,'class'));
					$field_attr['rel'] = sg_util::slug($field_label);

					$output .= '<fieldset '.sg_util::inline_attr($field_attr).'><legend>'.$field_label.'</legend>';
					if($field_child){
						$output .= self::form_builder($field_child, $values, $i, $args);
					}
					$output .= '</fieldset>';
				}
				elseif($field['type']=='fieldset_open'){
					$field_attr['class'] = trim('sg-section-set '.sg_util::val($field_attr,'class'));
					$field_attr['rel'] = sg_util::slug($field_label);

					$output .= '<fieldset '.sg_util::inline_attr($field_attr).'><legend>'.$field_label.'</legend>';
				}
				elseif($field['type']=='fieldset_close'){
					$output .= '</fieldset>';
				}
				elseif($field['type']=='html_preview'){
					$field_content = sg_util::val($field,'content');
					$field_content_file = sg_util::val($field_content,'file','default.php');
					
					$field_attr['class'] = trim('sg-section sg-section-preview '.sg_util::val($field_attr,'class'));
					$field_attr['id'] = sg_util::slug($field_id);
					$output .= '<div '.sg_util::inline_attr($field_attr).'><div class="controls">';
					//$output .= '<iframe src="http://localhost/wp-dev/wpsg/?preview=true&content='.$field_content_file.'" '.sg_util::event_attr($field_attr).' style="'.sg_util::val($field_attr,'style').'"></iframe>';
					$output .= '</div></div>';
				}
				else{
					$field_desc = ($field_desc) ? '<div class="desc">'.$field_desc.'</div>' : '';
								
					$output .= '<div class="sg-section sg-section-'.sg_util::slug($field_type).'">';
					$output .= '<div class="sg-section-label">'.$field_label.$field_desc.'</div>';
					$output .= '<div class="sg-section-option">';
					
					$output .= '<div class="controls">';
					if(sg_util::val($field,'repeat')){
						$field_default = (is_array($field_default) && isset($field_default[0])) ? $field_default : array('');
						$field_value = (is_array($field_value) && isset($field_value[0])) ? $field_value : $field_default;
						$output .= '<ul class="repeat-list">';
						
						$j=0; 
						foreach($field_value as $value){
							$this_name = $field_name.'['.$j.']';
							$this_value = sg_util::val($field_value,$j);
							$this_default = sg_util::val($field_default,$j);
							
							$output .= '<li class="repeat-item">';
							$output .= sg_form::field($field_type, $this_name, $this_value, $field_attr, $this_default, $field_options);
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
							$field_attr['class'] = trim(sg_util::val($field_attr,'class').' '.sg_util::slug($field_name));
						}
						$output .= sg_form::field($field_type, $field_name, $field_value, $field_attr, $field_default, $field_options);
					}
					$output .= '</div><!-- controls -->';
					$output .= '</div>';
					$output .= '</div><!-- sg-section -->';
				}
				
			endforeach;

			if(!$is_child && $i>0){
				$output .= '</div><!-- tab item -->';
			}
			$output .= ($is_child) ? '' : '</div><!-- sg-sc-container -->';
			
			return $output;
		}
	}
}