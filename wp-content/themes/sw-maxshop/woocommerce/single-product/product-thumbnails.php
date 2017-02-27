<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();
if ( $attachment_ids ) {
	if( has_post_thumbnail() ) :
		$image_id = get_post_thumbnail_id();
	array_unshift( $attachment_ids, $image_id );
	endif;
	?>
	<div class="slider product-responsive-thumbnail" id="product_thumbnail_<?php echo esc_attr( $post->ID ); ?>">
	<?php foreach ( $attachment_ids as $attachment_id ) { ?>
		<div class="item-thumbnail-product">
			<div class="thumbnail-wrapper">
			<?php
				$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );	
				echo $image;
			?>
			</div>
		</div>
		<?php
		}
	?>
	</div>
<?php
}
?>
	
