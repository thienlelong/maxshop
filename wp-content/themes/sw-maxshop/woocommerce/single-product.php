<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$sidebar = ya_options() -> getCpanelValue('sidebar_product');
?>

<?php get_template_part('header'); ?>

<div class="container">
	<div class="row">
		<?php if ( is_active_sidebar_YA('left-detail-product') && $sidebar == 'left' ):
		$left_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_left_expand');
		$left_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_left_expand_md');
		$left_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_left_expand_sm');
		?>
		<aside id="left" class="sidebar <?php echo esc_attr($left_span_class); ?>">
			<?php dynamic_sidebar('left-detail-product'); ?>
		</aside>

	<?php endif; ?>
	<div id="contents-detail" <?php ya_content_detail_product(); ?> role="main">
		<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
		?>
		<div class="single-product clearfix">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div>

		<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
		?>
	</div>
</div>
<?php if ( is_active_sidebar_YA('right-detail-product') && $sidebar == 'right' ):
	$right_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_right_expand');
	$right_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_right_expand_sm');
	?>
	<aside id="right" class="sidebar <?php echo esc_attr($right_span_class); ?>">
		<?php dynamic_sidebar('right-detail-product'); ?>
	</aside>

<?php endif; ?>
</div>
</div>
<?php get_template_part('footer'); ?>
