<?php 
/**
	* Layout Featured
	* @version     1.0.0
**/

$term_name = esc_html__( 'Featured Products', 'sw_woocommerce' );
$default = array(
	'post_type'				=> 'product',
	'post_status' 			=> 'publish',
	'ignore_sticky_posts'	=> 1,
	'posts_per_page' 		=> $numberposts,
	'orderby' 				=> $orderby,
	'order' 				=> $order,
	'meta_query'			=> array(
		array(
			'key' 		=> '_visibility',
			'value' 	=> array('catalog', 'visible'),
			'compare'	=> 'IN'
		),
		array(
			'key' 		=> '_featured',
			'value' 	=> 'yes'
		)
	)
);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	$term_name = $term->name;
	$default['tax_query']	= array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'		=> 'slug',
			'terms'		=> $category
		)
	);
}

$id = 'sw_featured_'.rand().time();
$list = new WP_Query( $default );
if ( $list -> have_posts() ){
?>
	<div id="<?php echo $id; ?>" class="sw-woo-container-slider  responsive-slider featured-product clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="order-title">
			<?php
				$titles = strpos($title1, ' ');
				$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
				echo '<h2><strong>'. $title .'</strong></h2>';
			?>
				
			<?php if( $image_icon != '' ) { ?>
				<div class="order-icon">
					<?php 
						$image_thumb = wp_get_attachment_image( $image_icon, 'thumbnail' );
						echo $image_thumb; 
					 ?>
				</div>
			<?php } ?>

			<?php echo ( $description != '' ) ? '<div class="order-desc">'. $description .'</div>' : ''; ?>
		</div>
		<div class="featured-resp-slider-container clearfix">			
			<div class="featured-responsive">			
			<?php 
				$content_array = $list->posts;
				$pf = new WC_Product_Factory();					
				self::addOtherItem( $content_array, array( 'empty' ), 2, $items );
				foreach ($items as $key => $item) {					
					global $product;
					$product = $pf->get_product( $item->ID );
					if( $key % 2 == 0 ){
						$class = '';
						$class = ( $items[$key] != 'empty' ) ? 'col-md-3 item-sidebar' : 'col-md-6 item-center';			
			?>
				<div class="item <?php echo esc_attr( $class ); ?>">
						<?php } ?>
						<?php 
							if ($items[$key] != 'empty') { 								
						?>	
							<?php if($class == 'col-md-6 item-center') { ?>
								<div class="item-wrap">
									<div class="item-detail">										
										<div class="item-img products-thumb">			
											<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
										</div>										
										<div class="item-content">
											<h4>
												<a href="<?php echo get_the_permalink( $product->id ); ?>" title="<?php echo get_the_title( $product->id );?>">
													<?php echo get_the_title( $product->id ); ?>
												</a>
											</h4>
											<?php if ( $price_html = $product->get_price_html() ){?>
												<div class="item-price">
													<span>
														<?php echo $price_html; ?>
													</span>
												</div>
											<?php } ?>	
											
											<?php 
												$rating_count = $product->get_rating_count();
												$review_count = $product->get_review_count();
												$average      = $product->get_average_rating();
											?>
											<div class="reviews-content">
												<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
											</div>
											
											<!-- add to cart, wishlist, compare -->
											<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
										</div>								
									</div>
								</div>
							<?php } else { ?>
								<div class="item-wrap">
									<div class="item-detail">										
										<div class="item-img products-thumb">			
											<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
										</div>										
										<div class="item-content">
											<h4>
												<a href="<?php echo get_the_permalink( $product->id ); ?>" title="<?php echo get_the_title( $product->id );?>">
													<?php echo get_the_title( $product->id ); ?>
												</a>
											</h4>				
												
											<?php if ( $price_html = $product->get_price_html() ){?>
												<div class="item-price">
													<span>
														<?php echo $price_html; ?>
													</span>
												</div>
											<?php } ?>	
											
											<?php 
												$rating_count = $product->get_rating_count();
												$review_count = $product->get_review_count();
												$average      = $product->get_average_rating();
											?>
											<div class="reviews-content">
												<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
											</div>
											
											<!-- add to cart, wishlist, compare -->
											<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
										</div>								
									</div>
								</div>
						<?php } }?>
					<?php if ( ( $key + 1 ) % 2 == 0 || ( $key+1 ) == count( $items )  ) { ?>	
				</div>
			<?php } } ?>
			</div>
			
			<div class="link-product">
				<a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>"><?php esc_html_e('View All Products', 'sw_woocommerce') ?></a>
			</div>
		</div>					
	</div>
<?php }	?>