<?php 

add_action('wp_ajax_header_search', 'headerSearchForm');
add_action('wp_ajax_nopriv_header_search', 'headerSearchForm');

function headerSearchForm() {
    $stringSearch = $_POST['search'];
    $text_search = $stringSearch;
    // $count_res_global = allSearchResults($stringSearch);
    // $count_res_global = 1111;

    global $wpdb;
    $stringSearch = $wpdb->esc_like( $stringSearch ); 
    $stringSearch = '%' . $stringSearch . '%';  

    $search_res = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'product' AND post_title LIKE '".$stringSearch."'");
    
   
    $res_posts = '';
    $i = 1;
    foreach ( $search_res as $post ) {
        $id = $post->ID;
        $img = get_the_post_thumbnail($id, 'thumbnail');
        $link = get_permalink($id);

        $ss =  mb_substr($post->post_title, mb_stripos($post->post_title, $text_search), mb_strlen($text_search));
        
        $str_replace = '<span>'.$ss.'</span>';
        $title_replace = str_ireplace($text_search, $str_replace, $post->post_title);
        $product = wc_get_product( $id );
        
        $res_posts .= '<a href="'.$link.'" class="product-item-menu">'.
        $img .'<div class="content-popular-menu-product"><p>'.$title_replace.'</p><span class="price-popular-item">'.$product->get_price_html().'</span></div></a>';
        if($i == 20) {
            break;
        }
        ++$i;
    }
    wp_send_json( array(
        'status'   => 'success',
        'stringSearch' => $stringSearch,
        'results' => $res_posts,
        // 'count' => count($search_res)
        // 'count' => $count_res_global

    ));
}

function allSearchResults($serach_val) {
    $args = array(
        'post_type'      => 'product',
        'post_status'   => 'publish',
        'posts_per_page' => '-1',
        's' => $serach_val
     );
    $count_posts = 0;
    $result_search = new WP_Query($args);
    if ($result_search->have_posts()) :

        while ($result_search->have_posts()) :
            $result_search->the_post();
            
            ++$count_posts;

        endwhile;
        wp_reset_postdata();
  
        return $count_posts;
    
    endif;

  
}