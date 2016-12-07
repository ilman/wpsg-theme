<?php 

/*
http://wp.tutsplus.com/tutorials/creative-coding/building-custom-wordpress-widgets/ 
http://www.wpbeginner.com/wp-themes/how-to-add-related-posts-with-a-thumbnail-without-using-plugins/
*/

// require_once(SG_FRAMEWORK_PATH.'/helpers/sg_wp.php');
// require_once(SG_FRAMEWORK_PATH.'/helpers/SG_Form.php');
// require_once(SG_FRAMEWORK_PATH.'/helpers/sg_builder.php');

use Scienceguard\SG_Util;
use Scienceguard\SG_Form;

class Choices_Property_Form_Widget extends WP_Widget {

	private $fields;
	
	public function __construct() {
		
		parent::__construct(
	 		'choices_property_form', // Base ID
			'Choices :: Property Form', // Name
			array( 'description' => __('Showing property form', SG_THEME_ID) ) // Args
		);

		$this->init();
		SG_Builder::form_init();
		SG_Builder::init();

	}

	private function init(){
		$option_layouts = array(
			array('label'=>'Default', 'value'=>''),
			array('label'=>'Full', 'value'=>'layout-full'),
			array('label'=>'Side Right', 'value'=>'layout-side-right'),
			array('label'=>'Side Left', 'value'=>'layout-side-left'),
			array('label'=>'Side Both', 'value'=>'layout-side-both'),
		);

		$this->fields = array(		
			array(
				'label'		=> 'Layout',
				'id'		=> 'title',
				'default'	=> '',
				'type'		=> 'select',
				'options'	=> $option_layouts
			),
			array(
				'label'		=> 'Add Section',
				'id'		=> 'section',
				'default'	=> '',
				'type'		=> 'color'
			),
			array(
				'label'		=> 'Section Class',
				'id'		=> 'section_class',
				'default'	=> '',
				'type'		=> 'text'
			),
			
		);

		
	}
	
	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		global $post;		
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		if ( ! empty( $title ) ){
			echo $before_title . $title . $after_title;
		}
		
		//include(SG_THEME_PATH.'/templates/choices-property-form.php');
		
		echo $after_widget;	
	}
	
	/**
	 * Back-end widget form.
	 */
 	public function form( $values ) {


		$fields = array();

		$i=0;
		foreach($this->fields as $field){
			$fields[$i] = $field;
			$fields[$i]['id'] = $this->get_field_name($field['id']);
			$fields[$i]['value'] = sg_util::val($values, $field['id']);
			$i++;
		}

		SG_Builder::form_init();
		SG_Builder::init();
		echo SG_Builder::form_builder($fields, $values);

		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'cat_slug' ); ?>"><?php _e( 'Exclude Category Slug:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" type="text" value="<?php echo esc_attr( $values['cat_slug'] ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update($input, $old_input) {

		$output = array();

		//loop through fields and save the data
		foreach ( $this->fields as $field ) {
			$field_id = sg_util::val($field, 'id');
			$field_type = sg_util::val($field, 'type');
			
			if( $field_type == 'section' ) {
				$sanitizer = null;
				continue;
			}
			
			//only save exist field in theme options, save all theme option which has an id
			if($field_id){
				if(isset($input[$field_id])){
					$new = $input[$field_id];
					// clean up
					$sanitizer = isset( $field['sanitizer'] ) ? $field['sanitizer'] : 'text_field';
					$sanitizer = is_array($new) ? 'none' : $sanitizer;
					if(isset($field['repeat']) && $field['repeat']==true){
						$sanitizer = 'repeat';
					}
													
					$new = SG_Form::sanitize($new, $sanitizer);	
					$output[$field_id] = $new;
				}
				else{
					$output[$field_id] = '';
				}
			}
		}

		return $output;
	}

}


function register_choices_property_form_widget(){
     register_widget('Choices_Property_Form_Widget');
}

add_action('widgets_init', 'register_choices_property_form_widget');