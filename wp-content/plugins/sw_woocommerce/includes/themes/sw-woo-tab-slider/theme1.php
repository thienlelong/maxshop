<?php 
$id = $this -> number;
$id ++;
$tag_id = 'sw_woo_tab_' .rand().time();
if( !is_array( $select_order ) ){
	$select_order = explode( ',', $select_order );
}	

$term = null;
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );
}
$nav_id = 'nav_tabs_res'.rand().time();
?>
<div class="sw-woo-tab sw-woo-tab-slide" id="<?php echo esc_attr( $tag_id ); ?>" >
	<div class="resp-tab clearfix">			
		<div class="top-tab-listing clearfix">			
			<?php if( $term ) : ?>
				<h2 class="pull-left"><span><?php echo $term->name; ?></span></h2>
			<?php endif; ?>
			<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#<?php echo esc_attr($nav_id); ?>"  aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="fa fa-bar"></span>
				<span class="fa fa-bar"></span>
				<span class="fa fa-bar"></span>
			</button>
			<ul class="nav nav-tabs pull-right">
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
			<div class="category-listing-content clearfix">		

				<!-- Get child category -->
				<?php 		
				if( $term ) :
					$thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
				$thumb = wp_get_attachment_image( $thumbnail_id, array(350, 230) );
				$termchild = get_term_children( $term->term_id, 'product_cat' );
				$terms = get_term_by( 'slug', $category, 'product_cat' );

				if( count( $termchild ) > 0 && $thumb != '' ){
					?>			
					<div class="childcat-listing pull-left">	
						<!-- THumbnail category -->
						<a href="<?php get_term_link( $term->term_id, 'product' ); ?>"><?php echo $thumb; ?></a>
						
						<!-- Child cat content -->
						<div class="childcat-content">
							<h4><?php _e( "Hot categories", 'sw_woocommerce' )?></h4>
							<?php 
							$termchild = get_term_children( $term->term_id, 'product_cat' );
							echo '<ul>';
							foreach ( $termchild as $key => $child ) {
								if( $key <= 5 ){
									$term = get_term_by( 'id', $child, 'product_cat' );
									echo '<li><a href="' . get_term_link( $child, 'product_cat' ) . '">' . $term->name . '</a></li>';		
								}
							}
							echo '<li class="item"><a class="category-show-more" href="'.get_term_link($terms->term_id, 'product_cat').'">'.__('View More...','sw_woocommerce').'</a></li>';
							echo '</ul>';
							?>
						</div>
					</div>
					<?php } ?>
				<?php endif; ?>

				<!-- End get child category -->			
				<div class="tab-content <?php echo esc_attr( 'item-columns'.$columns ); ?> clearfix">
					
					<!-- Product tab listing -->
					<?php 
					$banner_links = explode( ',', $banner_links );
					if( $img_banners != '' ) :
						$img_banners = explode( ',', $img_banners );	
					endif;
					/* Banner SLider */
					if( count( $img_banners ) > 0 && count( $banner_links ) == count( $img_banners ) ) :
						?>
					<div class="banner-category pull-left">
						<div id="<?php echo esc_attr( 'banner_' . $tag_id ); ?>" class="responsive-slider banner-slider loading" data-lg="1" data-md="1" data-sm="1" data-xs="1" data-mobile="1" data-dots="true" data-arrow="false" data-fade="false">
							<div class="slider responsive">
								<?php foreach( $img_banners as $key => $img ) : ?>
									<div class="item">
										<a href="<?php echo esc_url( $banner_links[$key] ); ?>"><?php echo wp_get_attachment_image( $img, 'full' ); ?></a>
									</div>
								<?php endforeach;?>						
							</div>
						</div>									
					</div>
				<?php endif;
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
						<div class="woo-tab-container-listing clearfix">								
							<?php 
							$count_items 	= 0;
							$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
							$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
							$i 				= 0;
							while($list->have_posts()): $list->the_post();
							global $product, $post;
							$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
							?>
							<div class="item <?php echo esc_attr( $class )?> pull-left">
								<?php include( WCTHEME . '/default-item.php' ); ?>
							</div>
							<?php $i++; endwhile; wp_reset_postdata();?>
						</div>			
					</div>
					<?php } ?>
					<!-- End product tab listing -->
				</div>
			</div>
		</div>
	</div>