<?php 

/**
	* Layout Tab Category Default
	* @version     1.0.0
**/

	$tag_id = 'sw_woo_tab_'. rand().time();
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Tab Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div>';
	}
	if( !is_array( $category ) ){
		$category = explode( ',', $category );
	}
	$nav_id = 'nav_tabs_res'.rand().time();
?>
<div class="sw-woo-tab-cat <?php echo esc_attr($elclass) ?>" id="<?php echo esc_attr( $tag_id ); ?>" >
	<div class="resp-tab" style="position:relative;">
		<div class="top-tab-slider clearfix">
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
				
				<?php if( $description != '') {?>
					<div class="order-desc">
						<span><?php echo $description; ?></span>
					</div>
				<?php } ?>
			</div>
			<button class="navbar-toggle collapsed pull-right" type="button" data-toggle="collapse" data-target="#<?php echo esc_attr($nav_id); ?>"  aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="fa fa-bar"></span>
				<span class="fa fa-bar"></span>
				<span class="fa fa-bar"></span>
			</button>
			
			<ul class="nav nav-tabs" id="<?php echo esc_attr($nav_id); ?>">
				<?php
					foreach($category as $key => $cat){
						$terms = get_term_by('id', $cat, 'product_cat');
						if( $terms != NULL ){							
				?>
					<li class="<?php if( ( $key + 1 ) == $tab_active ){echo 'active'; }?>">
						<a href="#<?php echo $select_order.'_category_'.$cat; ?>" data-toggle="tab">
							<?php echo $terms->name; ?>
						</a>
					</li>			
					<?php }} ?>
			</ul>
		</div>
		<div class="tab-content">
			<?php
				foreach($category as $key => $cat){
					$terms = get_term_by('id', $cat, 'product_cat');
					if( $terms != NULL ){
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
				$list = new WP_Query( $default );				
			?>
	
			<div class="tab-pane<?php if( ( $key + 1 ) == $tab_active ){echo ' active in'; }?>" id="<?php echo $select_order.'_category_'.$cat; ?>">
				<?php if( $list->have_posts() ) : ?>
				<div id="<?php echo $select_order.'_category_id_'.$cat; ?>" class="woo-tab-container-slider responsive-slider clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
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
				<?php 
					else :
						esc_html_e( 'There is no product on this category', 'sw_woocommerce' );
					endif;
				?>
			</div>
			<?php
				} }
			?>
		</div>
	</div>
</div>