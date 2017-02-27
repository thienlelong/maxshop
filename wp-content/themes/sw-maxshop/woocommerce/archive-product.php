<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$sidebar = ya_options() -> getCpanelValue('sidebar_product');
$image = ya_options()->getCpanelValue('product_banner');
//var_dump ($sidebar);
?>
<?php get_template_part('header'); ?>

<div class="container">
<div class="row">
<?php if ( is_active_sidebar_YA('left-product') && $sidebar == 'left' ):
	$left_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_left_expand');
	$left_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_left_expand_sm');
?>
<aside id="left" class="sidebar <?php echo esc_attr($left_span_class); ?>">
	<?php dynamic_sidebar('left-product'); ?>
</aside>

<?php endif; ?>
<div id="contents" <?php ya_content_product(); ?> role="main">
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		 global $post;
		do_action('woocommerce_before_main_content');
	?>
		<div class="products-wrapper">
		<?php if (is_product_category()){ ?>
		<?php  global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	    ?>
		<?php if(!$image){ ?>
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		
			<div class="listing-title">
			
				<h1><span><?php woocommerce_page_title(); ?></span></h1>
				
			</div>
		<?php endif; ?>
        <?php } else {?>
		<?php  echo '<div class="image-category"><img src="' . $image . '" alt="" /></div>'; } ?>
		<?php } else {?>
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		
			<div class="listing-title">
			
				<h1><span><?php woocommerce_page_title(); ?></span></h1>
				
			</div>
		<?php endif; }?>
		
		<?php if ( have_posts() ) : ?>
 <?php do_action('woocommerce_message'); ?>
	<div class="products-nav">
		<?php
			/**
			 * woocommerce_before_shop_loop hook
			 *
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );
		?>
	</div>
	<div class="clear"></div>
		<?php woocommerce_product_loop_start(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>
<div class="products-nav">
		<?php
			/**
			 * woocommerce_after_shop_loop hook
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		?>
</div>
<div class="clear"></div>
	<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

		<?php wc_get_template( 'loop/no-products-found.php' ); ?>

	<?php endif; ?>
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
<?php if ( is_active_sidebar_YA('right-product') && $sidebar == 'right' ):
	$right_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_right_expand');
	$right_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_right_expand_sm');
?>
<aside id="right" class="sidebar <?php echo esc_attr($right_span_class); ?>">
	<?php dynamic_sidebar('right-product'); ?>
</aside>
<?php endif; ?>

</div>
</div>
</div>
<script language="JavaScript">
(function($) {	
    $( window ).load(function() {
		/* Change Layout */
		$('.view-list').on('click',function(){
			$('.view-grid').removeClass('sel');
			$('.view-list').addClass('sel');
			jQuery("ul.products-loop").fadeOut(300, function() {
				jQuery(this).addClass("list").fadeIn(300).removeClass( 'grid' );
			});
		});
		
		$('.view-grid').on('click',function(){
			$( '.view-list' ).removeClass('sel');
			$( '.view-grid' ).addClass('sel');
			$("ul.products-loop").fadeOut(300, function() {
				$(this).removeClass("list").fadeIn(300).addClass( 'grid' );
			});
		});
		/* End Change Layout */
       
    });
})(jQuery);
</script>
<?php get_template_part('footer'); ?>
