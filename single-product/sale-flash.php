<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<div class="loop-badges desktop-single-badges">
	<?php if ( $product->is_on_sale() ) : ?>

		<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale', 'woocommerce' ) . '</span>', $post, $product ); ?>

		<?php
	endif;

		$newness_days = 10;
		$created = strtotime($product->get_date_created());
		$new_product_check = get_field('new_product');
		$new_badge = '';
		if ((time() - (60 * 60 * 24 * $newness_days)) < $created || $new_product_check) {
			$new_badge = '<span class="itsnew onsale">' . esc_html__('New', 'woocommerce') . '</span>';
		}
		if($new_badge) {
			echo $new_badge;
		}

	/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
	?>
</div>
