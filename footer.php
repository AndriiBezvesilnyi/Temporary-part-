<footer class="footer-main">
    <div class="content-container ">
        <div class="footer-inner-main">
            <div class="footer-item footer-item-1">
                <div class="site-logo site-logo-footer">
                        <a href="/" rel="home">
                            <img src="<?php the_field('logo_footer', 'option'); ?>"  alt="UNIVERSAL fine wine & spirits logo">
                        </a>
                </div>
                <div class="shop-character">
                    <a class="elem-footer elem-footer-phone" href="tel:<?php the_field('phone', 'option'); ?>">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.49527 13.3945C10.6686 14.519 11.4997 15.3011 12.233 15.6433C12.8196 15.9855 13.4063 15.7411 13.7485 15.3989C14.0907 14.9589 14.4329 14.6168 14.8241 14.1768C15.5085 13.3945 19.0773 14.7634 20.1527 14.9589C20.9838 15.2033 21.4238 15.6433 21.4238 16.1811C21.4238 16.8655 21.4238 17.5011 21.4238 18.0878C20.4949 20.0921 19.0773 21.2165 16.9262 21.3143C13.8463 21.4121 10.3264 20.0921 6.41536 16.2789C2.65103 12.3679 1.33107 8.89689 1.42884 5.76809C1.42884 3.66593 2.60214 2.19931 4.60653 1.31934C5.19318 1.31934 5.92649 1.31934 6.51315 1.31934C7.0998 1.31934 7.58867 1.8571 7.68644 2.63929C8.02865 3.76371 9.44638 7.23471 8.61531 7.96803C8.2731 8.31024 7.78422 8.65245 7.44201 8.99466C7.09979 9.33687 6.85535 9.87464 7.19757 10.5591C7.58867 11.3902 8.2731 12.1724 9.49527 13.3945Z" stroke="#C5A477" stroke-width="2"/>
                        </svg>
                        <span class="text-elem-footer">
                            <?php the_field('phone', 'option'); ?>
                        </span>
                    </a>
                    
                    <?php menu_box_address(true, true); ?>
                    
                    <div class="elem-footer elem-footer-clock">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1586_10400)">
                            <path d="M12.4238 19.3193C16.2898 19.3193 19.4238 16.1853 19.4238 12.3193C19.4238 8.45334 16.2898 5.31934 12.4238 5.31934C8.55783 5.31934 5.42383 8.45334 5.42383 12.3193C5.42383 16.1853 8.55783 19.3193 12.4238 19.3193Z" stroke="#C5A477" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.4238 9.31934V12.3193L13.9238 13.8193" stroke="#C5A477" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.9338 17.6694L16.5838 21.4994C16.5388 21.998 16.3083 22.4616 15.938 22.7986C15.5677 23.1356 15.0845 23.3214 14.5838 23.3194H10.2538C9.75314 23.3214 9.26991 23.1356 8.89961 22.7986C8.52931 22.4616 8.29887 21.998 8.25381 21.4994L7.90381 17.6694M7.91381 6.96935L8.26381 3.13935C8.30871 2.64243 8.53774 2.18024 8.90592 1.8435C9.27411 1.50677 9.75486 1.31982 10.2538 1.31935H14.6038C15.1045 1.31732 15.5877 1.50315 15.958 1.84013C16.3283 2.1771 16.5588 2.64071 16.6038 3.13935L16.9538 6.96935" stroke="#C5A477" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_1586_10400">
                            <rect width="24" height="24" fill="white" transform="translate(0.423828 0.319336)"/>
                            </clipPath>
                            </defs>
                        </svg>
                        <span class="text-elem-footer">
                            <?php the_field('time_work', 'option'); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="footer-item footer-item-2">
                <div class="dropdown-item">
                    <button class="dropdown-header">
                        <svg width="29" height="18" viewBox="0 0 29 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="1.0834" width="11.513" height="11.513" rx="1.25" transform="matrix(0.722268 -0.691614 0.722268 0.691614 0.800896 9.7493)" stroke="#C5A477" stroke-width="1.5"/>
                            <rect x="1.0834" width="11.513" height="11.513" rx="1.25" transform="matrix(0.722268 -0.691614 0.722268 0.691614 10.003 9.7493)" stroke="#C5A477" stroke-width="1.5"/>
                        </svg>
                       Shop							
                        <span class="accordion-arrow">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1.5L6 6.5L11 1.5" stroke="black" stroke-width="2"></path>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-content" >
                    <?php
                        wp_nav_menu([
                            'theme_location' => 'footer_menu_1',
                            'menu_class' => 'menu menu-footer',
                            'container' => 'nav',
                            'container_class' => 'menu-footer-shop',
                            'items_wrap'           => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                     
                        ]);
                    ?>
                       
                    </div>
                </div>
            </div>
            <div class="footer-item footer-item-3">
                <div class="dropdown-item">
                    <button class="dropdown-header">
                        <svg width="29" height="18" viewBox="0 0 29 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="1.0834" width="11.513" height="11.513" rx="1.25" transform="matrix(0.722268 -0.691614 0.722268 0.691614 0.800896 9.7493)" stroke="#C5A477" stroke-width="1.5"/>
                            <rect x="1.0834" width="11.513" height="11.513" rx="1.25" transform="matrix(0.722268 -0.691614 0.722268 0.691614 10.003 9.7493)" stroke="#C5A477" stroke-width="1.5"/>
                        </svg>
                       Learn more							
                        <span class="accordion-arrow">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1.5L6 6.5L11 1.5" stroke="black" stroke-width="2"></path>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-content" >
                    <?php
                        wp_nav_menu([
                            'theme_location' => 'footer_menu_2',
                            'menu_class' => 'menu menu-footer',
                            'container' => 'nav',
                            'container_class' => 'menu-footer-learn',
                            'items_wrap'           => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                     
                        ]);
                    ?>
                       
                    </div>
                </div>
            </div>
            <div class="footer-item footer-item-4">
                <div class="dropdown-item">
                        <button class="dropdown-header">
                            <svg width="29" height="18" viewBox="0 0 29 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="1.0834" width="11.513" height="11.513" rx="1.25" transform="matrix(0.722268 -0.691614 0.722268 0.691614 0.800896 9.7493)" stroke="#C5A477" stroke-width="1.5"/>
                                <rect x="1.0834" width="11.513" height="11.513" rx="1.25" transform="matrix(0.722268 -0.691614 0.722268 0.691614 10.003 9.7493)" stroke="#C5A477" stroke-width="1.5"/>
                            </svg>
                            Customer care						
                            <span class="accordion-arrow">
                                <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1.5L6 6.5L11 1.5" stroke="black" stroke-width="2"></path>
                                </svg>
                            </span>
                        </button>
                        <div class="dropdown-content" >
                        <?php
                            wp_nav_menu([
                                'theme_location' => 'footer_menu_3',
                                'menu_class' => 'menu menu-footer',
                                'container' => 'nav',
                                'container_class' => 'menu-footer-customer',
                                'items_wrap'           => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        
                            ]);
                        ?>
                        
                        </div>
                    </div>
                </div>
        </div>
        <div class="sub-footer-container">
            
            <div class="footer-item footer-item-1">
                
                <div class="img-container-footer ">
                    <?php if( have_rows('footer_images_1','options') ): 
                    
                            while( have_rows('footer_images_1','options') ): the_row(); 
                                
                                $link = get_sub_field('image_link');
                                $image = get_sub_field('image_footer');
                                
                                if($link) { ?>
                                    
                                    <a href="<?php echo $link; ?>" target="_blank" rel="noreferrer noopener" > 
                                        <?php echo wp_get_attachment_image( $image, 'full' ); ?>
                                    </a> 
                               <?php 
                                     } else {
                                        echo wp_get_attachment_image( $image, 'full' ); 
                                    }
                            endwhile; endif; ?>
                </div>
            </div>
            <div class="footer-item footer-item-2">
                <p class="sub-title-footer">Follow us</p>
                <?php menu_box_social(true, true); ?>
            </div>
            <div class="footer-item footer-item-3">
                <p class="sub-title-footer">Partners</p>
                <div class="img-container-footer footer-partners">
                    <?php if( have_rows('footer_images_2','options') ): 
                    
                            while( have_rows('footer_images_2','options') ): the_row(); 
                                $link = get_sub_field('image_link');
                                $image = get_sub_field('image_footer');
                                
                                if($link) { ?>
                                    
                                    <a href="<?php echo $link; ?>" target="_blank" rel="noreferrer noopener" > 
                                        <?php echo wp_get_attachment_image( $image, 'full' ); ?>
                                    </a> 
                            <?php 
                                    } else {

                                        echo wp_get_attachment_image( $image, 'full' );

                                    }
                            endwhile; endif; ?>
                </div>
            </div>
            <div class="footer-item footer-item-4">
            </div>
        </div>
        <div class="copyright-footer">
                <?php the_field('copyright_footer', 'options'); ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>