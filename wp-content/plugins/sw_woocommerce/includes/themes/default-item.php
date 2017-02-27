<?php 

/**
* Layout Theme Default
* @version     1.0.0
**/
?>
<?php 
global $product, $woocommerce_loop, $post;
$ya_quickview = ya_options()->getCpanelValue( 'quickview_enable' );
$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
?>
<div class="item-wrap">
	<div class="item-detail">										
		<div class="item-img products-thumb">			
			<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		</div>										
		<div class="item-content">
			<div class="reviews-content">
				<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
			</div>
			<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a></h4>				
			<?php if ( $price_html = $product->get_price_html() ){?>
			<div class="item-price">
				<span>
					<?php echo $price_html; ?>
				</span>
			</div>
			<?php } ?>	
			
			<!-- add to cart, wishlist, compare -->
			<div class="item-bottom-grid clearfix">
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
				<?php 
				if( $ya_quickview ) :
					$nonce = wp_create_nonce("ya_quickviewproduct_nonce");
				$link = admin_url('admin-ajax.php?ajax=true&amp;action=ya_quickviewproduct&amp;post_id='.$product->id.'&amp;nonce='.$nonce);
				$linkcontent ='<a href="'. esc_url( $link ) .'" data-fancybox-type="ajax" class="fancybox fancybox.ajax sm_quickview_handler" title="Quick View Product">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', 'sw_woocommerce' ) ).'</a>';
				echo $linkcontent;
				endif;
				?>
			</div>
		</div>								
	</div>
</div>