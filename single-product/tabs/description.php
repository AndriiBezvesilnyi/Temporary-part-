<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;
global $product;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );

?>
<div class="descr-single-prod-dropdown">
	<?php 
			$content = get_the_content(); 
			$trimmed_content = wp_trim_words( $content, 60, '...' );

			if(mb_strlen($trimmed_content) < mb_strlen(wp_strip_all_tags($content))) {
				
			?>

				<div class="full-descr-dropdown">
					<?php  the_content();  ?>
				</div>
			
			<?php } ?>

			<div class="trimm-descr-dropdown show">

			
				<?php

					echo '<p>'.$trimmed_content.'</p>';
				?>
			</div>
			<?php 
				$button  = '<button id="read-more-dropdown" class="read-more-dropdown"><span>Show more</span><svg width="12" height="6" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M2 7L8 0.999999L14 7" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
				</svg></button>';
				if(mb_strlen($trimmed_content) < mb_strlen(wp_strip_all_tags($content))){
					// print_r('trim - '.mb_strlen($trimmed_content));
					// print_r('trim - '.mb_strlen(wp_strip_all_tags($content)));
					echo $button;
				}
			?>
</div>

<?php do_action( 'woocommerce_product_additional_information', $product ); ?>


