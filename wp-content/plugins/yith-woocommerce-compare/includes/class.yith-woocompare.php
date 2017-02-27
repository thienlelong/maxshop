<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH Woocommerce Compare
 * @version 1.1.4
 */

if ( !defined( 'YITH_WOOCOMPARE' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_Woocompare' ) ) {
    /**
     * YITH Woocommerce Compare
     *
     * @since 1.0.0
     */
    class YITH_Woocompare {

        /**
         * Plugin object
         *
         * @var string
         * @since 1.0.0
         */
        public $obj = null;

        /**
         * AJAX Helper
         *
         * @var string
         * @since 1.0.0
         */
        public $ajax = null;

        /**
         * Constructor
         *
         * @return mixed|YITH_Woocompare_Admin|YITH_Woocompare_Frontend
         * @since 1.0.0
         */
        public function __construct() {

            // init widget
            add_action( 'widgets_init', array( $this, 'registerWidgets' ) );

            if( $this->is_frontend() ) {

                // require frontend class
                require_once('class.yith-woocompare-frontend.php');

                $this->obj = new YITH_Woocompare_Frontend();
            }
            elseif( $this->is_admin() ) {

                // Load Plugin Framework
                add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );

                // require admin class
                require_once('class.yith-woocompare-admin.php');

	            $this->obj = new YITH_Woocompare_Admin();
            }

            return $this->obj;
        }

        /**
         * Detect if is frontend
         * @return bool
         */
        public function is_frontend() {
            $is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
	        $context_check = isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'frontend';
	        $actions_to_check = array( 'woof_draw_products' );
	        $action_check = isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], $actions_to_check );

            return (bool) ( ! is_admin() || ( $is_ajax && ( $context_check || $action_check ) ) );
        }

        /**
         * Detect if is admin
         * @return bool
         */
        public function is_admin() {
            $is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
            return (bool) ( is_admin() || $is_ajax && isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'admin' );
        }

	    /**
	     * Load Plugin Framework
	     *
	     * @since  1.0
	     * @access public
	     * @return void
	     * @author Andrea Grillo <andrea.grillo@yithemes.com>
	     */
	    public function plugin_fw_loader() {

            if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                if( ! empty( $plugin_fw_data ) ){
                    $plugin_fw_file = array_shift( $plugin_fw_data );
                    require_once( $plugin_fw_file );
                }
            }
        }

        /**
         * Load and register widgets
         *
         * @access public
         * @since 1.0.0
         */
        public function registerWidgets() {
            register_widget( 'YITH_Woocompare_Widget' );
        }

    }
}