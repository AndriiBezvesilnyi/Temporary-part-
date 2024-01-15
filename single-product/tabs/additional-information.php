<?php
/**
 * Additional Information tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/additional-information.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional information', 'woocommerce' ) );

?>
<div class="shipping-tab-container">
	
	
	<?php

			if( have_rows('shipping_single_product','options') ):

				while( have_rows('shipping_single_product','options') ) : the_row(); ?>
				
			
				
					<div class="shipping-tab-block">
						<p class="title-shipping-block"><?php echo get_sub_field('title_block','options'); ?></p>
						
						<?php if( have_rows('part_table','options') ):  
								while( have_rows('part_table','options') ) : the_row(); ?>
									<p class="subtitle-shipping-block"><?php echo get_sub_field('sub_title_block','options'); ?></p>
									<ul>
										<?php if( have_rows('service_price','options') ):  
												while( have_rows('service_price','options') ) : the_row(); ?>
														<li><span><?php echo get_sub_field('label','options'); ?></span><span><?php echo get_sub_field('price','options'); ?></span> </li>
														
														<?php 
													endwhile;
												endif; ?>
									</ul>
								<?php 
									endwhile;
								endif; ?>
					</div>
				
					
				
				
				<?php	
				
				endwhile;
		
			endif;
			?>



	<a href="<?php the_field('shipping_page','options'); ?>" class="button-text-link"><?php the_field('text_button_shipping_page','options'); ?></a>
</div>



