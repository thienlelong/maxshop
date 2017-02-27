<?php 
$id = $this -> number;
$id ++;
$tag_id = 'sw_woo_tab_' .rand().time();
if( !is_array( $select_order ) ){
	$select_order = explode( ',', $select_order );
}	
$nav_id = 'nav_tabs_res'.rand().time();
?>
<div class="sw-woo-tab" id="<?php echo esc_attr( $tag_id ); ?>" >
	<div class="resp-tab" style="position:relative;">				
		<div class="category-slider-content clearfix">
			<!-- Get child category -->
			<?php 
			if( $category != '' ){
				$term = get_term_by( 'slug', $category, 'product_cat' );
				?>
				<div class="order-title">
					<h2><?php echo ( $title1 != '' ) ? $title1 : $term->name ; ?></h2>
				</div>
				<?php 
				$termchild = get_term_children( $term->term_id, 'product_cat' );
				if( count( $termchild ) > 0 ){
					?>			
					<div class="childcat-slider pull-left">				
						<div class="childcat-content">
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
					</div>
					<?php } ?>
					<?php } else{ ?>
					<div class="order-title">
						<h2><?php echo ( $title1 != '' ) ? $title1 : esc_html__( 'All Categories', 'sw_woocommerce' ) ; ?></h2>
					</div>
					<?php } ?>
					<!-- End get child category -->					
					<div class="top-tab-slider clearfix">
						<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#<?php echo esc_attr($nav_id); ?>"  aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="fa fa-bar"></span>
							<span class="fa fa-bar"></span>
							<span class="fa fa-bar"></span>
						</button>			
						<ul class="nav nav-tabs">
							<?php 
							$tab_title = '';
							foreach( $select_order as $i  => $so ){						
								switch ($so) {
									case 'latest':
									$tab_title = __( 'Latest Products', 'sw_woocommerce' );
									break;
									case 'rating':
									$tab_title = __( 'Top Rating Products', 'sw_woocommerce' );
									break;
									case 'bestsales':
									$tab_title = __( 'Best Selling Products', 'sw_woocommerce' );
									break;						
									default:
									$tab_title = __( 'Featured Products', 'sw_woocommerce' );
								}
								?>
								<li <?php echo ( $i == 0 )? 'class="active"' : ''; ?>>
									<a href="#<?php echo $so . '_' . $category.$id; ?>" data-toggle="tab">
										<?php echo esc_html( $tab_title ); ?>
									</a>
								</li>			
								<?php } ?>
							</ul>
						</div>
						<div class="tab-content clearfix">
							<!-- Product tab slider -->
							<?php 
							foreach( $select_order as $i  => $so ){ 
								switch ($so) {
									case 'latest':
									$tab_title = __( 'Latest Products', 'sw_woocommerce' );
									break;
									case 'rating':
									$tab_title = __( 'Top Rating Products', 'sw_woocommerce' );
									break;
									case 'bestsales':
									$tab_title = __( 'Best Selling Products', 'sw_woocommerce' );
									break;						
									default:
									$tab_title = __( 'Featured Products', 'sw_woocommerce' );
								}
								?>
								<div class="tab-pane <?php echo ( $i == 0 ) ? 'active' : ''; ?>" id="<?php echo $so . '_' . $category.$id; ?>">
									<?php
									global $woocommerce;
									$default = array();
									if( $category != '' ){
										$default['tax_query'] =  array(
											array(
												'taxonomy'	=> 'product_cat',
												'field'		=> 'slug',
												'terms'		=> $category,
												'operator' 	=> 'IN'
												)
											);
									}
									if( $so == 'latest' ){
										$default = array(
											'post_type' => 'product',
											'tax_query' => array(
												array(
													'taxonomy' => 'product_cat',
													'field'  => 'slug',
													'terms'  => $category,
													'operator'  => 'IN'
													)
												),
											'paged'  => 1,
											'showposts' => $numberposts,
											'orderby' => 'date'
											);
									}
									if( $so == 'rating' ){
										$default = array(
											'post_type'		=> 'product',							
											'post_status' 	=> 'publish',
											'no_found_rows' => 1,					
											'showposts' 	=> $numberposts						
											);
										$default['meta_query'] = WC()->query->get_meta_query();
										add_filter( 'posts_clauses',  array( $this, 'order_by_rating_post_clauses' ) );
									}
									if( $so == 'bestsales' ){
										$default = array(
											'post_type' 			=> 'product',							
											'post_status' 			=> 'publish',
											'ignore_sticky_posts'   => 1,
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
									if( $so == 'featured' ){
										$default = array(
											'post_type'	=> 'product',
											'post_status' 			=> 'publish',
											'ignore_sticky_posts'	=> 1,
											'posts_per_page' 		=> $numberposts,
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
									$list = new WP_Query( $default );
									$max_page = $list -> max_num_pages;
									if( $so == 'rating' ){
										remove_filter( 'posts_clauses',  array( $this, 'order_by_rating_post_clauses' ) );
									}
									?>
									<div id="<?php echo $so.'_category_id_'.$category.$id; ?>" class="woo-tab-container-slider responsive-slider loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
										<div class="resp-slider-container">
											<div class="slider responsive">
												<?php 
												$count_items 	= 0;
												$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
												$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
												$i 				= 0;
												while($list->have_posts()): $list->the_post();
												global $product, $post;
												$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
												if( $i % $item_row == 0 ){
													?>
													<div class="item <?php echo esc_attr( $class )?>">
														<?php } ?>
														<?php include( WCTHEME . '/default-item.php' ); ?>
														<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
														<?php $i++; endwhile; wp_reset_postdata();?>
													</div>
												</div>
											</div>			
										</div>
										<?php } ?>
										<!-- End product tab slider -->
									</div>
								</div>
							</div>
						</div>