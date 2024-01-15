<?php 
/**
 * Block Name: Table services
 *
 * 
 */
?>

<div class="shipping-tab-container shipping-block">
	
	
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

</div>

