<?php 

add_action('acf/init', 'ufws_blocks_init');
function ufws_blocks_init() {
    
    // check function exists
    if( function_exists('acf_register_block') ) {
        
        // register a testimonial block
        acf_register_block(array(
            'name'              => 'table-services',
            'title'             => __('UWFS table of services'),
            'description'       => __('Table of shipping services block.'),
            'render_callback'   => 'my_acf_block_render_callback',
            'category'          => 'UFWS',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'table' ),
        ));
        acf_register_block(array(
            'name'              => 'ufws-info-block',
            'title'             => __('UWFS info block'),
            'description'       => __('Gray info block in content'),
            'render_callback'   => 'my_acf_block_render_callback',
            'category'          => 'UFWS',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'info' ),
        ));
        acf_register_block(array(
            'name'              => 'ufws-button-outline-block',
            'title'             => __('UWFS outline button'),
            'description'       => __('Outline button'),
            'render_callback'   => 'my_acf_block_render_callback',
            'category'          => 'UFWS',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'button', 'link' ),
        ));
        acf_register_block(array(
            'name'              => 'ufws-image-popup',
            'title'             => __('UWFS image popup'),
            'description'       => __('Show image in popup'),
            'render_callback'   => 'my_acf_block_render_callback',
            'category'          => 'UFWS',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'photo', 'fedex' ),
        ));



        function my_acf_block_render_callback( $block ) {
    
            // convert name ("acf/testimonial") into path friendly slug ("testimonial")
            $slug = str_replace('acf/', '', $block['name']);
            
            // include a template part from within the "template-parts/block" folder
            if( file_exists( get_theme_file_path("/inc/blocks/blocks-functions/{$slug}.php") ) ) {
                include( get_theme_file_path("/inc/blocks/blocks-functions/{$slug}.php") );
            }
        }
    }
    add_filter( 'block_categories_all', 'ufws_category_block_register', 10, 2 );

    /**
     * Function for `block_categories_all` filter-hook.
     * 
     * @param array[]                 $block_categories     Array of categories for block types.
     * @param WP_Block_Editor_Context $block_editor_context The current block editor context.
     *
     * @return array[]
     */
    function ufws_category_block_register( $block_categories, $block_editor_context ){
        $new_cat = ['slug' => 'UFWS', 'title' => 'UFWS blocks',''];
        array_unshift($block_categories, $new_cat);
       
        return $block_categories;
    }
}