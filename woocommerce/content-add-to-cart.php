<?php
/**
 * Product Bundle add-to-cart template.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/add-to-cart/bundle.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version  4.12.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce, $product;

do_action( 'woocommerce_before_add_to_cart_form' ); 


?>

<form method="post" enctype="multipart/form-data" class="bundle_form" >


<?php

	do_action( 'woocommerce_after_bundled_items' );

	if ( $product->is_purchasable() ) {

		?>
		<div class="cart bundle_data bundle_data_<?php echo $product->id; ?>" data-button_behaviour="<?php echo esc_attr( apply_filters( 'woocommerce_bundles_button_behaviour', 'new', $product ) ); ?>" data-bundle_price_data="<?php echo esc_attr( json_encode( $bundle_price_data ) ); ?>" data-bundle_id="<?php echo $product->id; ?>"><?php

			do_action( 'woocommerce_before_add_to_cart_button' );

			?>
			<div class="bundle_wrap" style="<?php echo apply_filters( 'woocommerce_bundles_button_behaviour', 'new', $product ) == 'new' ? '' : 'display:none'; ?>">
				<div class="bundle_price"></div>
				<div class="bundle_error" style="display:none"><ul class="msg woocommerce-info"></ul></div><?php

				$availability      = $product->get_availability();
				$availability_html = empty( $availability[ 'availability' ] ) ? '' : '<p class="stock ' . esc_attr( $availability[ 'class' ] ) . '">' . esc_html( $availability[ 'availability' ] ) . '</p>';

				echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability[ 'availability' ], $product );

				?>
				<div class="bundle_button">
				<?php

					/**
					 * woocommerce_bundles_add_to_cart_button hook.
					 *
					 * @hooked wc_bundles_add_to_cart_button - 10
					 */
					do_action( 'woocommerce_bundles_add_to_cart_button' );

				?></div>
				<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			</div>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		</div><?php

	} else {
		?><div class="bundle_unavailable woocommerce-info"><?php
			echo __( 'This product is currently unavailable.', 'woocommerce-product-bundles' );
		?></div><?php
	}

?></form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
