<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

$variation = universal_get_product_default_variation($product);

?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php do_action( 'woocommerce_before_add_to_cart_quantity' ); ?>
    <span class="single-title-quantity">Quantity:</span>
    <div class="wrapper-quantity-single-product wrapper-quantity-single-product__variable">
        <div class="item-quantity-row">
            <?php
            woocommerce_quantity_input(
                array(
                    'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                    'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                    'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                )
            );
            ?>
        </div>
        <div class="item-quantity-row-add">
            <?php
                if(!empty($variation))
                    echo wc_get_stock_html( $variation );
                ?>
        </div>
    </div>
    <?php do_action( 'woocommerce_after_add_to_cart_quantity' ); ?>

    <div class="row-button-add d-block">

        <?php if ( $product->is_in_stock() ) : ?>
	        <button type="submit" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
        <?php else: ?>
            <button data-type="popup-waiting-list" type="button" class="button-main button-brown button-add-waiting-list">Notify me (When back in stock)</button>
        <?php endif; ?>

        <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
    </div>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
