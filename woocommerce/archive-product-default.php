<?php
	/**
	 * woocommerce_before_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action( 'woocommerce_before_main_content' );
?>



<?php 

	global $wp_query;

	$terms = $wp_query->get_queried_object();
	$term_name = $terms->name;
	$termchildren = get_term_children( $terms->term_id, 'product_cat' );

	if(count($termchildren)<1){
		$terms = get_term_by('id', $terms->parent, 'product_cat');
		$term_name = $terms->name;
		$termchildren = get_term_children( $terms->term_id, 'product_cat' );
	}

?>



<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

	<h1 class="page-title">
		<?php 

			if(kwirk_woocommerce_archive_title($terms->term_id)){
				echo kwirk_woocommerce_archive_title($terms->term_id);
			}
			else{
				woocommerce_page_title();
			}
		?>
	</h1>

<?php endif; ?>

<?php
	/**
	 * woocommerce_archive_description hook.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
?>

<div class="row sidebar-right content-wrapper">
	<div class="col-sm-9 content-main pull-right">
		<?php do_action('sg_content_header'); ?>
		
		





		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php 

						if(has_term('brewers', 'product_cat')){
							wc_get_template_part( 'content', 'product-brewers' );
						}
						elseif(has_term('beverages', 'product_cat')){
							wc_get_template_part( 'content', 'product-beverages' );
						}
						else{
							wc_get_template_part( 'content', 'product' );
						}
							

					?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>






		
		<?php do_action('sg_content_footer'); ?>		
	</div>
	<!-- content main -->
	<aside class="col-sm-3 content-side pull-left">



		
		<?php 



			if(count($termchildren)){

				echo '<div class="widget panel woocommerce widget-smart-categories">';
					echo '<div class="widget-heading panel-heading"><h4 class="widget-title panel-title">Refine Your Selection</h4></div>';
					echo '<div class="widget-body panel-body">';
						echo '<ul class="product-categories">';
							echo '<li class="cat-item cat-parent">';
								echo '<span>'.$term_name.'</span>';
								echo '<ul class="children">';
									foreach ( $termchildren as $child ) {
										$term = get_term_by( 'id', $child, 'product_cat' );
										echo '<li class="cat-item"><a href="' . get_term_link( $child, 'product_cat' ) . '">' . $term->name . '<span class="label label-default">' . $term->count . '</span>' . '</a></li>';
									}
								echo '</ul>';
							echo '</li>';
						echo '</ul>';
					echo '</div>';
				echo '</div><!-- widget -->';
			}
			else{
				if(class_exists('WC_Widget_Product_Categories')){
					echo '<div class="widget panel woocommerce widget-product-categories">';
					the_widget(
						'WC_Widget_Product_Categories', 
						array(
							'title' => 'Product Categories'
						), 
						array(
							'before_widget' => '<div id="widget-product-categories" class="widget panel widget-product-categories">',
							'before_title' => '<div class="widget-heading panel-heading"><h4 class="widget-title panel-title">',
							'after_title' => '</h4></div><!-- widget-heading --><div class="widget-body panel-body">',
							'after_widget' => '</div><!-- widget body --></div><!-- widget -->',
						));
					echo '</div><!-- widget -->';
				}
			}



		?>
	</aside>
	<!-- content side -->
</div>
<!-- row -->