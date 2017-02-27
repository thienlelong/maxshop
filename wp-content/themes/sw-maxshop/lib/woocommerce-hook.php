<?php

/*minicart via Ajax*/
$ya_header = ya_options()->getCpanelValue('header_style');
if( $ya_header == 'style1' || $ya_header == 'style2' || $ya_header == 'style4' ){
	add_filter('add_to_cart_fragments', 'ya_add_to_cart_fragment', 100);	
	function ya_add_to_cart_fragment( $fragments ) {
		ob_start();
		get_template_part( 'woocommerce/minicart-ajax' ); 
		$fragments['.minicart-product-style1'] = ob_get_clean();
		return $fragments;
	}
}
else if($ya_header == 'style3'){
	add_filter('add_to_cart_fragments', 'ya_add_to_cart_fragment_style1', 101);
	function ya_add_to_cart_fragment_style1( $fragments ) {
		ob_start();
		get_template_part( 'woocommerce/minicart-ajax-style1' ); 
		$fragments['.minicart-product-style2'] = ob_get_clean();
		return $fragments;
	}
}
else{
	add_filter('add_to_cart_fragments', 'ya_add_to_cart_fragment_style2', 102);
	function ya_add_to_cart_fragment_style2( $fragments ) {
		ob_start();
		get_template_part( 'woocommerce/minicart-ajax-style2' ); 
		$fragments['.minicart-product-style3'] = ob_get_clean();
		return $fragments;
	}
}

/* change position */
remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
add_action('woocommerce_single_product_summary','woocommerce_template_single_price',20);
add_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',10);
/*remove woo breadcrumb*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );


/*add second thumbnail loop product*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'ya_woocommerce_template_loop_product_thumbnail', 10 );
function ya_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	
	global $product;
	$html = '';
	$id = get_the_ID();
	$gallery = get_post_meta($id, '_product_image_gallery', true);
	$attachment_image = '';
	if(!empty($gallery)) {
		$gallery = explode(',', $gallery);
		$first_image_id = $gallery[0];
		$attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image back'));
	}
	
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), '' );
	if ( has_post_thumbnail( $product->id ) ){
		if( $attachment_image ){
			$html .= '<a href="'.get_permalink( $product->id ).'">';
			$html .= '<div class="product-thumb-hover">';
			$html .= (get_the_post_thumbnail( $product->id, $size )) ? get_the_post_thumbnail( $product->id, $size ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="No thumb">';
			$html .= $attachment_image;
			$html .= '</div>';
			$html .= '</a>';
		}else{
			$html .= '<a href="'.get_permalink( $product->id ).'">';
			$html .= (get_the_post_thumbnail( $product->id, $size )) ? get_the_post_thumbnail( $product->id, $size ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="No thumb">';
			$html .= '</a>';
		}			
	}else{
		$html .= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="No thumb">';			
	}		
	return $html;
}
function ya_woocommerce_template_loop_product_thumbnail(){
	echo ya_product_thumbnail();
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/*filter order*/
function ya_addURLParameter($url, $paramName, $paramValue) {
	$url_data = parse_url($url);
	if(!isset($url_data["query"]))
		$url_data["query"]="";

	$params = array();
	parse_str($url_data['query'], $params);
	$params[$paramName] = $paramValue;
	$url_data['query'] = http_build_query($params);
	return ya_build_url($url_data);
}


function ya_build_url($url_data) {
	$url="";
	if(isset($url_data['host']))
	{
		$url .= $url_data['scheme'] . '://';
		if (isset($url_data['user'])) {
			$url .= $url_data['user'];
			if (isset($url_data['pass'])) {
				$url .= ':' . $url_data['pass'];
			}
			$url .= '@';
		}
		$url .= $url_data['host'];
		if (isset($url_data['port'])) {
			$url .= ':' . $url_data['port'];
		}
	}
	if (isset($url_data['path'])) {
		$url .= $url_data['path'];
	}
	if (isset($url_data['query'])) {
		$url .= '?' . $url_data['query'];
	}
	if (isset($url_data['fragment'])) {
		$url .= '#' . $url_data['fragment'];
	}
	return $url;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action('woocommerce_before_shop_loop', 'ya_woocommerce_catalog_ordering', 30);
add_action('woocommerce_before_shop_loop', 'ya_woocommerce_pagination', 35);
add_action('woocommerce_after_shop_loop', 'ya_woocommerce_catalog_ordering', 8);
add_action('woocommerce_before_shop_loop','ya_woommerce_view_mode_wrap',15);
add_action( 'woocommerce_after_shop_loop', 'ya_woommerce_view_mode_wrap', 5 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
add_action('woocommerce_message','wc_print_notices', 10);

function ya_woommerce_view_mode_wrap () {
	$html  = '';
	$html .= '<ul class="view-mode-wrap">
	<li class="view-grid sel">
		<a></a>
	</li>
	<li class="view-list">
		<a></a>
	</li>
</ul>';
echo $html;
}
/* Change ya_woocommerce_pagination() from v2.1.0 */
function ya_woocommerce_pagination() {
	global $wp_query;
	$term 		= get_queried_object();
	$parent_id 	= empty( $term->term_id ) ? 0 : $term->term_id;
	$product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
		'parent'       => $parent_id,
		'menu_order'   => 'ASC',
		'hide_empty'   => 0,
		'hierarchical' => 1,
		'taxonomy'     => 'product_cat',
		'pad_counts'   => 1
		) ) );
	if ( $product_categories ) {
		if ( is_product_category() ) {
			$display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

			switch ( $display_type ) {
				case 'subcategories' :
				$wp_query->post_count    = 0;
				$wp_query->max_num_pages = 0;
				break;
				case '' :
				if ( get_option( 'woocommerce_category_archive_display' ) == 'subcategories' ) {
					$wp_query->post_count    = 0;
					$wp_query->max_num_pages = 0;
				}
				break;
			}
		}

		if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == 'subcategories' ) {
			$wp_query->post_count    = 0;
			$wp_query->max_num_pages = 0;
		}
	}
	wc_get_template( 'loop/pagination.php' );
}
/* Change from v2.1.0 */
function ya_woocommerce_catalog_ordering() {
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);

	$query_string = '?'.$_SERVER['QUERY_STRING'];

	$option_number =  ya_options()->getCpanelValue( 'product_number' );
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 16;
	}

	$pob = !empty( $params['orderby'] ) ? $params['orderby'] : get_option( 'woocommerce_default_catalog_orderby' );
	$po  = !empty($params['product_order'])  ? $params['product_order'] : 'asc';
	$pc  = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$html = '';
	$html .= '<div class="catalog-ordering clearfix">';

	$html .= '<div class="orderby-order-container">';

	$html .= '<ul class="orderby order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><span class="current-li-content"><a>'.__('Sort by', 'maxshop').'</a></span></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pob == 'menu_order') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'menu_order').'">'.__('Sort by Default', 'maxshop').'</a></li>';
	$html .= '<li class="'.(($pob == 'popularity') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'popularity').'">'.__('Sort by Popularity', 'maxshop').'</a></li>';
	$html .= '<li class="'.(($pob == 'rating') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'rating').'">'.__('Sort by Rating', 'maxshop').'</a></li>';
	$html .= '<li class="'.(($pob == 'date') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'date').'">'.__('Sort by Date', 'maxshop').'</a></li>';
	$html .= '<li class="'.(($pob == 'price') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'price').'">'.__('Sort by Price', 'maxshop').'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	$html .= '<ul class="order">';
	if($po == 'desc'):
		$html .= '<li class="desc"><a href="'.ya_addURLParameter($query_string, 'product_order', 'asc').'"><i class="icon-arrow-up"></i></a></li>';
	endif;
	if($po == 'asc'):
		$html .= '<li class="asc"><a href="'.ya_addURLParameter($query_string, 'product_order', 'desc').'"><i class="icon-arrow-down"></i></a></li>';
	endif;
	$html .= '</ul>';
	$html .= '<ul class="sort-count order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'.__('8', 'maxshop').'</a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pc == $per_page) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page).'">'.$per_page.'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*2) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page*2).'">'.($per_page*2).'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*3) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page*3).'">'.($per_page*3).'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	$html .= '</div>';
	$html .= '</div>';
	
	echo $html;
}


add_action('woocommerce_get_catalog_ordering_args', 'ya_woocommerce_get_catalog_ordering_args', 20);
function ya_woocommerce_get_catalog_ordering_args($args)
{
	parse_str($_SERVER['QUERY_STRING'], $params);
	$po = !empty($params['product_order'])  ? $params['product_order'] : 'asc';

	switch($po) {
		case 'desc':
		$order = 'desc';
		break;
		case 'asc':
		$order = 'asc';
		break;
		default:
		$order = 'asc';
		break;
	}
	$args['order'] = $order;
	return $args;
}

add_filter('loop_shop_per_page', 'ya_loop_shop_per_page');
function ya_loop_shop_per_page()
{
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);

	$option_number =  ya_options()->getCpanelValue( 'product_number' );
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 16;
	}

	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	return $pc;
}
/*********QUICK VIEW PRODUCT**********/

add_action("wp_ajax_ya_quickviewproduct", "ya_quickviewproduct");
add_action("wp_ajax_nopriv_ya_quickviewproduct", "ya_quickviewproduct");
function ya_quickviewproduct(){
	
	$productid = (isset($_REQUEST["post_id"]) && $_REQUEST["post_id"]>0) ? $_REQUEST["post_id"] : 0;
	
	$query_args = array(
		'post_type'	=> 'product',
		'p'			=> $productid
		);
	$outputraw = $output = '';
	$r = new WP_Query($query_args);
	if($r->have_posts()){ 

		while ($r->have_posts()){ $r->the_post(); setup_postdata($r->post);
			global $product;
			ob_start();
			woocommerce_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}
	$output = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw);
	echo $output;exit();
}
/*
	Related Product function
*/
	function Ya_related_product( $number, $title ){
		ob_start();
		include( get_template_directory(). '/widgets/ya_relate_product/slide.php' );
		$content = ob_get_clean();
		echo $content;
	}

	/* Product loop content */
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open',10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

	/*YITH wishlist*/
	if ( class_exists( 'YITH_Woocompare' ) || class_exists( 'YITH_WCWL' ) ){
		add_action( 'woocommerce_after_single_variation', 'ya_add_wishlist_variation', 10 );
		add_action( 'woocommerce_single_product_summary', 'ya_before_addcart', 28);
	//add_action( 'woocommerce_after_add_to_cart_button', 'ya_after_addcart', 38);
		add_action('woocommerce_after_shop_loop_item','ya_add_loop_compare_link', 20);
		add_action( 'woocommerce_after_shop_loop_item', 'ya_add_loop_wishlist_link', 25 );
		add_action( 'woocommerce_after_add_to_cart_button', 'ya_add_wishlist_link', 10);
		function ya_before_addcart(){
			echo '<div class="product-summary-bottom clearfix">';
		}
		function ya_after_addcart(){
			echo '</div>';
		}
		function ya_add_loop_compare_link(){
			global $product;
			$product_id = $product->id;
			if( class_exists( 'YITH_Woocompare' ) ){
				echo '<div class="woocommerce product compare-button"><a href="javascript:void(0)" class="compare button" data-product_id="'. $product_id .'" rel="nofollow">'. esc_html__( 'Compare', 'maxshop' ) .'</a></div>';		
			}
		}
		function ya_add_loop_wishlist_link(){
			if ( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ){
				echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
			}
		}
		function ya_add_wishlist_link(){
			global $product;
			$product_id = $product->id;
			if ( class_exists( 'YITH_Woocompare' ) && class_exists( 'YITH_WCWL' ) ){				
				if( $product->product_type != 'variable' ){					
					echo '<div class="woocommerce product compare-button"><a href="javascript:void(0)" class="compare button" data-product_id="'. $product_id .'" rel="nofollow">'. esc_html__( 'Compare', 'maxshop' ) .'</a></div>';		
					echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
					
				}else{
					return ;
				}
			}
		}
		function ya_add_wishlist_variation(){	
			global $product;
			$product_id = $product->id;
			if ( class_exists( 'YITH_Woocompare' ) && class_exists( 'YITH_WCWL' ) ){
				echo '<div class="woocommerce product compare-button"><a href="javascript:void(0)" class="compare button" data-product_id="'. $product_id .'" rel="nofollow">'. esc_html__( 'Compare', 'maxshop' ) .'</a></div>';		
				echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
			}
		}
	}
	add_filter( 'product_cat_class', 'ya_product_category_class', 2 );
	function ya_product_category_class( $classes, $category = null ){
		$ya_product_sidebar = ya_options()->getCpanelValue('sidebar_product');
		if( $ya_product_sidebar == 'left' || $ya_product_sidebar == 'right' ){
			$classes[] = 'col-lg-4 col-md-4 col-sm-6 col-xs-6 col-mb-12';
		}else if( $ya_product_sidebar == 'lr' ){
			$classes[] = 'col-lg-6 col-md-6 col-sm-6 col-xs-6 col-mb-12';
		}else if( $ya_product_sidebar == 'full' ){
			$classes[] = 'col-lg-3 col-md-4 col-sm-6 col-xs-6 col-mb-12';
		}
		return $classes;
	}

	function ya_cpwl_init(){
		if( class_exists( 'YITH_Woocompare' ) ){
			update_option( 'yith_woocompare_compare_button_in_product_page', 'no' );
			update_option( 'yith_woocompare_compare_button_in_products_list', 'no' );
		}
		if( class_exists( 'YITH_WCWL' ) ){
			update_option( 'yith_wcwl_button_position', 'shortcode' );
		}
	}
	add_action('admin_init','ya_cpwl_init');
	?>