<?php

use Scienceguard\SG_Util;

Class SG_ScFramework
{
	static $collapse_count = 0;
	static $collapse_content_count = 0;
	static $gmap_count = 0;

	function sg_section($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'color_set' => '',
			'separator' => '',
			'wrapper' => '',
			'class' => ''
		), $attr));
		
		$param = trim("page-section $color_set $separator $class");
		$output = '<div class="'.$param.'">'.do_shortcode($content).'</div>';

		return $output;
	}
	

	function sg_row($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'class' => ''
		), $attr));
		
		$param = trim("row $class");
		$output = '<div class="'.$param.'">'.do_shortcode($content).'</div>';

		return $output;
	}



	function sg_col($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'width' => '12',
			'view' => 'sm',
			'offset' => '',
			'class' => ''
		), $attr));
		
		//verify width value
		if($width>=1 && $width<=12){
			$width = 'col-'.$view.'-'.$width;
		}
		else{
			$width = 'col-'.$view.'-12';
		}

		//verify offset value
		if($offset>=1 && $offset<=12){
			$offset = 'col-'.$view.'-offset-'.$offset;
		}
		else{
			$offset = '';
		}

		$param = trim("$width $offset $class");
		$output = '<div class="'.$param.'">'.do_shortcode($content).'</div>';

		return $output;
	}



	function sg_spacer($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'height' => 0,
			'style' => '',
			'class' => ''
		), $attr));
		
		$param_class = trim("vspace $class");
		$param_style = trim("$style");

		
		//verify height
		if($height){
			$param_style .= ' height:'.$height;
		}

		//finalize param_style
		$param_style = ' style="'.$param_style.'"';

		$output = '<div class="'.$param_class.'"'.$param_style.'></div>';

		return $output;
	}



	function sg_divider($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'style' => '',
			'class' => ''
		), $attr));
		
		//verify style
		if($style){
			$style = 'divider-'.$style;
		}
		
		$param_class = trim("divider divider-solid-line $style $class");
		$output = '<div class="'.$param_class.'"></div>';

		return $output;
	}



	function sg_divider_icon($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'style' => '',
			'icon' => '',
			'icon_class' => '',
			'class' => ''
		), $attr));

		//verify style
		if($style){
			$style = 'divider-'.$style;
		}

		$param_class = trim("sg-title title-divider $style $class");
		$param_icon = trim("fa fa-$icon $icon_class");

		$output = '<div class="'.$param_class.'">
		<span class="before"></span>
		<span class="inner"><i class="'.$param_icon.'"></i></span>
		<span class="after"></span>
		</div>';

		return $output;
	}



	function sg_divider_text($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'style' => '',
			'class' => ''
		), $attr));

		//verify style
		if($style){
			$style = 'divider-'.$style;
		}

		$param_class = trim("sg-title title-divider $style $class");

		$output = '<div class="'.$param_class.'">
		<span class="before"></span>
		<span class="inner">'.do_shortcode($content).'</span>
		<span class="after"></span>
		</div>';

		return $output;
	}







	function sg_collapse($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'id' => 0,
			'style' => '',
			'class' => ''
		), $attr));

		self::$collapse_count++;

		$param_class = trim("panel-group panel-accordion $class");
		$param_id = ($id) ? $id : 'collapse-'.self::$collapse_count;

		$output = '<div class="'.$param_class.'" id="'.$param_id.'">'.do_shortcode($content).'</div>';

		return $output;
	}



	function sg_collapse_content($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'parent_id' => 0,
			'panel_id' => 0,
			'panel_style' => '',
			'title' => 'Title',
			'class' => ''
		), $attr));

		self::$collapse_count++;
		self::$collapse_content_count++;

		$param_parent_id = ($parent_id) ? $parent_id : 'collapse-'.self::$collapse_count;
		$param_panel_id = ($parent_id) ? $parent_id : 'panel-'.self::$collapse_count;
		
		$param_class = trim("panel panel-border $class");

		$panel_heading = '<div class="panel-heading">
	        <h4 class="panel-title">
	            <a href="#'.$param_parent_id.'-'.$param_panel_id.'" data-parent="#'.$param_parent_id.'" data-toggle="collapse" class="collapsed">
	                <i class="fa panel-toggle fa-plus"></i>'.$title.'</a>
	        </h4>
	    </div>';

	    $panel_body = '<div class="panel-collapse collapse" id="'.$param_parent_id.'-'.$param_panel_id.'">
	        <div class="panel-body">
	            <i class="fa panel-toggle fa-minus"></i>'.do_shortcode($content).'
	        </div>
	    </div>';


		$output = '<div class="'.$param_class.'">'.$panel_heading.$panel_body.'</div>';

		return $output;
	}



	function sg_gmap($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'id' => 0,
			'class' => '',
			'style' => '',
			'url' => '',
		), $attr));

		self::$gmap_count++;

		$param_class = trim("gmap $class");
		$param_id = ($id) ? $id : 'gmap-'.self::$gmap_count;

		//get param_data
		$attr_data = array();
		if($attr){
			foreach($attr as $key=>$val){
				if(strpos($key, 'data_')===0){
					$attr_data[SG_Util::slug($key)] = $val;
				}
			}
		}
		

		$param_data = ' '.SG_Util::inlineAttr($attr_data);

		$output = '<div class="'.$param_class.'" id="'.$param_id.'"'.$param_data.'></div>';

		return $output;
	}




	function sg_btn($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'color' => 'default',
			'class' => '',
			'style' => '',
			'url' => '',
		), $attr));

		$color = 'btn-'.$color;

		$param_class = trim("btn $color $class");
		$param_href = trim(' href="'.$url.'"');

		$output = '<a class="'.$param_class.'"'.$param_href.'>'.do_shortcode($content).'</a>';

		return $output;
	}



	function sg_div($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'class' => '',
			'style' => '',
		), $attr));

		$param_class = trim("$class");
		if($param_class){
			$param_class = ' class="'.$param_class.'"';
		}

		$param_style = trim("$style");
		if($param_style){
			$param_style = ' style="'.$param_style.'"';
		}

		$output = '<div'.$param_class.$param_style.'>'.do_shortcode($content).'</div>';

		return $output;
	}


	function sg_p($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'class' => '',
			'style' => '',
		), $attr));

		$param_class = trim("$class");
		if($param_class){
			$param_class = ' class="'.$param_class.'"';
		}

		$param_style = trim("$style");
		if($param_style){
			$param_style = ' style="'.$param_style.'"';
		}

		$output = '<p'.$param_class.$param_style.'>'.do_shortcode($content).'</p>';

		return $output;
	}



	function sg_span($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'class' => '',
			'style' => '',
		), $attr));

		$param_class = trim("$class");
		if($param_class){
			$param_class = ' class="'.$param_class.'"';
		}

		$param_style = trim("$style");
		if($param_style){
			$param_style = ' style="'.$param_style.'"';
		}

		$output = '<span'.$param_class.$param_style.'>'.do_shortcode($content).'</span>';

		return $output;
	}



	function sg_badge($attr=array(), $content=null){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'class' => '',
			'style' => '',
		), $attr));

		$param_class = trim("badge $class");
		if($param_class){
			$param_class = ' class="'.$param_class.'"';
		}

		$param_style = trim("$style");
		if($param_style){
			$param_style = ' style="'.$param_style.'"';
		}

		$output = '<span'.$param_class.$param_style.'>'.do_shortcode($content).'</span>';

		return $output;
	}


	function sg_fa($attr=array()){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'icon' => '',
			'fixed_width' => 'false',
			'class' => '',
			'style' => '',
		), $attr));

		if($icon){
			$icon = 'fa-'.$icon;
		}

		if($fixed_width=='true'){
			$class = 'fa-fw '.$class;
		}

		$param_class = trim("fa $icon $class");

		$param_style = trim(' style="'.$style.'"');

		$output = '<i class="'.$param_class.'"'.$param_style.'></i>';

		return $output;
	}




	function sg_iframe($attr=array()){
		$param_attr = '';
		foreach($attr as $key=>$val) {
			$param_attr .= ' '.$key.'="'.$val.'"';
		}

		$output = '<iframe'.$param_attr.'></iframe>';

		return $output;
	}




	function sg_include($attr=array()){
		extract(shortcode_atts(array(
			'path' => '',
		), $attr));

		ob_start();
		include(sg_view_path($path));
		return ob_get_clean();
	}
}


add_shortcode('sg_section', array('SG_ScFramework', 'sg_section'));
add_shortcode('sg_row', array('SG_ScFramework', 'sg_row'));
add_shortcode('sg_col', array('SG_ScFramework', 'sg_col'));
add_shortcode('sg_spacer', array('SG_ScFramework', 'sg_spacer'));
add_shortcode('sg_divider', array('SG_ScFramework', 'sg_divider'));
add_shortcode('sg_divider_icon', array('SG_ScFramework', 'sg_divider_icon'));
add_shortcode('sg_divider_text', array('SG_ScFramework', 'sg_divider_text'));
add_shortcode('sg_collapse', array('SG_ScFramework', 'sg_collapse'));
add_shortcode('sg_collapse_content', array('SG_ScFramework', 'sg_collapse_content'));
add_shortcode('sg_gmap', array('SG_ScFramework', 'sg_gmap'));
add_shortcode('sg_btn', array('SG_ScFramework', 'sg_btn'));
add_shortcode('sg_div', array('SG_ScFramework', 'sg_div'));
add_shortcode('sg_div_1', array('SG_ScFramework', 'sg_div'));
add_shortcode('sg_div_2', array('SG_ScFramework', 'sg_div'));
add_shortcode('sg_div_3', array('SG_ScFramework', 'sg_div'));
add_shortcode('sg_div_4', array('SG_ScFramework', 'sg_div'));
add_shortcode('sg_p', array('SG_ScFramework', 'sg_p'));
add_shortcode('sg_span', array('SG_ScFramework', 'sg_span'));
add_shortcode('sg_badge', array('SG_ScFramework', 'sg_badge'));
add_shortcode('sg_fa', array('SG_ScFramework', 'sg_fa'));
add_shortcode('sg_iframe', array('SG_ScFramework', 'sg_iframe'));
add_shortcode('sg_include', array('SG_ScFramework', 'sg_include'));