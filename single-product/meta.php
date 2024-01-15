<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
	<?php 
		$attr_product = $product->get_attributes();
	
		$link = get_site_url().'/shop/?brand=';
		foreach($attr_product as $attr) {
			// print_r($attr_product['pa_brand']->get_options());
			if($attr->get_name() == 'pa_brand') {
				if($product->get_attribute( 'brand' )) {
					$link_brand = explode(' ', strtolower($product->get_attribute( 'brand' )));
					$link_brand = implode('-', $link_brand);
					echo '<span class="posted_in">' . __( 'Brand:','woocommerce' ) . ' <a href="'.$link.$link_brand.'">'.$product->get_attribute( 'brand' ).'</a>'. '</span>';
				}
				
			}
			
		}
		
	?>
	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
