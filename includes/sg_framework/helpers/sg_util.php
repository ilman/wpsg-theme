<?php 

if(!class_exists('SG_Util')){
	class SG_Util{

		static function val($var, $field_name=null, $default=''){
			if($field_name===null){ return $var; }
			
			$value = '';
			
			if(is_array($var)){			
				if(isset($var[$field_name])){ $value = $var[$field_name]; }
				else{ return $default; }
			}
			elseif(is_object($var)){
				if(isset($var->$field_name)){ $value = $var->$field_name; }
				else{ return $default; }
			}
			else{
				$value = $var;
			}
			
			return ($value) ? $value : $default;
		}

		static function un_set($var, $field_name=''){
			if(is_array($var)){
				unset($var[$field_name]);
			}
			elseif(is_object($var)){
				unset($var->$field_name);
			}
			return $var;
		}
		
		static function slug($str, $sep='-'){
			$str = strtolower(trim($str));
			$str = preg_replace('/[^a-z0-9'.$sep.']/', $sep, $str);
			$str = preg_replace('/'.$sep.'+/', $sep, $str);
			$str = trim($str, $sep);
			
			return $str;
		}
		
		static function inline_attr($attr=array()){
			$inline_attr = '';
			$allowed_attr = array('class','type','value','name','placeholder','readonly','disabled','rel','id','style','selected','checked');

			if(!is_array($attr) && !is_object($attr)){ return false; }
						
			foreach($attr as $key => $val){
				if(in_array($key, $allowed_attr) || strpos($key,'data-')===0){
					$inline_attr .= $key.'="'.htmlspecialchars($val).'" ';
				}
			}
			
			return $inline_attr;	
		}
		
		static function event_attr($attr=array()){
			$inline_attr = '';
			$allowed_attr = array('onchange','onclick','onkeyup','onload');
			
			if(is_array($attr)){		
				foreach($attr as $key => $val){					
					if(in_array($key, $allowed_attr)){
						$inline_attr .= $key.'="'.htmlspecialchars($val).'" ';
					}
				}
			}
						
			return $inline_attr;	
		}

		static function array_linear($params,$child_key='fields'){			
			if(!is_array($params)){
				return false;	
			}

			$array_linear = array();
			
			foreach($params as $param){
				$param_child = sg_util::val($param, $child_key);				

				if($param_child){
					$param[$child_key] = array();
					$array_linear[] = $param;
					$array_linear = array_merge($array_linear,self::array_linear($param_child, $child_key));
				}
				else{
					$array_linear[] = $param;
				}
			}
			
			return $array_linear;
		}
	}

}