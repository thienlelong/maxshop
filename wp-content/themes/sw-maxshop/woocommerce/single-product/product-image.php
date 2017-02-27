<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $woocommerce, $product;
$ya_direction 		= ya_options()->getCpanelValue( 'direction' );
$sidebar_product 	= ya_options()->getCpanelValue( 'sidebar_product' );

?>
<div id="product_img_<?php echo esc_attr( $post->ID ); ?>" class="product-images loading" data-rtl="<?php echo ( is_rtl() || $ya_direction == 'rtl' )? 'true' : 'false';?>" data-vertical="<?php echo ( $sidebar_product == 'full' ) ? 'true' : 'false'; ?>">
	<div class="product-images-container clearfix <?php echo ( $sidebar_product == 'full' ) ? 'thumbnail-left' : 'thumbnail-bottom'; ?>">
		<?php 
			if( has_post_thumbnail() ){ 
				$attachments 		= $product->get_gallery_attachment_ids();
				$image_id = get_post_thumbnail_id();
				array_unshift( $attachments, $image_id );
		 ?>
		<?php 
			if( $sidebar_product == 'full' ){
				do_action('woocommerce_product_thumbnails');
			}
		?>
		<!-- Image Slider -->
		<div class="slider product-responsive">
			<?php foreach ( $attachments as $key => $attachment ) { ?>
			<div class="item-img-slider">
				<div class="images">
					<?php if ($product->is_on_sale()) : ?>

						<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale!', 'maxshop' ).'</span>', $post, $product); ?>

					<?php endif; ?>
					<a href="<?php echo wp_get_attachment_url( $attachment ) ?> " data-rel="prettyPhoto[product-gallery]" class="zoom"><?php echo wp_get_attachment_image( $attachment, 'shop_single' ); ?></a>
				</div>
			</div>
			<?php } ?>
		</div>
		<!-- Thumbnail Slider -->
		<?php 
			if( $sidebar_product != 'full' ){
				do_action('woocommerce_product_thumbnails'); 
			}
		?>
		<?php }else{ ?>
			<?php $image_id = get_post_thumbnail_id(); $image_url = wp_get_attachment_image_src($image_id,'large', true); ?>
			<div class="single-img-product">
				<div class="images">
				<?php if ($product->is_on_sale()) : ?>

					<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale!', 'maxshop' ).'</span>', $post, $product); ?>

				<?php endif; ?>
				<a title="<?php the_title(); ?>" href="<?php echo esc_url( $image_url[0] );  ?>" rel="prettyPhoto[product-gallery]" class="zoom"><?php the_post_thumbnail('shop_single'); ?></a>
				</div>
			</div>
		<?php } ?>
	</div>	
</div>