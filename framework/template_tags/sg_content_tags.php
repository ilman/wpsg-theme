<?php 

function excerpt($limit) {
	      $excerpt = explode(' ', get_the_excerpt(), $limit);
	      if (count($excerpt)>=$limit) {
	        array_pop($excerpt);
	        $excerpt = implode(" ",$excerpt).'...';
	      } else {
	        $excerpt = implode(" ",$excerpt).'';
	      } 
	      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	      return '<p>' . $excerpt . '</p>';
	    }
		
function sg_get_excerpt($limit=false){	
	$limit = ($limit!==false) ? $limit : sg_opt('content_cut_limit');
	$content = get_the_excerpt();
	$content = strip_shortcodes($content);
	$content = ($limit>0) ? wp_trim_words($content, $limit, '<a href="'. get_permalink() .'">'.sg_opt('read_more_text').'</a>') : $content;	
	$content = apply_filters('sg_get_excerpt', $content);
	return $content; //apply_filters('the_content', $content);
}


?>