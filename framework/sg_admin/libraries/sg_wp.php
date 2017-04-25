<?php 

class SG_WP{

	static function _content_url(){
		$content_url = untrailingslashit( dirname( dirname( get_stylesheet_directory_uri() ) ) );
		return str_replace( '\\', '/', $content_url );
	}

	static function _content_dir(){
		$content_dir = untrailingslashit( dirname( dirname( get_stylesheet_directory() ) ) );
		return str_replace( '\\', '/', $content_dir );
	} 

	static function file_base_dir($file){
		$file = str_replace( '\\', '/', dirname($file) );
		return $file ;
	}

	static function file_base_url($file){
		$file = str_replace( '\\', '/', dirname($file) ); 
		return str_replace( self::_content_dir(), self::_content_url(), $file );
	}

	static function printMessage($message, $class = 'updated'){
		 echo '<div class="'.$class.'">'.$message.'</div>';

	}

	static function getCurrentPostType() {
		global $post, $typenow, $current_screen;

		//we have a post so we can just get the post type from that
		if ( $post && $post->post_type ){ return $post->post_type; }

		//check the global $typenow - set in admin.php
		elseif( $typenow ){	return $typenow; }
		
		//check the global $current_screen object - set in sceen.php
		elseif( $current_screen && $current_screen->post_type ){ return $current_screen->post_type; }

		//lastly check the post_type querystring
		elseif( isset( $_REQUEST['post_type'] ) ){ return sanitize_key( $_REQUEST['post_type'] ); }

		//we do not know the post type!
		return false;
	}

	static function getPostMetaAll($post_id=false){
		global $wpdb;
		$data = array();
		$wpdb->query("
			SELECT `meta_key`, `meta_value`
			FROM $wpdb->postmeta
			WHERE `post_id` = $post_id
		");
		foreach($wpdb->last_result as $k => $v){
			$data[$v->meta_key] =   $v->meta_value;
		};
		return $data;
	}

	static function getPostList($type='post'){
		global $wpdb;
			
		$sql_query = "
			SELECT p.ID as value, p.post_title as label
			FROM $wpdb->posts p
			WHERE p.post_type = '$type'
			AND p.post_status = 'publish'
			ORDER BY p.post_title
		";
			
		return $wpdb->get_results($sql_query, ARRAY_A);	
	}

	static function getTaxonomyList($type='category'){
		global $wpdb;
			
		$sql_query = "
			SELECT t.term_id as value, t.name as label
			FROM $wpdb->terms t
			JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id
			WHERE tt.taxonomy = '$type'
			ORDER BY t.name
		";
			
		return $wpdb->get_results($sql_query, ARRAY_A);	
	}

	static function get_google_font_json(){
		$request = wp_remote_get(SG_THEME_URL.'/admin/gwf.json');
		$response = wp_remote_retrieve_body($request);
		$response = json_decode($response);
		
		$font_list = array();
		if(!$response || !is_array($response)){
			return array();
		}
		foreach($response as $key=>$val){
			$font_list[] = array(
				'id'	=> $key,
				'text'	=> $key
			);
		}
		return $font_list;
	}
}