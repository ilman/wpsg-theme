<?php 

class SG_Flat_Menu extends Walker_Nav_Menu 
{
    function check_current($classes) {
		return preg_match('/(current[-_])|active|dropdown/', $classes);
	}
	
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "\n<ul class=\"dropdown-menu\">\n";
	}
	
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		$args = (object) $args;
				
		$slug = sanitize_title($item->title);
		$id = 'menu-' . $slug;
		
		$class_names = $value = '';
		$li_attributes = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		
		$classes = array_filter($classes, array(&$this, 'check_current'));
		
		if ($custom_classes = get_post_meta($item->ID, '_menu_item_classes', true)) {
			foreach ($custom_classes as $custom_class) {
				$classes[] = $custom_class;
			}
		}
		
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		if (get_post_type() == 'portfolio') {
			$postmeta = get_post_meta(get_queried_object_id(), 'portfolio_page', true);
			if ($item->object_id == $postmeta && isset($postmeta)) $addactive = ' active';
			else {
				if (!$args->has_children) $class_names = '';
				$addactive = '';
			}
		} else $addactive = '';
		
		$class_names = $class_names ? ' class="' . $id . ' ' . esc_attr($class_names) . $addactive . '"' : ' class="' . $id . $addactive . '"';
		
		$output .= $indent . '<li' . $class_names . '>';
		
		$attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
		$attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
		$attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
		$attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';
		
		$item_output  = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
	
	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		if (!$element) { return; }
		
		$id_field = $this->db_fields['id'];
		
		if (is_array($args[0])) {
			$args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
		} 
		elseif (is_object($args[0])) {
			$args[0]->has_children = !empty($children_elements[$element->$id_field]);
		}
		
		$cb_args = array_merge(array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);
		
		$id = $element->$id_field;
		
		if (($max_depth == 0 || $max_depth > $depth+1) && isset($children_elements[$id])) {
			unset($children_elements[$id]);
		}
		
		$cb_args = array_merge(array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}

	public static function no_menu_cb($args=array()){
		echo '<ul class="'.sg_val($args,'menu_class').'">';
		echo '<li>'.__('No Menu Assigned', SG_THEME_ID).'</li>';
		echo '</ul>';
	}
}