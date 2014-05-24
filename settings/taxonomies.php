<?php 
//http://shibashake.com/wordpress-theme/add-custom-taxonomy-tags-to-your-wordpress-permalinks
//http://www.deluxeblogtips.com/2010/07/custom-post-type-with-categories-post.html

function sg_cpt_portfolio_cat() {
	register_taxonomy(
		'sg_cpt_portfolio_cat', //taxonomy slug
		array('sg_cpt_portfolio'), //custom post type
		array(
			'labels' => array(
				'name' => __('Portfolio Categories'),
				'singular_name' => __('Portfolio Category')
			),
			'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true,
			'query_var' => 'sg_cpt_portfolio_cat',
			'rewrite' => true
		)
	);
}
add_action('init', 'sg_cpt_portfolio_cat');


?>