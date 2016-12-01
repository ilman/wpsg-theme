<?php 

use Scienceguard\SG_Util;
use Scienceguard\SG_Form;

if(!class_exists('SG_MetaBox')){
	class SG_MetaBox{
		var $id,
			$title,
			$fields,
			$post_type,
			$context = 'normal', //normal, advanced, side
			$priority = 'default'; //high, core, default, low
			
		public function __construct($args) {
			if(is_array($args)){
				foreach($args as $key=>$val){
					$this->$key = $val;	
				}
			}

			if(!$this->id){ die('Metabox id is required'); }
			if(!$this->fields){ die('Metabox fields is required'); }
			elseif(!is_callable($this->fields)){ die('Metabox fields must be callable function'); }
			
			$this->fields = call_user_func($this->fields);
			
			if(!isset($this->post_type) || empty($this->post_type)){
				$this->post_type = array('post','page');
			}
			else{
				if(!is_array($this->post_type)){
					$this->post_type = array($this->post_type);
				}
			}
			
			add_action('admin_enqueue_scripts', array($this, '_admin_enqueue_scripts'));
			add_action('add_meta_boxes', array($this, '_add_box'));
			add_action('save_post',  array($this, '_save_box'));
	    }
		
		function _can_output($object){
			$can_output = false;
					
			if(!SG_WP::getCurrentPostType()){ $can_output = true; }
			if(in_array(SG_WP::getCurrentPostType(), $object->post_type)){ $can_output = true; }
			return $can_output;
		}
		
		function _admin_enqueue_scripts() {
			global $pagenow;
			if(in_array($pagenow, array('post-new.php', 'post.php')) && $this->_can_output($this)){
				//js
				// wp_enqueue_script( 'sg-framework', SG_ADMIN_URL.'/assets/js/metabox.js', array('sg-form') );
				
				// css
				wp_enqueue_style( 'sg-bootstrap', SG_ADMIN_URL.'/assets/css/sg-bootstrap.css');
				wp_enqueue_style( 'sg-framework', SG_ADMIN_URL.'/assets/css/sg-framework.css');
			}
		}
		
		/**
		 * adds the meta box for every post type in $page
		 */
		function _add_box() {
			foreach ( $this->post_type as $post_type ) {
				add_meta_box( $this->id, $this->title, array( $this, '_box_cb' ), $post_type, $this->context, $this->priority );
			}
		}
		
			
		/**
		 * outputs the meta box
		 */	
		function _box_cb() {
			// Use nonce for verification
			wp_nonce_field( 'custom_meta_box_nonce_action', 'custom_meta_box_nonce_field' );
			echo '<div class="sg-container sg-mb-container" id="'.SG_Util::slug($this->id.'-mb-container').'">';
			echo '<div class="sgtb">';
			echo SG_Builder::form_builder($this->fields, array(), 0, array('form_type'=>'sg_metabox', 'context'=>$this->context));
			echo '</div><!-- sgtb -->';
			echo '</div><!-- container -->';
		}
		
		/**
		 * saves the captured data
		 */
		function _save_box($post_id) {
			$post_type = SG_WP::getCurrentPostType();
			
			// verify nonce
			if ( ! isset( $_POST['custom_meta_box_nonce_field'] ) )
				return $post_id;
			if ( ! ( in_array( $post_type, $this->post_type ) || wp_verify_nonce( $_POST['custom_meta_box_nonce_field'],  'custom_meta_box_nonce_action' ) ) ) 
				return $post_id;
			// check autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			// check permissions
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
				
			$fields = SG_Util::arrayLinear($this->fields);
				
			// loop through fields and save the data
			foreach ($fields as $field ) {
				$field_name = SG_Util::val($field, 'id');
				$field_type = SG_Util::val($field, 'type');
				
				if( $field_type == 'section' ) {
					$sanitizer = null;
					continue;
				}
				
				// save the rest
				$new = false;
				$old = get_post_meta( $post_id, $field_name, true );
				if(isset($_POST[$field_name])){
					$new = $_POST[$field_name];
				}
							
				// clean up
				if(isset($new) && '' == $new && $old){
					delete_post_meta( $post_id, $field_name, $old );
				} 
				elseif(isset( $new ) && $new != $old){
					$sanitizer = isset( $field['sanitizer'] ) ? $field['sanitizer'] : 'text_field';
					$sanitizer = is_array($new) ? 'none' : $sanitizer;
					if(isset($field['repeat']) && $field['repeat']==true){
						$sanitizer = 'repeat';
					}
													
					$new = SG_Builder::sanitize($new, $sanitizer);	
														
					update_post_meta( $post_id, $field_name, $new );
				}
			} // end foreach
		}
	}
}