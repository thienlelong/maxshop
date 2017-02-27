<?php 
/* header style 3 */
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
	return false;
}
global $woocommerce; ?>
<div class="top-form top-form-minicart  minicart-product-style2 pull-right">
	<div class="top-minicart pull-right">
	<h2><?php _e('Shopping Cart','maxshop');?></h2>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'maxshop'); ?>"><?php echo '<span class="minicart-number">'.$woocommerce->cart->cart_contents_count.'</span>'; _e('item(s)', 'maxshop');?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	
	</div>
	<?php if( count($woocommerce->cart->cart_contents) > 0 ){?>
	<div class="wrapp-minicart">
		<div class="minicart-padding">
			<ul class="minicart-content">
			<?php foreach($woocommerce->cart->cart_contents as $cart_item_key => $cart_item): ?>
				<li>
					<a href="<?php echo get_permalink($cart_item['product_id']); ?>" class="product-image">
						<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
						<?php echo get_the_post_thumbnail($thumbnail_id, 'shop_thumbnail'); ?>
					</a>
					<?php 	global $product, $post, $wpdb, $average;
			$count = $wpdb->get_var($wpdb->prepare("
				SELECT COUNT(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
				AND meta_value > 0
			",$cart_item['product_id']));

			$rating = $wpdb->get_var($wpdb->prepare("
				SELECT SUM(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
			",$cart_item['product_id']));?>		
						 
	<div class="detail-item">
    <div class="product-details"> 
    	<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="btn-remove" title="%s"><span></span></a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'maxshop' ) ), $cart_item_key ); ?>           
        <a class="btn-edit" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'maxshop'); ?>"><span></span></a>    
		<div class="rating-container">
			    <div class="ratings">
        			 <?php
						if( $count > 0 ){
							$average = number_format($rating / $count, 1);
					?>
						<div class="star"><span style="width: <?php echo ($average*14).'px'; ?>"></span></div>
						
					<?php } else { ?>
					
						<div class="star"></div>
						
					<?php } ?>			      
                
                </div>
 		</div>
		 
        
        <p class="product-name">
							<a href="<?php echo get_permalink($cart_item['product_id']); ?>"><?php echo esc_html( $cart_item['data']->post->post_title ); ?></a>
							<?php echo '<span class="qty-number">'.esc_html( $cart_item['quantity'] ).'</span>'; ?>
        </p>
        
  
	</div>
	    
	<div class="product-details-bottom">

		 <span class="price"><?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?></span>		        		        		    		
			
    </div>
	</div>
					
				</li>
			<?php
			endforeach;
			?>
			</ul>
			<div class="cart-checkout">
			    <div class="price-total">
				   <span class="label-price-total"><?php _e('Total:', 'maxshop'); ?></span>
				   <span class="price-total-w"><span class="price"><?php echo $woocommerce->cart->get_cart_total(); ?></span></span>
				   
				</div>
				<div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" title="Cart"><?php _e('Go To Cart', 'maxshop'); ?></a></div>
				<div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>" title="Check Out"><?php _e('Check Out', 'maxshop'); ?></a></div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>