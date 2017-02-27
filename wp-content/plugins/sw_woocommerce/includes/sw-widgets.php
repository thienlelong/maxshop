<?php
/**
 * SW WooCommerce Widget Functions
 *
 * Widget related functions and widget registration
 *
 * @author 		flytheme
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include_once( 'sw-widgets/sw-brand.php' );
include_once( 'sw-widgets/sw-slider-countdown-widget.php' );
include_once( 'sw-widgets/sw-woo-tab-category-slider-widget.php' );
include_once( 'sw-widgets/sw-related-upsell-widget.php' );
include_once( 'sw-woocommerce-shortcodes.php' );
include_once( 'sw-widgets/sw-slider-widget.php' );
include_once( 'sw-widgets/sw-woo-tab-slider-widget.php' );
include_once( 'sw-widgets/sw-category-slider-widget.php' );

/**
 * Register Widgets
**/
function sw_register_widgets() {
	register_widget( 'sw_brand_slider_widget' );
	register_widget( 'sw_woo_slider_countdown_widget' );	
	register_widget( 'sw_woo_tab_cat_slider_widget' );
	register_widget( 'sw_related_upsell_widget' );
	register_widget( 'sw_woo_slider_widget' );	
	register_widget( 'sw_woo_tab_slider_widget' );
	register_widget( 'sw_woo_cat_slider_widget' );
}
add_action( 'widgets_init', 'sw_register_widgets' );
