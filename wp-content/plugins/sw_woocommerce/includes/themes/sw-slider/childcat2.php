<?php
if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Please select a category for SW Woocommerce Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
	</div>';
}
$widget_id = isset( $widget_id ) ? $widget_id : 'sw_woo_slider_'.rand().time();

$default = array();
if( $category != '' ){
	$default = array(
		'post_type' => 'product',
		'tax_query' => array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'slug',
			'terms'     => $category ) ),
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
}
$term = get_term_by( 'slug', $category, 'product_cat' );	
$list = new WP_Query( $default );
//var_dump( $list->posts );
if ( $list -> have_posts() ){ ?>
	<div id="<?php echo $widget_id; ?>" class="sw-woo-container-slider responsive-slider woo-slider-default loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="block-title clearfix">
			<h2 class="page-title-slider"><?php echo $term->name; ?></h2>			
		</div>
		<div class="childcat-slider-content clearfix">
		<?php 
			$termchild = get_term_children( $term->term_id, 'product_cat' );
			if( count( $termchild ) > 0 ){
		?>			
			<div class="childcat-content pull-left">
			<?php 
				$termchild = get_term_children( $term->term_id, 'product_cat' );
				echo '<ul>';
				foreach ( $termchild as $child ) {
					$term = get_term_by( 'id', $child, 'product_cat' );
					echo '<li><a href="' . get_term_link( $child, 'product_cat' ) . '">' . $term->name . '</a></li>';
				}
				echo '</ul>';
			?>
			</div>
			<?php } ?>
			<div class="resp-slider-container clearfix">
				<div class="first-item">
				<?php
					$i = 0;					
					while( $i == 0 && $i < count( $list->posts ) ){
					$list->the_post();					
						global $product;						
				?>
					<div class="item">										
						<div class="item-img products-thumb">											
							<!-- quickview & thumbnail  -->
							<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
						</div>										
						<div class="item-content">
							<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a></h4>								
																		
							<!-- rating  -->
							<?php 
								$rating_count = $product->get_rating_count();
								$review_count = $product->get_review_count();
								$average      = $product->get_average_rating();
							?>
							<div class="reviews-content">
								<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
								<div class="item-number-rating">
									<?php echo $review_count; _e(' Review(s)', 'sw_woocommerce');?>
								</div>
							</div>	
							<!-- end rating  -->
							<?php if ( $price_html = $product->get_price_html() ){?>
							<div class="item-price">
								<span>
									<?php echo $price_html; ?>
								</span>
							</div>
							<?php } ?>
							<!-- add to cart, wishlist, compare -->
							<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
						</div>											
					</div>
				<?php
					$i++;
					}
				?>
				</div>
				<div class="resp-slider-container">
				<div class="slide-right">
					<div class="slider responsive">	
						<?php 
							$j				= 1;
							$count_items 	= 0;
							$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
							while( $j < count( $list->posts ) ): 
							$list->the_post();global $product, $post, $wpdb, $average; 
							if( ( $j-1 ) % $item_row == 0 ){
						?>
							<div class="item">
						<?php } ?>
								<div class="item-wrap">
									<div class="item-detail">										
										<div class="item-img products-thumb">											
											<!-- quickview & thumbnail  -->
											<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
										</div>										
										<div class="item-content">
											<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a></h4>								
																						
											<!-- rating  -->
											<?php 
												$rating_count = $product->get_rating_count();
												$review_count = $product->get_review_count();
												$average      = $product->get_average_rating();
											?>
											<div class="reviews-content">
												<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
												<div class="item-number-rating">
													<?php echo $review_count; _e(' Review(s)', 'sw_woocommerce');?>
												</div>
											</div>	
											<!-- end rating  -->
											<?php if ( $price_html = $product->get_price_html() ){?>
											<div class="item-price">
												<span>
													<?php echo $price_html; ?>
												</span>
											</div>
											<?php } ?>
											<!-- add to cart, wishlist, compare -->
											<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
										</div>											
									</div>
								</div>
							<?php if( ( $j ) % $item_row == 0 || ( $j ) == $count_items ){?> </div><?php } ?>
						<?php $j ++; endwhile; wp_reset_postdata();?>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>
	<?php
	}
?>