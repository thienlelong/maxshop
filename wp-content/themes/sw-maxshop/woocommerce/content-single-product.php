<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$sidebar = ya_options() -> getCpanelValue('sidebar_product');



	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single-product-top row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<?php
			/**
			 * woocommerce_show_product_images hook
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>
		</div>
		<div class="product-summary col-lg-6 col-md-6 col-sm-12 col-xs-12">

			<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>
			   <?php get_social(); ?>
		</div><!--- summary-bottom --->
	</div><!-- .summary -->
	<div class="clearfix"></div>
	<div class="row">	
	<?php 
		$bottom_class = 'col-lg-12';
		if( $sidebar == 'full' ){
		$bottom_class = 'col-lg-9 col-md-8 tab-col-9';
	?>	
		<div class="col-lg-3 col-md-4 tab-col-3">
			<?php Ya_related_product( 8, 'Related Products' ); ?>
		</div>
		<?php } ?>
		<div class="<?php echo $bottom_class; ?>">
		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>
		<?php dynamic_sidebar('bottom-detail-product') ?>
		</div>
	</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>

</div><!-- #product-<?php the_ID(); ?> -->
