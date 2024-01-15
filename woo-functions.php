<?php

use Automattic\WooCommerce\Blocks\BlockTypes\Breadcrumbs;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return [
        'width' => 100,
        'height' => 100,
        'crop' => 0,
    ];
} );

add_action( 'woocommerce_after_shop_loop_item_title', 'my_sold_out_loop', 5 );
 
function my_sold_out_loop() {
    global $product;
    $prod_availability = $product->get_availability();
    $prod_qty ='';
    if ( $product->get_type() == 'simple' && $product->is_in_stock() ) {
        $prod_availability['availability'] = __('In stock');
        $prod_qty = '<span class="product-qty">('.$product->get_stock_quantity().')</span>';
    }

    elseif ( $product->get_type() == 'variable' ) {
        $variation = universal_get_product_default_variation($product);
        if(!empty($variation)) {
            $prod_qty = wc_get_stock_html($variation);
        }
    }
    
   echo '<div class="product-stock '.$prod_availability['class'].'"><span class="circle-stock"></span>'.$prod_availability['availability'].$prod_qty.'</div>';
}

add_action('woocommerce_single_product_summary', 'sku_product_templ_new', 4);

function sku_product_templ_new() {
    global $product;
?>
    <div class="product_meta-sku-top">

        <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
            <div class="line-attr-single-product">
                <div class="elemen-line-attr">
                    <div class="wrap-top-sku-attr">
                        <div id="notification-sku-copied" class="notification-style notification-sku-copied">
                            <?php esc_html_e( 'Copied to clipboard', 'woocommerce' ); ?>
                        </div>
                        <div class="sku-top-container">
                            <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> 
                                <span class="sku" id="sku-single-product">
                                    <?php

                                        $sku = $product->get_sku();

                                        if($product->is_type('variable')) {
                                            if( $variation = universal_get_product_default_variation($product) ) {
                                                $sku = $variation->get_sku();
                                            }
                                        }

                                        echo !empty($sku) ? $sku : esc_html__( 'N/A', 'woocommerce' );
                                    ?>
                                </span>
                            </span>
                            <button id="button-clipboard-copy-sku" data-sku-product="<?php echo $sku; ?>" class="button-icon-style button-copy-sku-product">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_531_9016)">
                                    <path d="M16 21H5C4.44772 21 4 20.5523 4 20V8" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8 16C8 16.5523 8.44772 17 9 17H19C19.5523 17 20 16.5523 20 16V6C20 4.34315 18.6569 3 17 3H11C9.34315 3 8 4.34315 8 6V16Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_531_9016">
                                    <rect width="24" height="24" fill="white" transform="matrix(1 0 0 -1 0 24)"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                </div>
                <div class="elemen-line-attr">
                    <button data-type="popup-sharing-link" data-product="<?php echo $product->get_id(); ?>" id="ufws-but-product-share" class="button-icon-style-left button-sharing">
                        <svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_451_3426)">
                            <path d="M6 15C7.65685 15 9 13.6569 9 12C9 10.3431 7.65685 9 6 9C4.34315 9 3 10.3431 3 12C3 13.6569 4.34315 15 6 15Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18 9C19.6569 9 21 7.65685 21 6C21 4.34315 19.6569 3 18 3C16.3431 3 15 4.34315 15 6C15 7.65685 16.3431 9 18 9Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18 21C19.6569 21 21 19.6569 21 18C21 16.3431 19.6569 15 18 15C16.3431 15 15 16.3431 15 18C15 19.6569 16.3431 21 18 21Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8.7002 10.6998L15.3002 7.2998" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8.7002 13.2998L15.3002 16.6998" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_451_3426">
                            <rect width="24" height="24" fill="white"/>
                            </clipPath>
                            </defs>
                        </svg>
                       <?php esc_html_e( 'Share', 'woocommerce' ); ?>

                    </button>
                </div>
                
            </div>

        <?php endif; ?>
    </div>

<?php 
}

/**
 * @param $product WC_Product
 * @return false|WC_Product
 */
function universal_get_product_default_variation($product) {
    $default_attributes = $product->get_default_attributes();
    $variations = $product->get_available_variations();

    $taxonomy = 'pa_size';

    if( !empty($default_attributes[$taxonomy]) && !empty($variations) ) {
        $value = $default_attributes[$taxonomy];
        foreach ($variations as $variation) {
            if( !empty($variation['attributes']['attribute_' . $taxonomy]) && $value == $variation['attributes']['attribute_' . $taxonomy] ) {
                return wc_get_product($variation['variation_id']);
            }
        }
    }

    return null;
}


// add_action('woocommerce_template_single_rating', 'show_product_average_raiting', 10);
function show_product_average_raiting() {
    global $product;
    $average = $product->get_average_rating();
    if ( isset($average) ) :

        echo wc_get_rating_html($average);
    
    endif;
}
add_action('woocommerce_breadcrumb_defaults', 'change_breadcrumbs_woo');
function change_breadcrumbs_woo($args) {
    $args['delimiter'] = '<svg width="11" height="4" viewBox="0 0 11 4" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.97109 3.88708C8.11109 3.58842 8.24643 3.32708 8.37709 3.10308C8.51709 2.87908 8.65243 2.69242 8.78309 2.54308H0.621094V1.95508H8.78309C8.65243 1.79642 8.51709 1.60508 8.37709 1.38108C8.24643 1.15708 8.11109 0.900417 7.97109 0.611084H8.46109C9.04909 1.29242 9.66509 1.79642 10.3091 2.12308V2.37508C9.66509 2.69242 9.04909 3.19642 8.46109 3.88708H7.97109Z" fill="#818181"/>
        </svg>';
    return  $args;
}

add_filter('woocommerce_sale_flash', 'ds_change_sale_text');
function ds_change_sale_text() {
    
    return '<span class="onsale">Sale</span>';
}

/**
 * Get HTML for ratings.
 *
 * @since  3.0.0
 * @param  float $rating Rating being shown.
 * @param  int   $count  Total number of ratings.
 * @return string
 */
function wc_get_rating_html_universal( $rating, $count = 0 ) {
	$html = '';
	if ( 0 < $rating ) {
		/* translators: %s: rating */
		$label = sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating );
		$html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">'. 
            '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.96887 1.9132L9.87608 6.30088L9.99093 6.56512L10.2771 6.59824L14.8981 7.13309L11.4798 10.4648L11.287 10.6527L11.3378 10.9172L12.2517 15.6769L8.21951 13.341L7.96729 13.1949L7.71587 13.3424L3.74979 15.6691L4.66224 10.9172L4.71301 10.6527L4.5202 10.4648L1.10068 7.13189L5.66123 6.59817L5.94698 6.56473L6.06167 6.30088L7.96887 1.9132Z" stroke="#C5A477"/>
            </svg>'. 
            '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.96887 1.9132L9.87608 6.30088L9.99093 6.56512L10.2771 6.59824L14.8981 7.13309L11.4798 10.4648L11.287 10.6527L11.3378 10.9172L12.2517 15.6769L8.21951 13.341L7.96729 13.1949L7.71587 13.3424L3.74979 15.6691L4.66224 10.9172L4.71301 10.6527L4.5202 10.4648L1.10068 7.13189L5.66123 6.59817L5.94698 6.56473L6.06167 6.30088L7.96887 1.9132Z" stroke="#C5A477"/>
            </svg>'. 
            '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.96887 1.9132L9.87608 6.30088L9.99093 6.56512L10.2771 6.59824L14.8981 7.13309L11.4798 10.4648L11.287 10.6527L11.3378 10.9172L12.2517 15.6769L8.21951 13.341L7.96729 13.1949L7.71587 13.3424L3.74979 15.6691L4.66224 10.9172L4.71301 10.6527L4.5202 10.4648L1.10068 7.13189L5.66123 6.59817L5.94698 6.56473L6.06167 6.30088L7.96887 1.9132Z" stroke="#C5A477"/>
            </svg>'. 
            '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.96887 1.9132L9.87608 6.30088L9.99093 6.56512L10.2771 6.59824L14.8981 7.13309L11.4798 10.4648L11.287 10.6527L11.3378 10.9172L12.2517 15.6769L8.21951 13.341L7.96729 13.1949L7.71587 13.3424L3.74979 15.6691L4.66224 10.9172L4.71301 10.6527L4.5202 10.4648L1.10068 7.13189L5.66123 6.59817L5.94698 6.56473L6.06167 6.30088L7.96887 1.9132Z" stroke="#C5A477"/>
            </svg>'.
            '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.96887 1.9132L9.87608 6.30088L9.99093 6.56512L10.2771 6.59824L14.8981 7.13309L11.4798 10.4648L11.287 10.6527L11.3378 10.9172L12.2517 15.6769L8.21951 13.341L7.96729 13.1949L7.71587 13.3424L3.74979 15.6691L4.66224 10.9172L4.71301 10.6527L4.5202 10.4648L1.10068 7.13189L5.66123 6.59817L5.94698 6.56473L6.06167 6.30088L7.96887 1.9132Z" stroke="#C5A477"/>
            </svg>'
        .wc_get_star_rating_html_universal( $rating, $count ) . '</div>';
	}

	return apply_filters( 'woocommerce_product_get_rating_html', $html, $rating, $count );
}


/**
 * Get HTML for star rating.
 *
 * @since  3.1.0
 * @param  float $rating Rating being shown.
 * @param  int   $count  Total number of ratings.
 * @return string
 */
function wc_get_star_rating_html_universal( $rating, $count = 0 ) {
	$html = '<span data-r="'.$rating.'" style="width:' . ( ( $rating / 5 ) * 100 ) . '%">'. 
        '<div class="conteiner-stars"><svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.96887 0.658936L10.3346 6.10156L16 6.7573L11.8288 10.8229L12.9494 16.6589L7.96887 13.7737L3.05058 16.6589L4.17121 10.8229L0 6.7573L5.60311 6.10156L7.96887 0.658936Z" fill="#C5A477"/>
        </svg>'.
        '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.96887 0.658936L10.3346 6.10156L16 6.7573L11.8288 10.8229L12.9494 16.6589L7.96887 13.7737L3.05058 16.6589L4.17121 10.8229L0 6.7573L5.60311 6.10156L7.96887 0.658936Z" fill="#C5A477"/>
        </svg>'.
        '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.96887 0.658936L10.3346 6.10156L16 6.7573L11.8288 10.8229L12.9494 16.6589L7.96887 13.7737L3.05058 16.6589L4.17121 10.8229L0 6.7573L5.60311 6.10156L7.96887 0.658936Z" fill="#C5A477"/>
        </svg>'.
        '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.96887 0.658936L10.3346 6.10156L16 6.7573L11.8288 10.8229L12.9494 16.6589L7.96887 13.7737L3.05058 16.6589L4.17121 10.8229L0 6.7573L5.60311 6.10156L7.96887 0.658936Z" fill="#C5A477"/>
        </svg>'.
        '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.96887 0.658936L10.3346 6.10156L16 6.7573L11.8288 10.8229L12.9494 16.6589L7.96887 13.7737L3.05058 16.6589L4.17121 10.8229L0 6.7573L5.60311 6.10156L7.96887 0.658936Z" fill="#C5A477"/>
        </svg></div>';

	if ( 0 < $count ) {
		/* translators: 1: rating 2: rating count */
		$html .= sprintf( _n( 'Rated %1$s out of 5 based on %2$s customer rating', 'Rated %1$s out of 5 based on %2$s customer ratings', $count, 'woocommerce' ), '<strong class="rating">' . esc_html( $rating ) . '</strong>', '<span class="rating">' . esc_html( $count ) . '</span>' );
	} else {
		/* translators: %s: rating */
		$html .= sprintf( esc_html__( 'Rated %s out of 5', 'woocommerce' ), '<strong class="rating">' . esc_html( $rating ) . '</strong>' );
	}

	$html .= '</span>';

	return apply_filters( 'woocommerce_get_star_rating_html', $html, $rating, $count );
}


function modify_stock_single_page( $html, $product ) {

    $qty = $product->get_stock_quantity();

    if ( $product->is_in_stock() ) {
        $html = '<p class="in-stock">In stock ('.$qty.')</p>'; 

    }  else {

        $html = '<p class="in-stock out-stock">Out of stock ('.$qty.')</p>'; 
    }

    return $html;
}
add_filter( 'woocommerce_get_stock_html', 'modify_stock_single_page', 10, 2 );



add_action('woocommerce_after_add_to_cart_form', 'link_shipping_single_product');
function link_shipping_single_product() {
    $link_page_shipping_terms = get_field('shipping_page','options');
    $text_button = get_field('text_link_shipping','options');
    $text = get_field('text_shipping','options');
    
    $html = '<div class="link-shipping-single-product">
                <span class="icon-link">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="19.8699" cy="20.0288" r="19.8699" fill="#E8E8E8"/>
                        <g clip-path="url(#clip0_746_15566)">
                        <path d="M20 11L28 15.5V24.5L20 29L12 24.5V15.5L20 11Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 20L28 15.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 20V29" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 20L12 15.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M24 13.25L16 17.75" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_746_15566">
                        <rect width="24" height="24" fill="white" transform="translate(8 8)"/>
                        </clipPath>
                        </defs>
                    </svg>
                </span>
                <span class="text-shipping">'.$text.' <a href="'.$link_page_shipping_terms.'">'.$text_button.'</a></span>'.
    '</div>';
    echo $html;
}


remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product', 'woocommerce_output_related_products');

remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );
add_action( 'woocommerce_review_before_comment_text', 'woocommerce_review_display_rating', 10);

add_action( 'woocommerce_single_product_summary','inner_summary_wrap_start', 4 );

function inner_summary_wrap_start() {
    echo '<div class="inner-summary-wrap">';
}

add_action( 'woocommerce_single_product_summary','inner_summary_wrap_end', 61 );

function inner_summary_wrap_end() {
    echo '</div>';
}


function check_bought_products($comment) {
    global $wpdb;
    $user_id = $comment->user_id;
    $prod_id = $comment->comment_post_ID;
    $templ ='';
    $countProd = $wpdb->get_var( 
        $wpdb->prepare( 
            "
                SELECT count(*) 
                FROM ".$wpdb->prefix."wc_order_product_lookup 
                WHERE customer_id = %d and product_id= %d
            ", 
            $user_id,
            $prod_id

        )
    );
    if($countProd > 0) {
        $templ = '<div class="container-verified-purchase">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 11.1771V12.0051C20.9989 13.9459 20.3704 15.8344 19.2084 17.3888C18.0463 18.9432 16.413 20.0804 14.5518 20.6307C12.6907 21.1809 10.7015 21.1149 8.88102 20.4423C7.06051 19.7697 5.50619 18.5266 4.44986 16.8985C3.39354 15.2704 2.89181 13.3444 3.01951 11.4078C3.14721 9.47126 3.89749 7.62784 5.15845 6.15252C6.41942 4.67719 8.12351 3.649 10.0166 3.22128C11.9096 2.79357 13.8902 2.98925 15.663 3.77915" stroke="#4CAF50" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                    <path d="M21 5L11.7692 14L9 11.3027" stroke="#4CAF50" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                </svg>
                Verified purchase
            </div>';

    }
    
    echo $templ;
}
add_action( 'woocommerce_review_comment_text', 'check_bought_products', 11 );


add_filter( 'get_comment_text', 'hide_big_comment', 10, 2 );
function hide_big_comment($comment_text, $comment = null) { 
    $comment_length = str_word_count($comment_text);
    if($comment_length < 60) {
        return $comment_text;
    } else {

   
        $trimmed_content = wp_trim_words( $comment_text, 60, '');
        
    $templ = '<div class="hide-big-comment-block"><div class="full-descr-dropdown">'.$comment_text.'</div><div class="trimm-descr-dropdown show">'.$trimmed_content
        .'</div><div class="row-but-container"><button class="read-more-dropdown but-read-more-comment"><span>Read more</span> <svg width="12" height="6" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7L8 0.999999L14 7" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/></svg></button></div></div>';
    return $templ;

 }
}

//Allowed empty  text comment 
add_filter( 'allow_empty_comment', '__return_true' );


add_action( 'wp_ajax_loadmore_comments', 'load_more_comments' );
add_action( 'wp_ajax_nopriv_loadmore_comments', 'load_more_comments' );

function load_more_comments() {
    $per_page = 5;
    $pagenum = $_POST['pagenum'] ?? 1;
    $offset = ($pagenum - 1) * $per_page;
    $prod_id = $_POST['prodId'];

   
    $comquery = get_comments( [
        'order'   => 'ASC',
        'offset'  => $offset,
        'post_id' => $prod_id,
        'number'  => $per_page,
        'no_found_rows'  => false,
    ] );
    
    $res = '';
   
    if( $comquery ){
        $res = wp_list_comments(array(
            // 'per_page' => 5,
            'reverse_top_level' => true,
            'echo' => false,
            'callback' => 'woocommerce_comments'
        ), $comquery);
    }
   
    echo $res;
    // wp_send_json( array(
    //     'status'   => 'success',
    //     'prodId' => $prod_id,
    //     'per_page' => $per_page,
    //     'pagenum' => $pagenum,
        
    // ) );
    wp_die();
}


function changeDateComment($commentDate) {
    $today = date("Y-m-d");
    $first_date = new DateTime($today);
    $second_date = new DateTime($commentDate);
    $diff =  $second_date->diff($first_date);
            
    $date_ago='';
    if (floor($diff->days / 2) > 182) {
        $date_ago = esc_html( $commentDate);
    } elseif($diff->m >= 1) {

        $date_ago = esc_html($diff->m.' months ago');

    } elseif(floor($diff->days / 7) >= 1) {
        
        $date_ago = esc_html(floor($diff->days / 7).' weeks ago');

    } else {
        if($date_ago = $diff->days == 0) {
            $date_ago = 'today';
        } else {
            $date_ago = $diff->days.' days ago';
        }
        
    }
    return $date_ago;
}

/**
 * Get HTML for a gallery image.
 *
 * Hooks: woocommerce_gallery_thumbnail_size, woocommerce_gallery_image_size and woocommerce_gallery_full_size accept name based image sizes, or an array of width/height values.
 *
 * @since 3.3.2
 * @param int  $attachment_id Attachment ID.
 * @param bool $main_image Is this the main image or a thumbnail?.
 * @return string
 */
function wc_get_gallery_image_html_uwfs( $attachment_id, $main_image = false ) {
	$flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
	$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
	$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
	$image_size        = apply_filters( 'woocommerce_gallery_image_size', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size );
	$full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
	$thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
	$full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
	$alt_text          = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
	$image             = wp_get_attachment_image(
		$attachment_id,
		$image_size,
		false,
		apply_filters(
			'woocommerce_gallery_image_html_attachment_image_params',
			array(
				'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
				'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
				'data-src'                => esc_url( $full_src[0] ),
				'data-large_image'        => esc_url( $full_src[0] ),
				'data-large_image_width'  => esc_attr( $full_src[1] ),
				'data-large_image_height' => esc_attr( $full_src[2] ),
				'class'                   => esc_attr( $main_image ? 'wp-post-image' : '' ),
			),
			$attachment_id,
			$image_size,
			$main_image
		)
	);

	return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="woocommerce-product-gallery__image">
                <a class="button-single-img-scale" href="' . esc_url( $full_src[0] ) . '">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23.5" fill="#F5F5F5" stroke="#818181"/>
                        <g clip-path="url(#clip0_451_3337)">
                        <path d="M16 28L16 32L20 32" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                        <path d="M22.7071 26.7071L23.4142 26L22 24.5858L21.2929 25.2929L22.7071 26.7071ZM15.2929 31.2929C14.9024 31.6834 14.9024 32.3166 15.2929 32.7071C15.6834 33.0976 16.3166 33.0976 16.7071 32.7071L15.2929 31.2929ZM21.2929 25.2929L15.2929 31.2929L16.7071 32.7071L22.7071 26.7071L21.2929 25.2929Z" fill="black"/>
                        <path d="M32 20L32 16L28 16" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                        <path d="M32.7071 16.7071C33.0976 16.3166 33.0976 15.6834 32.7071 15.2929C32.3166 14.9024 31.6834 14.9024 31.2929 15.2929L32.7071 16.7071ZM25.2929 21.2929L24.5858 22L26 23.4142L26.7071 22.7071L25.2929 21.2929ZM31.2929 15.2929L25.2929 21.2929L26.7071 22.7071L32.7071 16.7071L31.2929 15.2929Z" fill="black"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_451_3337">
                        <rect width="24" height="24" fill="white" transform="translate(36 12) rotate(90)"/>
                        </clipPath>
                        </defs>
                    </svg>
                </a>' . $image . '</div>';
}


add_action('woocommerce_after_main_content', 'wrap_form');
function wrap_form() {
   echo  '<div class="popup popup-revie-form popup-waiting-list" data-popup="popup-waiting-list"  data-close-overlay>
		    <div class="popup__wrapper" data-close-overlay>
			    <div class="popup__content">
                <button class="popup__close button-close" type="button">
					<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M18.5762 6.08643L6.57617 18.0864M6.57617 6.08643L18.5762 18.0864" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
					</svg>
				</button>'.
                    do_shortcode('[ywcwtl_form]').
            '</div></div></div>';
}

add_action( 'woocommerce_after_main_content', 'modal_share_links' );
function modal_share_links() {
    $share_title = get_the_title();
    $encoded_title = urlencode($share_title);
    $encoded_link = urlencode(get_permalink());
    $encoded_tweet_url = urlencode(get_permalink());
    $encoded_tweet_text = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));
        // links
    $facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_link;
    $twitter = 'https://twitter.com/intent/tweet?url=' . $encoded_tweet_url . '&text=' . $encoded_tweet_text;
    $whatsapp = 'https://wa.me/?text=' . $encoded_link;
    $linkedin = 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . $encoded_link . '&amp;title=' . $encoded_title;
    $mailshare = 'https://www.addtoany.com/add_to/email?linkurl='. rawurlencode( home_url() ) . $encoded_link. '&linkname=' . $encoded_title .'&linknote=';
    $telegram = 'https://telegram.me/share/url?url='.$encoded_link.'&text='.$share_title;
    $instagram = '';
    ?>
    <div class="popup popup-revie-form popup-sharing-link" data-popup="popup-sharing-link"  data-close-overlay>
        <div class="popup__wrapper" data-close-overlay>
            <div class="popup__content">
                <button class="popup__close button-close" type="button">
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.5762 6.08643L6.57617 18.0864M6.57617 6.08643L18.5762 18.0864" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                    </svg>
                </button>
                <p class="social__title">Share this product</p>
                <div class="modal-block-social">
                    <p class="sub-title-sharing">via social media</p>
                    <div class="socials">
                        <a href="<?= $facebook; ?>" target="_blank" class="social__link">
                            <svg width="53" height="53" viewBox="0 0 53 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="1.15234" y="1" width="51" height="51" rx="25.5" fill="white"/>
                                <g clip-path="url(#clip0_825_19551)">
                                <path d="M28.1431 37.4971V27.4642H31.0915L31.5329 23.5542H28.1431V21.0578C28.1431 19.9257 28.4184 19.1542 29.8397 19.1542L31.6523 19.1533V15.6562C31.3387 15.6087 30.2628 15.5023 29.011 15.5023C26.3975 15.5023 24.6083 17.3244 24.6083 20.6707V23.5543H21.6523V27.4643H24.6082V37.4972L28.1431 37.4971Z" fill="#3C5A9A"/>
                                </g>
                                <rect x="1.15234" y="1" width="51" height="51" rx="25.5" stroke="#BFBFBF"/>
                                <defs>
                                <clipPath id="clip0_825_19551">
                                <rect width="10" height="22" fill="white" transform="translate(21.6523 15.5)"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </a>
                        <a href="<?= $twitter; ?>" target="_blank" class="social__link">
                            <svg width="53" height="53" viewBox="0 0 53 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="1.15234" y="1" width="51" height="51" rx="25.5" fill="white"/>
                                <path d="M14.7109 15.5L23.977 27.8897L14.6523 37.963H16.7509L24.9147 29.1437L31.5107 37.963H38.6523L28.8649 24.8764L37.5442 15.5H35.4456L27.9272 23.6225L21.8525 15.5H14.7109ZM17.797 17.0458H21.0779L35.5657 36.417H32.2848L17.797 17.0458Z" fill="black"/>
                                <rect x="1.15234" y="1" width="51" height="51" rx="25.5" stroke="#BFBFBF"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="modal-block-social">
                    <p class="sub-title-sharing">or email it to your friend</p>
                    <div class="modal-form-submit">
                        <div class="input-element">
                                                
                            <input type="email" id="email-modal-sharing" data-label-control  placeholder="">
                            <label for="email-modal-sharing">Friend's email*</label>
                            <span class="icon-error">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z" fill="#BB0000"/>
                                    <path d="M12.4732 14.0508H11.5162C11.4752 14.0508 11.4524 14.028 11.4478 13.9824L11.1539 10.7627V6.95508C11.1539 6.90951 11.1721 6.88672 11.2086 6.88672H12.7808C12.8264 6.88672 12.8492 6.90951 12.8492 6.95508L12.8355 10.7627L12.5416 13.9824C12.537 14.028 12.5142 14.0508 12.4732 14.0508ZM12.7808 16.6279H11.2086C11.1721 16.6279 11.1539 16.6051 11.1539 16.5596V15.0352C11.1539 14.9941 11.1721 14.9736 11.2086 14.9736H12.7808C12.8173 14.9736 12.8355 14.9941 12.8355 15.0352V16.5596C12.8355 16.6051 12.8173 16.6279 12.7808 16.6279Z" fill="white"/>
                                </svg>
                            </span>
                            
                        </div>
                        <div class="input-element">
                                                
                            <input type="email" id="email-friends-modal-sharing" data-label-control  placeholder="">
                            <label for="email-friends-modal-sharing">Your email*</label>
                            <span class="icon-error">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z" fill="#BB0000"/>
                                    <path d="M12.4732 14.0508H11.5162C11.4752 14.0508 11.4524 14.028 11.4478 13.9824L11.1539 10.7627V6.95508C11.1539 6.90951 11.1721 6.88672 11.2086 6.88672H12.7808C12.8264 6.88672 12.8492 6.90951 12.8492 6.95508L12.8355 10.7627L12.5416 13.9824C12.537 14.028 12.5142 14.0508 12.4732 14.0508ZM12.7808 16.6279H11.2086C11.1721 16.6279 11.1539 16.6051 11.1539 16.5596V15.0352C11.1539 14.9941 11.1721 14.9736 11.2086 14.9736H12.7808C12.8173 14.9736 12.8355 14.9941 12.8355 15.0352V16.5596C12.8355 16.6051 12.8173 16.6279 12.7808 16.6279Z" fill="white"/>
                                </svg>
                            </span>
                           
                        </div>
                        <div class="input-element">
                            <textarea  id="comments-modal-sharing" data-label-control  placeholder=""></textarea>
                            <label for="comments-modal-sharing">Your comment</label>
                            <span class="icon-error">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z" fill="#BB0000"/>
                                    <path d="M12.4732 14.0508H11.5162C11.4752 14.0508 11.4524 14.028 11.4478 13.9824L11.1539 10.7627V6.95508C11.1539 6.90951 11.1721 6.88672 11.2086 6.88672H12.7808C12.8264 6.88672 12.8492 6.90951 12.8492 6.95508L12.8355 10.7627L12.5416 13.9824C12.537 14.028 12.5142 14.0508 12.4732 14.0508ZM12.7808 16.6279H11.2086C11.1721 16.6279 11.1539 16.6051 11.1539 16.5596V15.0352C11.1539 14.9941 11.1721 14.9736 11.2086 14.9736H12.7808C12.8173 14.9736 12.8355 14.9941 12.8355 15.0352V16.5596C12.8355 16.6051 12.8173 16.6279 12.7808 16.6279Z" fill="white"/>
                                </svg>
                            </span>
                           
                        </div>

                        <button type="submit" id="but-send-mail-friend" class="button-main button-brown">send</button>
                        <div id="notification-email-send" class="notification-style notification-email-send">
                                Email sent
                            </div>
                    </div>   
                </div>
                <div class="footer-modal-submit">
                    <div class="link-elem-clipboard">
                        
                        <button id="button-clipboard-copy-link" data-link-product="<?php echo get_permalink(); ?>" class="button-icon-style-left button-share-link-copy">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_531_9016)">
                                <path d="M16 21H5C4.44772 21 4 20.5523 4 20V8" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 16C8 16.5523 8.44772 17 9 17H19C19.5523 17 20 16.5523 20 16V6C20 4.34315 18.6569 3 17 3H11C9.34315 3 8 4.34315 8 6V16Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_531_9016">
                                <rect width="24" height="24" fill="white" transform="matrix(1 0 0 -1 0 24)"/>
                                </clipPath>
                                </defs>
                            </svg>
                            Copy link
                        </button>
                        <div id="notification-link-copied" class="notification-style notification-link-copied">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.75 8.38286V9.00386C15.7492 10.4594 15.2778 11.8758 14.4063 13.0416C13.5348 14.2074 12.3097 15.0603 10.9139 15.473C9.51801 15.8857 8.02615 15.8361 6.66077 15.3317C5.29538 14.8273 4.12964 13.895 3.3374 12.6739C2.54515 11.4528 2.16886 10.0083 2.26463 8.55587C2.3604 7.10344 2.92311 5.72088 3.86884 4.61439C4.81456 3.50789 6.09263 2.73675 7.51243 2.41596C8.93222 2.09518 10.4177 2.24194 11.7473 2.83436" stroke="white" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/>
                                <path d="M15.75 3.75L8.82692 10.5L6.75 8.47702" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                            </svg>  
                            <?php esc_html_e( 'Copied to clipboard', 'ufws' ); ?>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <?php

}

add_filter('wc_add_to_cart_message', 'handler_function_name', 10, 2);
function handler_function_name($message, $product_id) {
    return "<div>".$message."</div>";
}

add_action( 'woocommerce_before_single_product_summary', 'mobile_top_single_product', 8);

function mobile_top_single_product() {
    global $product;
    ?>
    <div class="mobile-top-header">
        <?php  sku_product_templ_new(); ?>
        <h1 class="product_title entry-title"><?php echo  $product->get_title(); ?></h1>
        <?php 
			$rating_count = $product->get_rating_count();
			$average      = $product->get_average_rating();
			
			if ( $rating_count && wc_review_ratings_enabled() ) {
				echo '<div class="raiting-star-informs">'.wc_get_rating_html_universal( $average ).'</div>'; // WPCS: XSS ok.
			}
            global $post, $product;
            echo '<div class="loop-badges mobile-single-badge">';
                if ( $product->is_on_sale() ) : ?>

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
            echo '</div>';
		
		?>
    </div>
<?php
}

function action_woocommerce_product_query( $q ) {
    if ( is_admin() ) return;

    // Isset & NOT empty
    if ( isset( $_GET['onsale'] ) ) {
        // Equal to 1
        if ( $_GET['onsale'] == 1 ) {
            //  Function that returns an array containing the IDs of the products that are on sale.
            $product_ids_on_sale = wc_get_product_ids_on_sale();

            $q->set( 'post__in', $product_ids_on_sale );
        }
    }
}
add_action( 'woocommerce_product_query', 'action_woocommerce_product_query', 10, 1 );

add_filter( 'woocommerce_product_tabs', 'misha_rename_additional_info_tab' );

function misha_rename_additional_info_tab( $tabs ) {

	$tabs[ 'additional_information' ][ 'title' ] = 'Delivery information';

	return $tabs;

}

add_filter( 'woocommerce_cart_product_not_enough_stock_already_in_cart_message', '__return_false');


add_filter( 'woocommerce_email_styles', 'woocommerce_email_styles' );
function woocommerce_email_styles( $css ) {
    
    $css .= "
            #template_header{
                background-color: #fff;
            }
            .yith-wcwtl-product-info{	
                background-color: #fff;
  
            }
            table#template_footer table{
                padding: 0;
            }
            table#template_footer {
                background-color: #000;
            }
           
        ";
    
    return $css;
}