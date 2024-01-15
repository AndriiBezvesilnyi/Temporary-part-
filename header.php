<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0"/>
    <?php wp_head(); ?>
</head>
<body <?php body_class() ?>>

<?php wp_body_open(); ?>


<header class="header-main">

    <div class="top-bar-header">
        <div class="content-container">
            

            <?php
            wp_nav_menu([
                'theme_location' => 'top_bar_menu',
                'menu_class' => 'menu-top-bar',
                'menu_id' => 'top-bar-menu',
                'container' => 'nav',
                'container_class' => 'menu-top-bar-container',
               
            ]);
            ?>
            <?php menu_box_social(); ?>
            
            <?php menu_box_address(); ?>
        </div>
    </div>
   
    <div class="middle-bar-header">
        <div class="content-container">
            <div class="logo-wrapper">
                <?php if(is_front_page()):  ?>
                    <h1 class="site-logo site-logo-header">
                        <a href="/" rel="home">
                            <img src="<?php the_field('logo_header', 'option'); ?>"  alt="UNIVERSAL fine wine & spirits logo">
                        </a>
                    </h1>
                <?php else: ?>
                    <div class="site-logo site-logo-header">
                        <a href="/" rel="home">
                            <img src="<?php the_field('logo_header', 'option'); ?>"  alt="UNIVERSAL fine wine & spirits logo">
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-search-wrapper">
                <form id="header-form-search" role="search" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
                    <input type="search" id="header-search-input" placeholder="Search..." name="s" autocomplete="off">
                    <button type="submit" class="icon-search-form">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.0996 19.5C15.5179 19.5 19.0996 15.9183 19.0996 11.5C19.0996 7.08172 15.5179 3.5 11.0996 3.5C6.68133 3.5 3.09961 7.08172 3.09961 11.5C3.09961 15.9183 6.68133 19.5 11.0996 19.5Z"
                                stroke="#1D1D1C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21.1 21.4999L16.75 17.1499" stroke="#1D1D1C" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    
                    <input type="hidden" name="post_type" value="product" />
                    <button class="clear-search-input">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
                <div id="result-search-container" class="results-form-search">
                    <div class="inner-container-results">
                        <div class="results-search-container">
                            <div class="loading-search-result">Loading...</div>
                        </div>
                        <div class="bottom-container-button">
                            <!-- <span id="results-cont-span" class="results-cont-span"></span> -->
                            <button class="button-vew-all but-more-search-results" >Show more results
                                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.3 1L15.5 4.75L16 6L15.5 7.25L11.3 11M15.5 6H0" stroke="black" stroke-width="2"/>
                            </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="phone-header-wrapper phone-header-main">
                 <span class="icon-svg-phone">
                   <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <g clip-path="url(#clip0_472_10203)">
                     <path d="M7.36391 11.3677C8.41988 12.3797 9.16787 13.0836 9.82785 13.3916C10.3558 13.6996 10.8838 13.4796 11.1918 13.1716C11.4998 12.7756 11.8078 12.4677 12.1598 12.0717C12.7758 11.3677 15.9877 12.5997 16.9556 12.7756C17.7036 12.9956 18.0996 13.3916 18.0996 13.8756C18.0996 14.4916 18.0996 15.0636 18.0996 15.5916C17.2636 17.3955 15.9877 18.4075 14.0517 18.4955C11.2798 18.5835 8.11189 17.3955 4.59199 13.9636C1.20409 10.4437 0.0161263 7.3198 0.104124 4.50388C0.104124 2.61194 1.16009 1.29198 2.96404 0.5C3.49203 0.5 4.15201 0.5 4.68 0.5C5.20798 0.5 5.64797 0.983985 5.73596 1.68796C6.04395 2.69994 7.31991 5.82384 6.57194 6.48383C6.26395 6.79182 5.82396 7.09981 5.51597 7.4078C5.20798 7.71579 4.98798 8.19978 5.29598 8.81576C5.64797 9.56374 6.26395 10.2677 7.36391 11.3677Z"
                         fill="#1D1D1C"/>
                     </g><defs><clipPath id="clip0_472_10203"><rect width="18" height="18" fill="white" transform="translate(0.0996094 0.5)"/></clipPath></defs>
                    </svg>
               
                 </span>
                <a class="phone-text" href="tel:<?php the_field('phone', 'option'); ?>">
                    <?php the_field('phone', 'option'); ?>
                </a>
            </div>
            <div class="mobile-button-menu-container">
                <div id="mobile-button-main-menu" class="mobile-button-main-menu">
                    <span></span>
                </div>
            </div>
            <div class="store-header-links">
                
              <?php echo butHeaderWishLogin(); ?>

                <a href="#" class="header-item-store-link<?php echo is_cart() || is_checkout() ? ' not-open' : '' ?>" id="toggle-mini-cart">
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2.1001 8.5C2.1001 7.94772 2.54781 7.5 3.1001 7.5H21.1001C21.6524 7.5 22.1001 7.94772 22.1001 8.5V19.5C22.1001 21.1569 20.757 22.5 19.1001 22.5H5.1001C3.44324 22.5 2.1001 21.1569 2.1001 19.5V8.5Z"
                            stroke="black" stroke-width="2"/>
                        <path
                            d="M16.1001 13.5V5.5C16.1001 3.29086 14.3092 1.5 12.1001 1.5V1.5C9.89096 1.5 8.1001 3.29086 8.1001 5.5V13.5"
                            stroke="black" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="header-item-store-count"
                          id="mini-cart-count"><?php echo WC()->cart->get_cart_contents_count() ?></span>
                </a>

            </div>
        </div>
    </div>
    
    <div class="bottom-bar-header">
        <div class="content-container">
            <?php
            wp_nav_menu([
                'theme_location' => 'header_menu',
                'menu_class' => 'menu',
                'container' => 'nav',
                'container_class' => 'menu-main-product-menu-container',
                'items_wrap'           => '<div class="mobile-menu-conteiner"><ul id="%1$s" class="%2$s">%3$s</ul></div>',
                'walker' => new Product_Walker()
            ]);
            ?>

        </div>
    </div>
</header>
  
