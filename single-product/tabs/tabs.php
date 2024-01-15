<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>
	<div class="woocommerce-tabs wc-tabs-wrapper">

	
		<div class="dropdowns-wrapper-single-product">
		
			
			<?php 
				$cont_description = '';
				foreach ( $product_tabs as $key => $product_tab ) : ?>
					<div class="dropdown-item">
						<button class="dropdown-header <?php echo 'dropdown-'.$key; ?>">

							<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
							<span class="accordion-arrow">
								<svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 1.5L6 6.5L11 1.5" stroke="black" stroke-width="2"/>
								</svg>
							</span>
						</button>
						<div class="dropdown-content">
							
								<?php
								if ( isset( $product_tab['callback'] ) ) {
									
									call_user_func( $product_tab['callback'], $key, $product_tab );
									
									
								}
								?>
							
							
						</div>
					</div>
			
			<?php endforeach; ?>

			<?php do_action( 'woocommerce_product_after_tabs' ); ?>
		</div>
	</div>

<?php endif; ?>
