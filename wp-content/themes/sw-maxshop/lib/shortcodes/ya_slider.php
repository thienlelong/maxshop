<?php
	/**
		** Shortcode slideshow
		** Author: Smartaddons
		**/


		class Ya_Slider_Shortcodes{
			public $id = 1;
			private $addScript = false;
			private $CountdownJs = false;
			protected $tags = array( 'ya_woocommerce_slider', 'ya_post_slider', 'category_slider', 'uspell_product_slider', 'related_product_slider', 'ya_countdown_slider','our_brand_slider' );
			function __construct(){
				$this -> add_shortcodes();
				add_action('wp_enqueue_scripts', array( $this, 'load_slider_script' ), 10);
			}
			/* Start Add Shortcode */
			public function add_shortcodes(){
				if ( is_array($this->tags) && count($this->tags) ){
					foreach ( $this->tags as $tag ){
						add_shortcode($tag, array($this, $tag));
					}
				}
			}
			/* Add Script */
			public function load_slider_script(){
				if( $this -> addScript == true ){
					wp_register_script( 'slick_slider_js', plugins_url( 'js/slick.min.js', __FILE__ ),array(), null, true );		
					if (!wp_script_is('slick_slider_js')) {
						wp_enqueue_script('slick_slider_js');
					}    
				}
				if( $this -> CountdownJs == true ){
					wp_register_script( 'woo_countdown_js', plugins_url( '/js/jquery.countdown.min.js', __FILE__ ),array(), null, true );	
					wp_enqueue_script( 'woo_countdown_js' );
				}
			}	
			/* Shortcode Woocommerce Slider */
			public function ya_woocommerce_slider( $atts, $content ){
				extract( shortcode_atts(
					array(
						'title' => '',
						'style_title' =>'style1',
						'image' => '',
						'category_id' => '',
						'orderby' => '',
						'order'	=> '',
						'numberposts' => 5,
						'item_row' => 1,
						'col_lg' => 4,
						'col_md' => 4,
						'col_sm' => 3,
						'col_xs' => 2,
						'col_moble' => 1,
						'speed' => 1000,
						'autoplay' => 'false',
						'interval' => 5000,
						'number_slided' => 1,
						'el_class'=>'',
						'layout' => 'default'
						), $atts )
				);		
				$ya_quickview = ya_options()->getCpanelValue( 'quickview_enable' );
				$this -> addScript = true;
				global $yith_wcwl,$product;		 	
				$ya_direction = ya_options()->getCpanelValue( 'direction' ); 
				$rtl = ( is_rtl() || ( isset( $ya_direction ) && $ya_direction == 'rtl' )  ) ? 'true' : 'false';
				$data = 'data-lg="'. esc_attr( $col_lg ) .'" data-md="'. esc_attr( $col_md ) .'" data-sm="'. esc_attr( $col_sm ) .'" data-xs="'. esc_attr( $col_xs ) .'" data-mobile="'. esc_attr( $col_moble ) .'" data-speed="'. esc_attr( $speed ) .'" data-scroll="'. esc_attr( $number_slided ) .'" data-interval="'. esc_attr( $interval ) .'" data-autoplay="'. esc_attr( $autoplay ) .'" data-rtl="'.$rtl.'"';
				if( $category_id != '' ){
					$default = array(
						'post_type' => 'product',
						'tax_query'	=> array(
							array(
								'taxonomy'	=> 'product_cat',
								'field'		=> 'term_id',
								'terms'		=> $category_id)),

						'orderby'		=> $orderby,
						'order'			=> $order,
						'post_status' 	=> 'publish',
						'showposts' 	=> $numberposts
						);
				}else{
					$default = array(
						'post_type' => 'product',
						'orderby' => $orderby,
						'order' => $order,
						'post_status' => 'publish',
						'showposts' => $numberposts
						);
				}
				$this -> id = $this -> id + 1;
				$id = $this -> id;
				$slider_id = 'responsive_slider_'.$id;
				$list = new WP_Query( $default );
				$terms = get_term_by('id', $category_id, 'product_cat');
				if( $terms == NULL ){
					return '<div class="alert alert-warning alert-dismissible" role="alert">
					<a class="close" data-dismiss="alert">&times;</a>
					<p>'. esc_html__( 'Please select a category for SW Woocommerce Slider. Layout ', 'maxshop' ) . $layout .'</p>
				</div>';
			}
			$html = '';
			$html .= '<div id="'. $slider_id .'" class="sw-woo-container-slider responsive-slider woo-slider-'.$layout.' '.$el_class.' loading" '.$data.'>';
			/*************** Layout default ******************************/
			if( $layout == 'default' && $title !='' ){
				$html .= '<div class="block-title  '.$style_title.'">
				<span class="page-title-slider">'.$title .'</span>
			</div> ';
			$html.='<div class="supercat-des">
			<a class="img-class" href="'. get_term_link( $terms->term_id ) .'" title="'.esc_attr( $terms->name ).'">'.wp_get_attachment_image( $image, 'full' ).'</a>		
		</div>';
	}
		////////////////////// end  layout default //////////////////////////////////////////////////////
		/////////////////  Layout child cate ////////////////////////////////////////////////////////
	if($layout == 'child-cate' && $terms != null) {
		$args = array('child_of' => $category_id, 'parent' => $category_id);
		$termchildren = get_terms( 'product_cat', $args);
		$html.= '<div class="block-title  '.$style_title.'">';
		$html.=	'<h2>';
		$html.= '<span><a title="'.esc_attr( $terms->name ).'" href="' . get_term_link( $terms,'product_cat' ) . '">'.esc_html( $terms->name ).'</a></span>';
		$html.='</h2>';
		if( $termchildren != NULL || count( $termchildren ) > 0 ){
			$html.=	'<div class="category-wrap-cat">
			<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#<?php echo esc_attr($nav_id); ?>"  aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="fa fa-bar"></span>
				<span class="fa fa-bar"></span>
				<span class="fa fa-bar"></span>
			</button>			
			<ul class="cat-list">';
				foreach ( $termchildren as $child ) {											
					$html.='<li class="item">
					<a href="' . get_term_link( $child,'product_cat' ) . '">' . esc_html( $child->name ) . '</a>
				</li>';
			}
			$html.='</ul>					
		</div>';
	}
	$html .= '</div>';
	$html.='<div class="supercat-des">
	<a class="img-class" href="'. get_term_link( $terms->term_id ) .'" title="'.esc_attr( $terms->name ).'">'.wp_get_attachment_image( $image, 'full' ).'</a>		
</div>';
}
if( $layout =='child-cate-left') {
	$html.='<div class="resp-slider-container clearfix">';
	$html.= '<div class="block-title  '.$style_title.'">';
	$html.=	'<h2>';
	$html.= '<span><a title="'.esc_attr( $terms->name ).'" href="' . get_term_link( $terms,'product_cat' ) . '">'.esc_html( $terms->name ).'</a></span>';
	$html.='</h2>';
	$html.='</div>';
	$term_id = $terms->term_id;
	$termchildren = get_terms( 'product_cat', array( 'child_of' => $term_id, 'depth' => 1, 'number' => 4 ) );
	$html .= '<div class="resp-slider-wrapper clearfix">';
	$html .='<div class="left-child">';
	$html.=	'<a class="img-class" href="#" title="'.esc_attr( $terms->name ).'">'.wp_get_attachment_image( $image, 'full' ).'</a>';
	if( count($termchildren) > 0 || $termchildren != NULL ){ 
		$html.='<div class="product-childcat">
		<ul class="cat-list">';
			foreach ( $termchildren as $child ) {

				$html .='<li class="item"><a href="' . get_term_link( intval( $child->term_id ), 'product_cat' ) . '">' . esc_html( $child->name ). '</a></li>';
			}
			$html .='<li class="item"><a class="category-show-more" href="'.get_term_link($term_id, 'product_cat').'">'.__('View more...','maxshop').'</a></li>';
			$html.='</ul>';
			$html.='</div>';
		}			
		$html .= '</div>';
		$html.= '<div class="responsive-childcat-right">';

	}else {
		$html .= '<div class="resp-slider-container">';	
	}		
	$html .='
	<div class="slider responsive">';
		$i = 0;
		while($list->have_posts()): $list->the_post();
		$count_items 	= 0;
		$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
		$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
		global $product, $post, $wpdb, $average;

		if( $i % $item_row == 0 ){
			$html .='<div class="item">';
		}

		$html .='<div class="item-wrap">
		<div class="item-detail">';
			$html .= '<div class="item-img products-thumb">';
			ob_start();
			do_action( 'woocommerce_before_shop_loop_item_title' ); 
			$below_shortcode = ob_get_contents();
			ob_end_clean();
			$html.= $below_shortcode;
									//$html .= ya_product_thumbnail();
			$html .= '</div>
			<div class="item-content">';
				$html.='<div class="reviews-content">';
				$average      = $product->get_average_rating();
				if( $average > 0 ){


					$html.='<div class="star"><span style="width:'.($average*14).'px'.'"></span></div>';

				} else { 

					$html.='<div class="star"></div>';

				}

				$html.=	'</div>';
				$html .= '<h4><a href="' .get_permalink( $post->ID ) .'" title="'. esc_attr( $post->post_title ) .'">'. get_the_title( $post->ID ) .'</a></h4>';											
				if ( $price_html = $product->get_price_html() ){
					$html .= '<div class="item-price">
					<span>'.$price_html	.'</span>
				</div>';
			}
			$html .='<div class="item-bottom-grid clearfix">';
			$html .= apply_filters( 'woocommerce_loop_add_to_cart_link',
				sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="button %s add_to_cart_button ajax_add_to_cart">%s</a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					esc_attr( $product->id ),
					esc_attr( $product->get_sku() ),
					esc_attr( isset( $class ) ? $class : 'button' ),
					esc_html( $product->add_to_cart_text() )
					),
				$product );
			if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) || is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ) {
				if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) ){
					$yith_compare = new YITH_Woocompare_Frontend();
					$html .='<div class="woocommerce product compare-button">';
					$html .='<a href=" '.esc_url($yith_compare->add_product_url( $product->id )).'" class="compare button" title="Add to Compare" data-product_id="'.esc_attr($product->id).'">'. esc_html('compare').'</a>';
					$html .='</div>';

				}
				if ( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ){
					$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
				}
			}
			if( $ya_quickview ) :
				$nonce = wp_create_nonce("ya_quickviewproduct_nonce");
			$link = admin_url('admin-ajax.php?ajax=true&amp;action=ya_quickviewproduct&amp;post_id='.$product->id.'&amp;nonce='.$nonce);
			$linkcontent ='<a href="'. esc_url( $link ) .'" data-fancybox-type="ajax" class="fancybox fancybox.ajax sm_quickview_handler" title="Quick View Product">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', 'maxshop' ) ).'</a>';
			$html .= $linkcontent;
			endif;

			$html .='</div>';
			$html .='										
		</div>
	</div>
</div>';
if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){ $html .='</div>'; } 
$i++; endwhile; wp_reset_postdata();
$html .='</div>            
</div>';
if( $layout =='child-cate-left') {
	$html.='</div></div>';	
}
$html .='</div>';
return $html;
}
/* Shortcode Upsell Product */
public function uspell_product_slider( $atts, $content ){
	extract( shortcode_atts(
		array(
			'title' => '',
			'image' => '',
			'orderby' => '',
			'numberposts' => 5,
			'col_lg' => 4,
			'col_md' => 4,
			'col_sm' => 3,
			'col_xs' => 2,
			'col_moble' => 1,
			'speed' => 1000,
			'autoplay' => 'false',
			'interval' => 5000,
			'number_slided' => 1
			), $atts )
	);
	$this -> addScript = true;
	$ya_direction = ya_options()->getCpanelValue( 'direction' ); 
	$rtl = ( is_rtl() || ( isset( $ya_direction ) && $ya_direction == 'rtl' )  ) ? 'true' : 'false';
	$data = 'data-lg="'. esc_attr( $col_lg ) .'" data-md="'. esc_attr( $col_md ) .'" data-sm="'. esc_attr( $col_sm ) .'" data-xs="'. esc_attr( $col_xs ) .'" data-mobile="'. esc_attr( $col_moble ) .'" data-speed="'. esc_attr( $speed ) .'" data-scroll="'. esc_attr( $number_slided ) .'" data-interval="'. esc_attr( $interval ) .'" data-autoplay="'. esc_attr( $autoplay ) .'" data-rtl="'.$rtl.'"';
	global $product, $woocommerce, $woocommerce_loop;
	$upsells = $product->get_upsells();
	if( count($upsells) == 0 || is_archive() ) return ;	
	$meta_query = WC()->query->get_meta_query();
	$args = array(
		'post_type'           => 'product',
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => 1,
		'posts_per_page'      => $numberposts,
		'orderby'             => $orderby,
		'post__in'            => $upsells,
		'post__not_in'        => array( $product->id ),
		'meta_query'          => $meta_query
		);
	$this -> id = $this -> id + 1;
	$id = $this -> id;
	$slider_id = 'upsel_slider_'.$id;
	$list = new WP_Query( $default );
	$html = '';
	$html .= '<div id="'. $slider_id .'" class="sw-woo-container-slider responsive-slider woo-slider-default loading" '.$data.'>';
	if( $title != '' ){
		$html .= '<div class="block-title">
		<span class="page-title-slider">'.$title .'</span>
	</div> ';
}
$html .='
<div class="resp-slider-container">
	<div class="slider responsive">';
		while($list->have_posts()): $list->the_post();global $product, $post, $wpdb, $average;
		$html .='
		<div class="item">
			<div class="item-wrap">
				<div class="item-detail">';
					$html .= '<div class="item-img products-thumb">';
					$html .= ya_product_thumbnail();									
					$html .= '</div>
					<div class="item-content">';
						$html .= '<h4><a href="' .get_permalink( $post->ID ) .'" title="'. esc_attr( $post->post_title ) .'">'. get_the_title( $post->ID ) .'</a></h4>';											
						if ( $price_html = $product->get_price_html() ){
							$html .= '<div class="item-price">
							<span>'.$price_html	.'</span>
						</div>';
					}
					$html .='										
				</div>
			</div>
		</div>
	</div>';	
	endwhile; wp_reset_postdata();
	$html .='</div>            
</div> 
</div>';
return $html;
}
/* Shortcode Related Product */
public function related_product_slider( $atts, $content ){
	extract( shortcode_atts(
		array(
			'title' => '',
			'image' => '',
			'orderby' => '',
			'numberposts' => 5,
			'col_lg' => 4,
			'col_md' => 4,
			'col_sm' => 3,
			'col_xs' => 2,
			'col_moble' => 1,
			'speed' => 1000,
			'autoplay' => 'false',
			'interval' => 5000,
			'number_slided' => 1
			), $atts )
	);

	$this -> addScript = true;
	$ya_direction = ya_options()->getCpanelValue( 'direction' ); 
	$rtl = ( is_rtl() || ( isset( $ya_direction ) && $ya_direction == 'rtl' )  ) ? 'true' : 'false';
	$data = 'data-lg="'. esc_attr( $col_lg ) .'" data-md="'. esc_attr( $col_md ) .'" data-sm="'. esc_attr( $col_sm ) .'" data-xs="'. esc_attr( $col_xs ) .'" data-mobile="'. esc_attr( $col_moble ) .'" data-speed="'. esc_attr( $speed ) .'" data-scroll="'. esc_attr( $number_slided ) .'" data-interval="'. esc_attr( $interval ) .'" data-autoplay="'. esc_attr( $autoplay ) .'" data-rtl="'.$rtl.'"';
	global $product;
	$related = $product->get_related( $numberposts );
	if ( sizeof( $related ) == 0 ) return;
	$args = apply_filters( 'woocommerce_related_products_args', array(
		'post_type'            => 'product',
		'ignore_sticky_posts'  => 1,
		'no_found_rows'        => 1,
		'posts_per_page'       => $numberposts,
		'post__in'             => $related,
		'post__not_in'         => array( $product->id )
		) );
	$this -> id = $this -> id + 1;
	$id = $this -> id;
	$slider_id = 'related_slider_'.$id;
	$list = new WP_Query( $args );
	$html = '';
	$html .= '<div id="'. $slider_id .'" class="sw-woo-container-slider responsive-slider woo-slider-default loading" '.$data.'>';
	if( $title != '' ){
		$html .= '<div class="block-title">
		<span class="page-title-slider">'.$title .'</span>
	</div> ';
}
$html .='
<div class="resp-slider-container">
	<div class="slider responsive">';
		while($list->have_posts()): $list->the_post();global $product, $post, $wpdb, $average;
		$html .='
		<div class="item">
			<div class="item-wrap">
				<div class="item-detail">';
					$html .= '<div class="item-img products-thumb">';
					$html .= ya_product_thumbnail();									
					$html .= '</div>
					<div class="item-content">';
						$html .= '<h4><a href="' .get_permalink( $post->ID ) .'" title="'. esc_attr( $post->post_title ) .'">'. get_the_title( $post->ID ) .'</a></h4>';											
						if ( $price_html = $product->get_price_html() ){
							$html .= '<div class="item-price">
							<span>'.$price_html	.'</span>
						</div>';
					}
					$html .='										
				</div>
			</div>
		</div>
	</div>';	
	endwhile; wp_reset_postdata();
	$html .='</div>            
</div> 
</div>';
return $html;
}
/* Shortcode Responsive Post */
public function ya_post_slider( $attr, $content ){
	extract( shortcode_atts(
		array(
			'title' => '',
			'category_id' => '',
			'orderby' => '',
			'order'	=> '',
			'numberposts' => 5,
			'col_lg' => 4,
			'col_md' => 4,
			'col_sm' => 3,
			'col_xs' => 2,
			'col_moble' => 1,
			'speed' => 1000,
			'length' => 25,
			'autoplay' => 'false',
			'interval' => 5000,
			'number_slided' => 1,
			'layout' => 'default'
			), $attr )
	);
	$this -> addScript = true;
	$ya_direction = ya_options()->getCpanelValue( 'direction' ); 
	$rtl = ( is_rtl() || ( isset( $ya_direction ) && $ya_direction == 'rtl' ) ) ? 'true' : 'false';
	$data = 'data-lg="'. esc_attr( $col_lg ) .'" data-md="'. esc_attr( $col_md ) .'" data-sm="'. esc_attr( $col_sm ) .'" data-xs="'. esc_attr( $col_xs ) .'" data-mobile="'. esc_attr( $col_moble ) .'" data-speed="'. esc_attr( $speed ) .'" data-scroll="'. esc_attr( $number_slided ) .'" data-interval="'. esc_attr( $interval ) .'" data-autoplay="'. esc_attr( $autoplay ) .'" data-rtl="'.$rtl.'"';
	if( $category_id != '' ){
		$default = array(
			'category' => $category_id,
			'orderby'		=> $orderby,
			'order'			=> $order,
			'post_status' 	=> 'publish',
			'showposts' 	=> $numberposts
			);
	}else{
		$default = array(
			'orderby' => $orderby,
			'order' => $order,
			'post_status' => 'publish',
			'showposts' => $numberposts
			);
	}
	$this -> id = $this -> id + 1;
	$id = $this -> id;
	$slider_id = 'responsive_post_slider_'.$id;
	$list = get_posts( $default );
	$html = '';
	if( count($list) > 0 ){
		$html .= '<div id="'. $slider_id .'" class="sw-post-container-slider responsive-slider loading" '.$data.'>';
		if( $title != '' ){
			$html .= '<div class="block-title">
			<span class="page-title-slider">'.$title .'</span>
		</div> ';
	}
	$html .='
	<div class="resp-slider-container">
		<div class="slider responsive">';
			foreach( $list as $post ){
				$html .='
				<div class="item">
					<div class="item-wrap">';
						$html .= '<div class="item-img">';
						$html ='<a href="' .get_permalink( $post->ID ) .'" title="'. esc_attr( $post->post_title ) .'">'.get_the_post_thumbnail( $post->ID ). '</a>';									
						$html .= '</div>
						<div class="item-content">';
							$html .= '<h4><a href="' .get_permalink( $post->ID ) .'" title="'. esc_attr( $post->post_title ) .'">'. get_the_title( $post->ID ) .'</a></h4>';											
							$html .= '<div class="item-description">';
							if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
								$content = explode($matches[0], $post->post_content, 2);
								$content = $content[0];
							} else {
								$content = wp_trim_words($post->post_content, $length, ' ');
							}
							$html .= $content;
							$html .= '</div>';
							$html .='										
						</div>
					</div>
				</div>';	
			}
			$html .='</div>            
		</div> 
	</div>';
}
return $html;
}
/* Shortcode Woocommerce Countdown Slider */
public function ya_countdown_slider( $atts, $content ){
	extract( shortcode_atts(
		array(
			'title' => '',
			'style_title' =>'style1',
			'icon'	=> '',
			'category_id' => '',
			'orderby' => '',
			'order'	=> '',
			'numberposts' => 5,
			'col_lg' => 4,
			'col_md' => 4,
			'col_sm' => 3,
			'col_xs' => 2,
			'col_moble' => 1,
			'speed' => 1000,
			'autoplay' => 'false',
			'interval' => 5000,
			'number_slided' => 1,
			'layout' => 'default'
			), $atts )
	);	
	$ya_quickview = ya_options()->getCpanelValue( 'quickview_enable' );
	$this -> addScript 		= true;
	$this -> CountdownJs 	= true;
	global $yith_wcwl,$product;
	$ya_direction = ya_options()->getCpanelValue( 'direction' ); 
	$rtl = ( is_rtl() || ( isset( $ya_direction ) && $ya_direction == 'rtl' )  ) ? 'true' : 'false';
	$data = 'data-lg="'. esc_attr( $col_lg ) .'" data-md="'. esc_attr( $col_md ) .'" data-sm="'. esc_attr( $col_sm ) .'" data-xs="'. esc_attr( $col_xs ) .'" data-mobile="'. esc_attr( $col_moble ) .'" data-speed="'. esc_attr( $speed ) .'" data-scroll="'. esc_attr( $number_slided ) .'" data-interval="'. esc_attr( $interval ) .'" data-autoplay="'. esc_attr( $autoplay ) .'" data-rtl="'.$rtl.'"';
	$default = array(
		'post_type' => 'product',
		'meta_query' => array(
			array(
				'key' => '_visibility',
				'value' => array('catalog', 'visible'),
				'compare' => 'IN'
				),
			array(
				'key' => '_sale_price',
				'value' => 0,
				'compare' => '>',
				'type' => 'NUMERIC'
				),
			array(
				'key' => '_sale_price_dates_from',
				'value' => 0,
				'compare' => '>',
				'type' => 'NUMERIC'
				),
			array(
				'key' => '_sale_price_dates_to',
				'value' => 0,
				'compare' => '>',
				'type' => 'NUMERIC'
				)
			),
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
		);
	if( $category_id != '' ){
		$default['tax_query'] = array(
			array(
				'taxonomy'  => 'product_cat',
				'field'     => 'term_id',
				'terms'     => $category_id ));
	}
	$this -> id = $this -> id + 1;
	$id 		= $this -> id;
	$slider_id 	= 'responsive_countdown_slider_'.$id;
	$list 		= new WP_Query( $default );
	$html 		= '';
	$html .= '<div id="'. $slider_id .'" class=" responsive-slider countdown-slider loading" '.$data.'>';
	if( $title != '' ){
		$html .= '<div class="block-title '.$style_title.'">';
		$titles = strpos($title, ' ');
		$title = ($titles !== false && $style_title== 'title3') ? '<span>' . substr($title, 0, $titles) . '</span>' .' <span class="text-color">'. substr($title, $titles + 1).'</span>': '<span>'.$title.'</span>';
		$title = ($style_title=='title4') ? '<span><i class="'.$icon.'"></i>'.$title.'</span>':'<span>'.$title.'</span>';
		$html .= '<h2>'. $title .'</h2>';
	}
	$html .='</div>';
	$html .='
	<div class="row">
		<div class="resp-slider-container">
			<div class="slider responsive">';
				while($list->have_posts()): $list->the_post();
				global $product, $post, $wpdb, $average;
				$start_time 	= get_post_meta( $post->ID, '_sale_price_dates_from', true );
				$countdown_time = get_post_meta( $post->ID, '_sale_price_dates_to', true );	
				$orginal_price 	= get_post_meta( $post->ID, '_regular_price', true );	
				$sale_price 	= get_post_meta( $post->ID, '_sale_price', true );	
				$symboy 		= get_woocommerce_currency_symbol( get_woocommerce_currency() );
				$html .='
				<div class="item item-countdown" id="product_'.$id.$post->ID .'">
					<div class="item-wrap">
						<div class="item-detail">';
							$html .= '<div class="item-img products-thumb">';
							ob_start();
							do_action( 'woocommerce_before_shop_loop_item_title' ); 
							$below_shortcode = ob_get_contents();
							ob_end_clean();
							$html.= $below_shortcode;
									//$html .= ya_product_thumbnail();		
							$html .= '</div>';
							if( $countdown_time >= time() ){
								$html .= '<div class="product-countdown"  data-price="'.esc_attr( $symboy.$orginal_price ).'" data-starttime="'. esc_attr( $start_time ) .'" data-cdtime="'. esc_attr( $countdown_time ) .'" data-id="product_'.$id.$post->ID .'"></div>';
							}
							$html .='<div class="item-content">';

							$html.='<div class="reviews-content">';
							$average      = $product->get_average_rating();
							if( $average > 0 ){


								$html.='<div class="star"><span style="width:'.($average*14).'px'.'"></span></div>';

							} else { 

								$html.='<div class="star"></div>';

							}

							$html.=	'</div>';
							$html .= '<h4><a href="' .get_permalink( $post->ID ) .'" title="'. esc_attr( $post->post_title ) .'">'. get_the_title( $post->ID ) .'</a></h4>';											
							if ( $price_html = $product->get_price_html() ){
								$html .= '<div class="item-price">
								<span>'.$price_html	.'</span>
							</div>';
						}
						$html .='<div class="item-bottom-grid clearfix">';
						$html .= apply_filters( 'woocommerce_loop_add_to_cart_link',
							sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="button %s add_to_cart_button ajax_add_to_cart">%s</a>',
								esc_url( $product->add_to_cart_url() ),
								esc_attr( isset( $quantity ) ? $quantity : 1 ),
								esc_attr( $product->id ),
								esc_attr( $product->get_sku() ),
								esc_attr( isset( $class ) ? $class : 'button' ),
								esc_html( $product->add_to_cart_text() )
								),
							$product );
						if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) || is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ) {
							if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) ){
								$yith_compare = new YITH_Woocompare_Frontend(); 	
								$html .='<div class="woocommerce product compare-button">';
								$html .='<a href=" '.esc_url($yith_compare->add_product_url( $product->id )).'" class="compare button" title="Add to Compare" data-product_id="'.esc_attr($product->id).'">'. esc_html('compare').'</a>';
								$html .='</div>';

							}
							if ( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ){
								$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
							}
						}
						if( $ya_quickview ) :
							$nonce = wp_create_nonce("ya_quickviewproduct_nonce");
						$link = admin_url('admin-ajax.php?ajax=true&amp;action=ya_quickviewproduct&amp;post_id='.$product->id.'&amp;nonce='.$nonce);
						$linkcontent ='<a href="'. esc_url( $link ) .'" data-fancybox-type="ajax" class="fancybox fancybox.ajax sm_quickview_handler" title="Quick View Product">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', 'maxshop' ) ).'</a>';
						$html .= $linkcontent;
						endif;

						$html .='</div>';
						$html .='										
					</div>
				</div>
			</div>
		</div>';	
		endwhile; wp_reset_postdata();
		$html .='</div>    
	</div>	
</div> 
</div>';
return $html;
}
/* Shortcode Our Brand Slider */
public function our_brand_slider( $attr, $content ){
	extract( shortcode_atts(
		array(
			'title' => '',
			'style_title'=>'',
			'numberposts' => 5,
			'orderby'=>'',
			'order' => '',
			'post_status' => 'publish',
			'col_lg'=>4,
			'col_md'=>4,
			'col_sm'=>3,
			'col_xs'=>2,
			'col_moble'=>1,
			'speed' => 1000,
			'autoplay' => 'false',
			'interval' => 5000,
			'number_slided' => 1,
			'layout' => 'default',
			'el_class' => ''

			), $attr )
	);
	$this -> addScript = true;
	$ya_direction = ya_options()->getCpanelValue( 'direction' ); 
	$rtl = ( is_rtl() || ( isset( $ya_direction ) && $ya_direction == 'rtl' ) ) ? 'true' : 'false';
	$data = 'data-lg="'. esc_attr( $col_lg ) .'" data-md="'. esc_attr( $col_md ) .'" data-sm="'. esc_attr( $col_sm ) .'" data-xs="'. esc_attr( $col_xs ) .'" data-mobile="'. esc_attr( $col_moble ) .'" data-speed="'. esc_attr( $speed ) .'" data-scroll="'. esc_attr( $number_slided ) .'" data-interval="'. esc_attr( $interval ) .'" data-autoplay="'. esc_attr( $autoplay ) .'" data-rtl="'.$rtl.'"';
	$default = array(
		'post_type' => 'partner',
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
		);
	$this -> id = $this -> id + 1;
	$id = $this -> id;
	$slider_id = 'responsive_post_slider_'.$id;
	$list = new WP_Query( $default );
	$html = '';
	if( count($list) > 0 ){
		$html .= '<div id="'. $slider_id .'" class="sw-partner-container-slider responsive-slider loading '.$el_class.'" '.$data.'>';
		if( $title != '' ){
			$html .= '<div class="block-title">
			<span class="page-title-slider">'.$title .'</span>
		</div> ';
	}
	$html .='
	<div class="resp-slider-container">
		<div class="slider responsive">';
			while($list->have_posts()): $list->the_post();
			global  $post;
			$link = get_post_meta( $post->ID, 'link', true );
			$target = get_post_meta( $post->ID, 'target', true );
			$html .='
			<div class="item">
				<div class="item-wrap">';
					if(has_post_thumbnail()){ 
						$html.='	<div class="item-img item-height">
						<div class="item-img-info">
							<a href="'.$link.'" title="'.esc_attr( $post->post_title ).'" target="'.$target.'">
								'.get_the_post_thumbnail($post->ID).'
							</a>
						</div>
					</div>';
				}else{ 
					$html.='      <div class="item-img item-height">
					<div class="item-img-info">
						<a href="'.$link.'" title="'.esc_attr( $post->post_title ).'" target="'.$target.'">
							<img src="'.get_template_directory_uri().'/assets/img/placeholder/thumbnail.png" alt="No thumb">
						</a>
					</div>
				</div>';
			}
			$html.='					</div>
		</div>';	
		endwhile; wp_reset_postdata();
		$html .='</div>            
	</div> 
</div>';
}
return $html;
}
}
new Ya_Slider_Shortcodes();