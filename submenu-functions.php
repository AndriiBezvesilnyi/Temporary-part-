<?php 

class Product_Walker extends Walker_Nav_Menu
{
    // $category = get_term( TERM_ID, 'product_cat' );
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes = empty($item->classes) ? array() : (array)$item->classes;

        if($item->object == 'product_cat' && $item->title != 'Recipes' && $item->title != 'Accessories' && $item->title != 'Membership Clubs' && $item->title != "Valentine's Day" ) {
            
			$classes[] = 'menu-item-has-children-attr';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
                
        !empty ($class_names) and $class_names = ' class="' . esc_attr($class_names) . '"';
        $output .= "<li id='menu-item-$item->ID' $class_names>";
        $attributes = '';
        !empty($item->attr_title) and $attributes .= ' title="' . esc_attr($item->attr_title) . '"';
        !empty($item->target) and $attributes .= ' target="' . esc_attr($item->target) . '"';
        !empty($item->xfn) and $attributes .= ' rel="' . esc_attr($item->xfn) . '"';
        !empty($item->url) and $attributes .= ' href="' . esc_attr($item->url) . '"';
              
       
        if($item->object == 'product_cat' && $item->title != 'Recipes' && $item->title != 'Accessories' && $item->title != 'Membership Clubs' && $item->title != "Valentine's Day" ) {
			$termProd = get_term((int)$item->object_id);


			$innMenuAttr = queryCustomSubmenu($termProd->slug);
			// do_action( 'qm/info', $item  );
        } else {
            
            $innMenuAttr ='';
        }
        $title = apply_filters('the_title', $item->title, $item->ID);
        $item_output = $args->before
            . "<a $attributes >"
            . $args->link_before
            . $title
            . '</a>'.$innMenuAttr
            . $args->link_after
            . $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

class subMenuAttribute {
	private $array_id_attributes =[];
	private $attr_arr_prod = [];
	public  $terms_category;
	public  $category_link;
	public  $category_title;
	private $taxonomy = ['pa_brand','pa_country-or-state','pa_style', 'pa_type_product', 'pa_varietal', 'pa_vintage'];
	private $taxonomyUrl = ['pa_brand' => 'brand',
							'pa_country-or-state' => 'country',
							'pa_style' => 'style', 
							'pa_type_product' => 'type', 
							'pa_varietal' => 'varietal', 
							'pa_vintage' => 'vintage'];
	
    public $innMenu ='';
	private $popular_field_menu_category = [
											'wine' => 'popular_products_in_wine', 
											'beer' => 'popular_products_in_beer', 
											'brandy' => 'popular_products_in_brandy', 
											'rum' => 'popular_products_in_rum',
											'tequila' => 'popular_products_in_tequila',
											'gin' => 'popular_products_in_gin',
											'whiskey' => 'popular_products_in_whiskey',
											'vodka' => 'popular_products_in_vodka',
											'moonshine' => 'popular_products_in_moonshine',
											'mezcal' => 'popular_products_in_mezcal',
											'liqueur' => 'popular_products_in_liqueur',
											'cognac' => 'popular_products_in_cognac',
											'cachaca' => 'popular_products_in_cachaca',
											'mixers' => 'popular_products_in_mixers'
										];

    public function __construct($terms, $category_link, $category_title)  {
        $this->terms_category = $terms;
		$this->category_link = $category_link;
		$this->category_title = $category_title;
		$this->createTableSubmenu(); 
		$this->getTermsTaxonomy();
	    $this->createBoxMenu();
    }
	private function query_category() {
		$args = array(
			'posts_per_page'=> -1,
			'post_type' => 'product',
			'post_status'   => 'publish',
			// 'post_in' => ['16112', '16109'],
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => $this->terms_category, 
				)
			),
			'orderby' => 'date',
			'order' => 'DESC'
		); 

		$attr_cur='';
		$block_products = new WP_Query( $args );

		while ( $block_products->have_posts() ): $block_products->the_post(); 
				global $product; 
				
					$attr_cur = $product->get_attributes();
					if($this->terms_category == 'wine') {

						// $this->setArrayAttribute($attr_cur, 'pa_style');
						$this->setArrayAttribute($attr_cur, 'pa_type_product');
						$this->setArrayAttribute($attr_cur, 'pa_varietal');
						$this->setArrayAttribute($attr_cur, 'pa_country-or-state');

					} elseif ($this->terms_category == 'beer') {

						$this->setArrayAttribute($attr_cur, 'pa_style');
						$this->setArrayAttribute($attr_cur, 'pa_brand');
						$this->setArrayAttribute($attr_cur, 'pa_country-or-state');

					} 
					// elseif ($this->terms_category == 'whiskey') {

					// 	$this->setArrayAttribute($attr_cur, 'pa_type_product');
					// 	$this->setArrayAttribute($attr_cur, 'pa_brand');
					// 	$this->setArrayAttribute($attr_cur, 'pa_country-or-state');

					// } 
					else {
						$this->setArrayAttribute($attr_cur, 'pa_type_product');
						$this->setArrayAttribute($attr_cur, 'pa_brand');
						$this->setArrayAttribute($attr_cur, 'pa_country-or-state');
					}
					

        endwhile; wp_reset_postdata();
	}

	private function setArrayAttribute($attr_product, $pa_attribute) {
		if(array_key_exists($pa_attribute, $attr_product)) {
			
			$attr = $attr_product[$pa_attribute]->get_options();
			if($attr) {
				$item_attr = $attr[0];
				
				if(array_key_exists($pa_attribute, $this->attr_arr_prod)) {
					
					if(array_key_exists($item_attr, $this->attr_arr_prod[$pa_attribute])) {
						$this->attr_arr_prod[$pa_attribute][$item_attr] += 1;
					} else {
						$this->attr_arr_prod[$pa_attribute][$item_attr] = 1;
					}
				} else {
					$this->attr_arr_prod[$pa_attribute] = [];
				}
			}
			
		}
	}

	private function getTermsTaxonomy() {
		$terms = get_terms( array(
			'taxonomy'   => $this->taxonomy,
			'hide_empty' => false,
		) );
		
		foreach($terms as $term) {
			
			$this->array_id_attributes[$term->term_id] = ['name' =>$term->name, 'slug' => $term->slug, 'taxonomy' => $term->taxonomy ];
		}

	
	}
	private function liItemMenu($name, $count, $name_attr, $index_item) {

		$siteLink = get_site_url();
		$category = 'product-category';
		if(array_key_exists($name, $this->array_id_attributes)) {

			$text = $this->array_id_attributes[$name]['name'].'<span>('.$count.')</span>';
			
			$link_attr = explode(' ', strtolower($this->array_id_attributes[$name]['name']));
			$link_attr = implode('-', $link_attr);
			$query_link = $this->taxonomyUrl[$name_attr].'='.$link_attr;
			
		} else {
			$text = $name.'<span>('.$count.')</span>'; 
			$link_attr = explode(' ', strtolower($name));
			$link_attr = implode('-', $link_attr);
			$query_link = $name_attr.'='.$link_attr;
		}
		
		$link = $siteLink.'/shop/?'.$category.'='.$this->terms_category.'&'.$query_link;
		
		
		$li = '<li id="menu-item-sub-'.$index_item.'" class="menu-item"><a href="'.$link.'">'.$text.'</a></li>';
		return $li;
	}

	public function popularProductsMenu() {
		if(array_key_exists($this->terms_category, $this->popular_field_menu_category)): 
			$popular_posts = get_field($this->popular_field_menu_category[$this->terms_category], 'option');
			
			if( $popular_posts ): 
				$html = '<div class="inner-sub-menu inner-sub-menu-4"><div class="title-inner-sub-menu">Popular</div><div class="popular-menu-container">';
				foreach( $popular_posts as $popular ): 
					$permalink = get_permalink( $popular->ID );
					$title = get_the_title( $popular->ID );
					$img = get_the_post_thumbnail($popular->ID, 'thumbnail');
					$product = wc_get_product( $popular->ID );
					
					$html .= '	<a href="'.$permalink.'" class="product-item-menu">'
									.$img
									.'<div class="content-popular-menu-product">
										<p>'.$title.'</p>
										<span class="price-popular-item">'.$product->get_price_html().'</span>
									</div>
								</a>';      	
					
				endforeach; 
				
				$html .= '</div></div>';

				return $html;
			else:
			
				return $html = '';

			endif;
		endif;
	}

	public function createBoxMenu() {
		$this->query_category();

		$countCurrentSubMenu = count($this->attr_arr_prod);

		$popular_menu = $this->popularProductsMenu();
		if($popular_menu) {
			++$countCurrentSubMenu;	
		}

        $this->innMenu .= '<div class="wrapper-sub-menu">
                    <div class="inner-wrapper-sub-menu count-items-'.$countCurrentSubMenu.'">'; 
				$index_el = 1;
				$index_menu = 1;
				// do_action( 'qm/info', count($this->attr_arr_prod)  );
				
							
				foreach( $this->attr_arr_prod as $key => $item_attr ) { 	
                    $this->innMenu .= '<div class="inner-sub-menu inner-sub-menu-'.$index_menu.'">
							<div class="title-inner-sub-menu">'.get_taxonomy( $key)->labels->singular_name.'</div>
								<ul class="sub-menu">';

								
                                        $inn_count = 1;
										foreach($item_attr as $key_li => $li_item) {
											$num_id = $this->terms_category.'-'.$index_menu.'-'.$index_el;
											$this->innMenu .= $this->liItemMenu($key_li, $li_item, $key, $num_id );
											++$index_el;
																					
												if($inn_count == 12) {
													break;
												}

                                            ++$inn_count;
											 
										}
                    $this->innMenu.= '</ul>
										
						    </div>';
			
					++$index_menu;

				}
							
			
                $this->innMenu.= $popular_menu.'</div><div class="row-menu-button"><a href="'.$this->category_link.'" class="button-text-link">View all '.$this->category_title.'</a></div></div>'; 

				$this->insertSubmenuTable($this->innMenu);
				
	}
	private function insertSubmenuTable($html_sub_menu_item) {
		global $wpdb;
		$table_yes = $wpdb->get_var("uv_submenu_items");
		$category_in = $wpdb->get_var( $wpdb->prepare("SELECT id FROM `uv_submenu_items` WHERE sub_category_slug=%s ", $this->terms_category ));
				
		if($category_in) {
			$data =  array(
				'id' => $category_in,
				'sub_category_slug' => $this->terms_category,
				'sub_menu_template' => $html_sub_menu_item
			);
			$data_format = array('%d', '%s', '%s');
			
		} else {
			$data =  array(
			
				'sub_category_slug' => $this->terms_category,
				'sub_menu_template' => $html_sub_menu_item
			);
			$data_format = array('%s', '%s');
			
		}
		
		// do_action( 'qm/info', $data_format  );

		$ins = $wpdb->replace('uv_submenu_items', $data, $data_format);

	
	}
	private function createTableSubmenu() {
		global $wpdb;
		$table_yes = $wpdb->get_var("show tables like 'uv_submenu_items'");
		if($table_yes != 'uv_submenu_items') {

			$wpdb->query('CREATE TABLE `uv_submenu_items` (
									`id` bigint(20) NOT NULL,
									`sub_category_slug` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
									`sub_menu_template` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

								
								
			');
			$wpdb->query('ALTER TABLE `uv_submenu_items`  ADD PRIMARY KEY (`id`);');
			$wpdb->query('ALTER TABLE `uv_submenu_items`
						MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1; ');
			
		}

		
	}
}

function queryCustomSubmenu($slug_category) {
	global $wpdb;
	
	$menu = $wpdb->get_var( $wpdb->prepare("SELECT sub_menu_template FROM `uv_submenu_items` WHERE sub_category_slug=%s ", $slug_category ));
	
	return $menu;
}

function getMenuItems() {
	$menu_items = wp_get_nav_menu_items('Main Menu');
	foreach ( (array) $menu_items as $key => $menu_item ) {
		
		if($menu_item->object == 'product_cat' && $menu_item->title != 'Recipes' && $menu_item->title != 'Accessories' && $menu_item->title != 'Membership Clubs' && $menu_item->title != "Valentine's Day" ) {
			$termProd = get_term((int)$menu_item->object_id);
			$attr_menu = new subMenuAttribute($termProd->slug, $menu_item->url, $menu_item->title);
				
			$attr_menu->innMenu;
		}
	
	}
	// do_action( 'qm/info', $menu_items );
}


add_action('wp_ajax_uv_submenu_update', 'getMenuItems');

//add_action( 'woocommerce_new_product', 'getMenuItems', 10, 1 );
//add_action( 'woocommerce_update_product', 'getMenuItems', 10, 1 );
add_action( 'woocommerce_order_status_completed','getMenuItems' );
