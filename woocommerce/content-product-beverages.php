<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
	

$classes[] = 'cols-'.$woocommerce_loop['columns'];
?>
<li <?php post_class( $classes ); ?>>

	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	// do_action( 'woocommerce_after_shop_loop_item_title' );

	if ( is_user_logged_in() && $price_html = $product->get_price_html() ){
		
		//get discounted price
		$dom = new DOMDocument;
		$dom->loadHTML($price_html);
		
		$tag = $dom->getElementsByTagName('del');
		$before_price_str = trim($tag->item(0)->nodeValue);
		$before_price = (float) trim(str_replace('£', '', $tag->item(0)->nodeValue));

		$tag = $dom->getElementsByTagName('ins');
		$discounted_price_str = trim($tag->item(0)->nodeValue);
		$discounted_price = (float) trim(str_replace('£', '', $tag->item(0)->nodeValue));

		$tax_rate = ($product->get_price_including_tax() - $product->get_price_excluding_tax()) / $product->get_price_excluding_tax();
		$after_price = $discounted_price + ($discounted_price * $tax_rate);

		$pods = $product->get_attribute('pa_number_pods');
		$pod_text = '';

		if(!$pods){
			$pods = $product->get_attribute('pods-per-box');
		}

		if(!$pods){
			$pods = $product->get_attribute('ct-per-box');
			$pod_text = $pods;
		}

		if(!$pod_text){
			$pod_text = $pods.' K-Cup® Pods ('.round($discounted_price/$pods* 100).'p each)';
		}

		echo '<span class="price">';
		// echo $price_html;
		echo '<del><span class="amount">'.$before_price_str.'</span></del>';
		echo '<ins><span class="amount">'.$discounted_price_str.'</span></ins>';
		echo (true) ? '<em><span class="amount">'.$pod_text.'</span></em>' : '';
		echo '</span>';
	}

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>

</li>
