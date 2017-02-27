<?php 
/**
	* Layout Countdown Default
	* @version     1.0.0
**/
$term_name = esc_html__( 'All Categories', 'sw_woocommerce' );
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
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	$term_name = $term->name;
	$default['tax_query'] = array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'slug',
			'terms'     => $category ));
}
$countdown_id = 'sw_tab_countdown_'.rand().time();
$countdown_id2 = 'sw_tab_countdown2_'.rand().time();
$list = new WP_Query( $default );
if ( $list -> have_posts() ){ ?>
<div id="<?php echo $countdown_id; ?>" class="sw_tab_countdown sw_tab_countdown_2">
<?php if ($title1 !='') { ?> 
<div class="order-title">
               <?php if( $image_icon != '' ) { ?>
					<span class="order-icon">
						<?php 
							$image_thumb = wp_get_attachment_image( $image_icon, 'thumbnail' );
							echo $image_thumb; 
						 ?>
					</span>
				<?php } ?>
				<?php
					$titles = strpos($title1, ' ');
					$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
					echo '<h2><strong>'. $title .'</strong></h2>';
				?>	
</div>
<?php } ?>
<div  class="tab-countdown-slide clearfix">	
	
		<div class="top-tab-slider clearfix">	
			<div id="<?php echo 'tab_' . $countdown_id; ?>" class="sw-tab-slider responsive-slider loading hidden-sm hidden-xs" data-lg="8" data-md="6" data-sm="6" data-xs="5" data-mobile="2" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="false" data-vertical="false">
				<ul class="nav nav-tabs slider responsive">
					<?php
						$i = 0;
						while($list->have_posts()): $list->the_post();	
						global $product, $post;
					?>
					<li <?php echo ( $i == 0 )? 'class="item active"' : 'class="item"'; ?>>
						<a href="#<?php echo 'product_tab_'.$product->id; ?>" data-toggle="tab">
							<?php echo get_the_post_thumbnail( $product->id, 'shop_thumbnail' ); ?>
						</a>
					</li>
					<?php
						$i++; endwhile; wp_reset_postdata();
					?>
				</ul>
			</div>
		</div>
		<div class="tab-content clearfix">
			<?php
				$count_items 	= 0;
				$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
				$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
				$i 				= 0;
				while($list->have_posts()): $list->the_post();
				global $product, $post;
				$start_time = get_post_meta( $post->ID, '_sale_price_dates_from', true );
				$countdown_time = get_post_meta( $post->ID, '_sale_price_dates_to', true );	
				$orginal_price = get_post_meta( $post->ID, '_regular_price', true );	
				$sale_price = get_post_meta( $post->ID, '_sale_price', true );	
				$symboy = get_woocommerce_currency_symbol( get_woocommerce_currency() );
				$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
			?>
			<div class="tab-pane <?php echo ( $i == 0 ) ? 'active' : ''; ?>" id="<?php echo 'product_tab_'.$product->id; ?>" >
				<div class="item-wrap">
					<div class="item-detail">										
						<div class="item-img products-thumb">
						   <span class="onsale"><?php echo esc_html__('Sale','sw_woocommerce') ?></span>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php 
									$id = get_the_ID();
									if ( has_post_thumbnail() ){
											echo get_the_post_thumbnail( $product->id, 'large' ) ? get_the_post_thumbnail( $product->id, 'large' ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'large'.'.png" alt="No thumb">';		
									}else{
										echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'large'.'.png" alt="No thumb">';
									}
								?>
							</a>
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
							<div class="description"><?php echo $post->post_excerpt; ?></div>
												
							<!-- price -->
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
						<div class="countdown-left"><div class="product-countdown"  data-price="<?php echo esc_attr($orginal_price ); ?>" data-starttime="<?php echo esc_attr( $start_time ); ?>" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" data-id="<?php echo 'product_'.$id.$post->ID; ?>"></div>
						</div>			
					</div>
				</div>
			</div>
			<?php
				$i++; endwhile; wp_reset_postdata();
			?>
		</div>

</div>
</div>
<?php
	} 
?>
<script type="text/javascript">
/* (function ($) {
	"use strict";
	$('#<?php echo 'mytab_' . $countdown_id; ?> a').click(function (e) {
		console.log( $(this) );
		e.preventDefault();
		$(this).tab('show');
	});
})(jQuery); */
</script>