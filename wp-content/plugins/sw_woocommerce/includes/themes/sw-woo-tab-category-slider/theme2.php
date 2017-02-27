<?php 
	$id = $this->number;
	$this->number = $id + 1;
	$tag_id = 'sw_woo_tab_'. $id;
	if( !is_array( $category ) ){
		$category = explode( ',', $category );
	}
?>
<div class="sw-woo-tab-cat loading" id="<?php echo esc_attr( $tag_id ); ?>" >
	<div class="resp-tab" style="position:relative;">
		<div class="top-tab-slider clearfix">
			<div class="order-title">
				<?php
					$titles = strpos($title1, ' ');
					$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
					echo '<h2>'. $title .'</h2>';
				?>
			</div>
			<ul class="nav nav-tabs">
			<?php
				foreach($category as $key => $cat){
					$terms = get_term_by('id', $cat, 'product_cat');				
			?>
				<li class="<?php if( ( $key + 1 ) == $tab_active ){echo 'active'; }?>">
					<a href="#<?php echo $select_order.'_category_'.$cat; ?>" data-toggle="tab">
						<?php echo $terms->name; ?>
					</a>
				</li>			
			<?php } ?>
			</ul>
		</div>
		<div class="tab-content">
			<?php
				foreach($category as $key => $cat){
					if( $select_order == 'latest' ){
					$default = array(
						'post_type'	=> 'product',
						'tax_query'	=> array(
						array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'id',
							'terms'		=> $cat)),
						'orderby' => 'date',
						'order' => $order,
						'post_status' => 'publish',
						'showposts' => $numberposts
					);
				}
				if( $select_order == 'rating' ){
					$default = array(
						'post_type' 			=> 'product',
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'   => 1,
						'tax_query'	=> array(
						array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'id',
							'terms'		=> $cat)),
						'orderby' 				=> $orderby,
						'order'					=> $order,
						'showposts' 		=> $numberposts,
						'meta_query' 			=> array(
							array(
								'key' 			=> '_visibility',
								'value' 		=> array('catalog', 'visible'),
								'compare' 		=> 'IN'
							)
						)
					);
					add_filter( 'posts_clauses',  array( $this, 'order_by_rating_post_clauses' ) );
					//var_dump($woocommerce->query);
				}
				if( $select_order == 'bestsales' ){
				$default = array(
					'post_type' 			=> 'product',
					'post_status' 			=> 'publish',
					'ignore_sticky_posts'   => 1,
					'tax_query'	=> array(
						array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'id',
							'terms'		=> $cat)),
					'paged'	=> 1,
					'showposts'				=> $numberposts,
					'meta_key' 		 		=> 'total_sales',
					'orderby' 		 		=> 'meta_value_num',
					'meta_query' 			=> array(
						array(
							'key' 		=> '_visibility',
							'value' 	=> array( 'catalog', 'visible' ),
							'compare' 	=> 'IN'
						)
					)
				);
			}
			if( $select_order == 'featured' ){
				$default = array(
					'post_type'				=> 'product',
					'post_status' 			=> 'publish',
					'tax_query'	=> array(
						array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'id',
							'terms'		=> $cat)),
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
			}
			
			if( $orderby == 'rand' ){
				$default = array(
					'post_type'	=> 'product',
					'tax_query'	=> array(
					array(
						'taxonomy'	=> 'product_cat',
						'field'		=> 'id',
						'terms'		=> $cat)),
					'orderby' => $orderby,					
					'post_status' => 'publish',
					'showposts' => $numberposts
				);
			}
			
			$list = new WP_Query( $default );
			do_action( 'before' ); 
			?>
			<div class="tab-pane<?php if( ( $key + 1 ) == $tab_active ){echo ' active'; }?>" id="<?php echo $select_order.'_category_'.$cat; ?>">
				<div id="<?php echo $select_order.'_category_id_'.$cat; ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
					<div class="resp-slider-container">
						<div class="slider responsive">
						<?php 
							$i = 1;
							while($list->have_posts()): $list->the_post();
							global $product, $post, $wpdb, $average;
						?>
							<div class="item">
								<div class="item-wrap">
									<div class="item-detail">										
										<div class="item-img products-thumb">											
											<!-- quickview & thumbnail  -->
												<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
												<?php //do_action('wp_ajax_ya_quickviewproduct' );?>
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
											</div>	
											<!-- end rating  -->
											<?php if ( $price_html = $product->get_price_html() ){?>
												<div class="item-price">
													<span>
														<?php echo $price_html; ?>
													</span>
												</div>
												<?php } ?>
												<div class="item-cart">
													<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
														sprintf( '<a href="%s" rel="nofollow" title="Add To Cart" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
															esc_url( $product->add_to_cart_url() ),
															esc_attr( $product->id ),
															esc_attr( $product->get_sku() ),
															$product->is_purchasable() ? 'add_to_cart_button' : '',
															esc_attr( $product->product_type ),
															esc_html( $product->add_to_cart_text() )
														), $product );
													?>
												</div>
										</div>
											<div class="item-bottom clearfix">
											<?php if ( in_array( 'yith-woocommerce-compare/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
													
													if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
														echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
													}
													if ( in_array( 'yith-woocommerce-compare/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
														echo do_shortcode('[yith_compare_button]');
													}
												}
												?>
										</div>
									</div>
								</div>
							</div>
							<?php $i++; endwhile; wp_reset_postdata();?>
						</div>
					</div>
				</div>			
			</div>
			<?php
			} 
			?>
		</div>
	</div>
</div>