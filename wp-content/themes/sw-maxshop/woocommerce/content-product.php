<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $post;
$ya_quickview = ya_options()->getCpanelValue( 'quickview_enable' );
$col_lg = ya_options()->getCpanelValue('product_col_large');
$col_md = ya_options()->getCpanelValue('product_col_medium');
$col_sm = ya_options()->getCpanelValue('product_col_sm');
$col_large = 12 / $col_lg;
$column1 = 12 / $col_md;
$column2 = 12 / $col_sm;
$class_col= "";

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
 return;
}

$class_col .= ' col-lg-'.$col_large.' col-md-'.$column1.' col-sm-'.$column2;

if ( 0 == $woocommerce_loop['loop'] % $col_lg || 1 == $col_lg ) {
 $class_col .= ' clear_lg';
}
if ( 0 == $woocommerce_loop['loop'] % $col_md || 1 == $col_md ) {
 $class_col .= ' clear_md';
}
if ( 0 == $woocommerce_loop['loop'] % $col_sm || 1 == $col_sm ) {
 $class_col .= ' clear_sm';
}

?>
<li <?php post_class($class_col); ?>>
	<div class="products-entry clearfix">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="products-thumb">
			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
				/*
					* Quickview
				*/
				
				if( $ya_quickview ) :
					$nonce = wp_create_nonce("ya_quickviewproduct_nonce");
					$link = admin_url('admin-ajax.php?ajax=true&amp;action=ya_quickviewproduct&amp;post_id='.$product->id.'&amp;nonce='.$nonce);
					$linkcontent ='<a href="'. $link .'" data-fancybox-type="ajax" class="fancybox fancybox.ajax sm_quickview_handler-list" title="Quick View Product">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', 'maxshop' ) ).'</a>';
					echo $linkcontent;
				endif;
			?>
		</div>
		<div class="products-content">	
			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
			<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php the_title(); ?> </a></h4>
			<?php if ( $price_html = $product->get_price_html() ){?>
			<div class="item-price">
				<span>
					<?php echo $price_html; ?>
				</span>
			</div>
			<?php } ?>
			<div class="desc std">
	        <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
            </div>
			<div class="item-bottom clearfix">
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
				<?php 
					if( $ya_quickview ) :
						$nonce = wp_create_nonce("ya_quickviewproduct_nonce");
						$link = admin_url('admin-ajax.php?ajax=true&amp;action=ya_quickviewproduct&amp;post_id='.$product->id.'&amp;nonce='.$nonce);
						$linkcontent ='<a href="'. esc_url( $link ) .'" data-fancybox-type="ajax" class="fancybox fancybox.ajax sm_quickview_handler" title="Quick View Product">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', 'maxshop' ) ).'</a>';
						echo $linkcontent;
					endif;
				?>
			</div>
            <?php
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_price - 10
             */
            ?>
		</div>
	</div>
</li>