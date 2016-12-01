<?php 
//http://shibashake.com/wordpress-theme/add-custom-taxonomy-tags-to-your-wordpress-permalinks
//http://www.deluxeblogtips.com/2010/07/custom-post-type-with-categories-post.html

class SG_SettingsTaxonomies
{
	public static function continent_cat() {
		register_taxonomy(
			'continent', //taxonomy slug
			array('post', 'sg_cpt_destination'), //custom post type
			array(
				'labels' => array(
					'name' => __('Continents', SG_THEME_ID),
					'singular_name' => __('Continent', SG_THEME_ID)
				),
				'show_ui' => true,
				'show_tagcloud' => true,
				'hierarchical' => true,
				'query_var' => 'continent',
				'rewrite' => true
			)
		);
	}
}


add_action('init', array('SG_SettingsTaxonomies', 'continent_cat'));