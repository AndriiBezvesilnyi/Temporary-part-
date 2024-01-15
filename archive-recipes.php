<?php
/**
 * The template for displaying archive recipees pages.
 * Template name: Arhive recipes
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * 
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
	<div id="primary" class="content-area">
		
			<div class="content-container">
			
			<?php universal_breadcrumb(); ?>
			
			<div class="header-products">
			
				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
				
				
            </div>
			<div class="universal-recipes">
				<?php if ( have_posts() ) : ?>

					<?php 
                    while ( have_posts() ) :
						the_post(); ?>

						<div class="item-recipe-universal">
							<div class="image-recipe">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium' );  ?>
									<div class="image-hover"></div>
								</a>
							</div>
							<a  href="<?php the_permalink(); ?>" class="title-recipe">
								<h2><?php the_title(); ?></h2>
							</a>
						</div>
                                         
					<?php endwhile; ?>

				
				<?php endif; ?>
			</div>
			<?php  
				$args = array(
					'show_all'     => false, 
					'end_size'     => 1,     
					'mid_size'     => 1,     
					'prev_next'    => true,  
					'prev_text'    => __('<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 13L1 6.99998L7 0.999983" stroke="black" stroke-linecap="square" stroke-linejoin="round"/></svg>'),
					'next_text'    => __('<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1.00001L7 7.00001L1 13" stroke="black" stroke-linecap="square" stroke-linejoin="round"/></svg>'),
					'add_args'     => false, 
					'add_fragment' => '',     
					'screen_reader_text' => __( 'Posts recipes navigation'),
					'class'        => 'ufws-recipes-pagination',
					'type' => 'array' 
				);
			
			?>
			<?php 
					the_posts_pagination($args);
					
			
			?>
</div>
		
	</div><!-- #primary -->
	</main><!-- #main -->

<?php

get_footer();