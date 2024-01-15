<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product;
$prod_cur = $product;
if ( $related_products ) : ?>

	<section class="related products products-container">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'You may also like', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		
		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );
					?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>
		
		<div class="row-button-related">
			<?php 
				$categories = get_the_terms( $prod_cur->get_id(), 'product_cat' );
				
				if ( $categories ) : 
					$counts_cats = count($categories);
					
					if($counts_cats == 1) {

						echo '<a class="button-text-link with-border-black but-related-view-all" href="'.esc_url(get_category_link($categories[0]->term_id)).'">go to all '.esc_html($categories[0]->name).'</a>';
					
					} else {
						$count_cat = 1;
						foreach($categories as $category) :
							$children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $category->term_id ));
							if ($count_cat <= $counts_cats) {
								if ( count($children) == 0 ) {
									echo '<a class="button-text-link with-border-black but-related-view-all" href="'.esc_url(get_category_link($category->term_id)).'">go to all '.esc_html($category->name).'</a>';
								}
							}
							++$count_cat;
						endforeach;
					}
					
					
				endif;
			?>
		
		</div>
	</section>
	<?php
endif;

wp_reset_postdata();
